<?php

class TransactionModel extends Model {

    private array  $trainingSet = [];
    private array  $model       = [];

    public function code(){
        $data = $this->db->rawQueryOne('SELECT max(RIGHT(invoice,4)) as code FROM transactions  WHERE DATE(created) = CURDATE()');
        $code = $data['code'];
        $order = intval($code);
        $order++;

		return 'INV'.date('Ymd'). sprintf('%04s', $order);
	}

    public function deleteCart($id) {
		return $this->db->where('id', $id)->delete('carts');
	}

    public function findAll() {
		$this->db->join('users b', 'a.user_id = b.id', 'LEFT');
        return $this->db->get('transactions a', null, 'a.id, a.total, a.invoice, b.name as user');
	}

    public function findDetails($invoice) {
		$trans = $this->db->where('invoice', $invoice)->getOne('transactions');

        $this->db->where('a.tran_id', $trans['id']);
        $this->db->join('products b', 'a.product_id = b.id', 'LEFT');
        return $this->db->get('transactions_details a', null, 'a.id, a.qty, a.price, b.name as product');
	}

    public function findLast() {
		return $this->db->getOne('transactions');
	}

    public function naiveBayes() {
        $query = 'SELECT SUM(transactions_details.qty) as qty, products.*, categories.name as category FROM transactions_details ';
        $query .= 'INNER JOIN products ON products.id=transactions_details.product_id ';
        $query .= 'INNER JOIN categories ON categories.id=products.category_id GROUP BY transactions_details.product_id ORDER BY qty DESC';

        return $this->db->rawQuery($query);
    }

    public function store($data) {
		return $this->db->insert('transactions', $data);
	}

    public function storeProduct($data) {
        if ($this->db->insertMulti('transactions_details', $data)) {
            return true;
        }
        
		return false;
	}

    public function totalAll() {
		return $this->db->getValue('transactions', 'count(id)') ?: 0;
	}

    public function totalMonth() {
        $this->db->where('YEAR(created)', date('Y'));
        $this->db->where('MONTH(created)', date('m'));
		return $this->db->getValue('transactions', 'count(id)') ?: 0;
	}

    public function totalNow() {
        $this->db->where('DATE(created)', date('Y-m-d'));
		return $this->db->getValue('transactions', 'count(id)') ?: 0;
	}

    public function totalUser() {
        $this->db->where('role', 'user');
		return $this->db->getValue('users', 'count(id)') ?: 0;
	}

    /**
     * Muat dataset transaksi + demografi + kuisioner + preferensi
     */
    private function loadTrainingSet(string $csvPath = null): void
    {
    // Enhanced loadTrainingSet to include new product features
    if ($this->trainingSet) return;

    $sql = <<<SQL
SELECT
  CASE
    WHEN TIMESTAMPDIFF(YEAR,u.birth,CURDATE()) BETWEEN 18 AND 24 THEN '18-24'
    WHEN TIMESTAMPDIFF(YEAR,u.birth,CURDATE()) BETWEEN 25 AND 34 THEN '25-34'
    ELSE '35+'
  END AS umur,
  u.gender AS gender,
  c.slug AS kategori,
  CASE
    WHEN p.price < 100000 THEN '<100k'
    WHEN p.price BETWEEN 100000 AND 300000 THEN '100-300k'
    WHEN p.price BETWEEN 300000 AND 600000 THEN '300-600k'
    ELSE '>600k'
  END AS budget_band,
  CASE
    WHEN p.price < 200000 THEN 'murah'
    WHEN p.price BETWEEN 200000 AND 500000 THEN 'sedang'
    ELSE 'mahal'
  END AS price_band,
  p.brand AS brand_pref,
  sr_buy.answer    AS buy_freq,
  sr_factor.answer AS buy_factor,
  sr_channel.answer AS channel_main,
  sr_review.answer  AS review_consider,
  sr_eco1.answer    AS eco_interest,
  sr_eco2.answer    AS eco_paymore,
  us.style_slug     AS style_pref,
  uc.color_slug     AS color_pref
FROM transactions_details td
JOIN products   p ON p.id    = td.product_id
JOIN categories c ON c.id    = p.category_id
JOIN users      u ON u.id    = td.user_id
LEFT JOIN survey_responses sr_buy    ON sr_buy.user_id=u.id    AND sr_buy.qcode='buy_freq'
LEFT JOIN survey_responses sr_factor ON sr_factor.user_id=u.id AND sr_factor.qcode='buy_factor'
LEFT JOIN survey_responses sr_channel ON sr_channel.user_id=u.id AND sr_channel.qcode='channel_main'
LEFT JOIN survey_responses sr_review  ON sr_review.user_id=u.id  AND sr_review.qcode='review_consider'
LEFT JOIN survey_responses sr_eco1    ON sr_eco1.user_id=u.id    AND sr_eco1.qcode='eco_interest'
LEFT JOIN survey_responses sr_eco2    ON sr_eco2.user_id=u.id    AND sr_eco2.qcode='eco_paymore'
LEFT JOIN (
  SELECT user_id, style_slug
  FROM user_styles
  GROUP BY user_id
  ORDER BY COUNT(*) DESC
) us ON us.user_id = u.id
LEFT JOIN (
  SELECT user_id, color_slug
  FROM user_colors
  GROUP BY user_id
  ORDER BY COUNT(*) DESC
) uc ON uc.user_id = u.id
GROUP BY td.id
SQL;

    try {
        $this->trainingSet = $this->db->rawQuery($sql);
    } catch (\Exception $e) {
        error_log("Bayes fallback: ".$e->getMessage());
        // fallback minimal
        $this->trainingSet = $this->db->rawQuery("
            SELECT c.slug AS kategori,
                   CASE WHEN p.stok>50 THEN 'tersedia' ELSE 'kosong' END AS status
            FROM transactions_details td
            JOIN products p ON p.id=td.product_id
            JOIN categories c ON c.id=p.category_id
        ");
    }

    // Merge additional CSV if provided
    if ($csvPath && is_readable($csvPath)) {
        $csv    = array_map('str_getcsv', file($csvPath));
        $header = array_map('trim', array_shift($csv));
        foreach ($csv as $row) {
            $this->trainingSet[] = array_combine($header, $row);
        }
    }

    }

/**
     * Bangun model frekuensi + prior dengan Laplace smoothing
     */
    public function trainNaiveBayes(string $csv = null): void
    {
        $this->loadTrainingSet($csv);

        $freq   = []; // [$feature][$value][$bucket] => count
        $labels = []; // [$bucket] => count
        $N      = 0;

        foreach ($this->trainingSet as $row) {
            if (!isset($row['status'])) continue;

            // bucket continuous label
            $w   = (float)$row['status'];
            $bkt = $w < 1 ? 0 : ($w < 2 ? 1 : 2);

            $labels[$bkt] = ($labels[$bkt] ?? 0) + 1;

            foreach ($row as $k => $v) {
                // skip internal kolom numerik
if (in_array($k, ['status','stok','terjual'])) continue;
                $v = $v ?: 'unknown'; // kategorikan kosong
                $freq[$k][$v][$bkt] = ($freq[$k][$v][$bkt] ?? 0) + 1;
            }
            $N++;
        }

        $this->model = compact('freq','labels','N');
    }
    

/**
     * Hitung posterior tiap bucket (0/1/2) untuk input $x
     */
    public function predictNaiveBayes(array $x, float $alpha = 1): array
    {
        if (!$this->model) $this->trainNaiveBayes();
        $result = $this->predictNaiveBayes([
  'umur'=>'25-34',
  'gender'=>'f',
  'kategori'=>'dress',
  'budget_band'=>'100-300k',
  'price_band'=>'sedang',
  'brand_pref'=>'Zara',
  'buy_freq'=>'Setiap bulan',
  'buy_factor'=>'...'
  // ... isi semua fitur
]);
var_dump($result);


        extract($this->model); // $freq,$labels,$N
        $post = [];

        foreach ($labels as $lbl => $cnt) {
            // prior P(Y=lbl)
            $p = ($cnt + $alpha) / ($N + $alpha * count($labels));
            foreach ($x as $f => $v) {
                $num  = $freq[$f][$v][$lbl] ?? 0;
                $den  = $cnt;
                $kCard= isset($freq[$f]) ? count($freq[$f]) : 1;
                $p   *= ($num + $alpha) / ($den + $alpha * $kCard);
            }
            $post[$lbl] = $p;
        }

        // normalisasi & sorting
        $sum = array_sum($post);
        foreach ($post as $lbl => $v) {
            $post[$lbl] = $sum>0 ? $v/$sum : 0;
        }
        arsort($post);

        return [
            'label'     => (int)array_key_first($post),
            'confidence'=> reset($post),
            'posterior' => $post
        ];
    }

    /**
     * Rekomendasikan produk: 
     * - pakai kategori user bila dipilih, 
     * - else ranking kategori dari posterior Bayes,
     * - lalu ambil produk stok>0 di kategori itu, shuffle & slice.
     */
    public function recommendProducts(array $x, int $limit = 8): array
    {
        $userCat = $x['kategori'] ?? null;
        if ($userCat && $userCat !== 'all') {
            $catName = $this->db->where('slug',$userCat)->getValue('categories','name')
                     ?: ucfirst(str_replace('-',' ',$userCat));
            $topCats = [$catName];
        } else {
            // opsi: hint keyword
            if (!empty(post('search'))) {
                $hint = $this->db->rawQueryOne(
                    "SELECT c.name FROM products p 
                     JOIN categories c ON c.id=p.category_id
                     WHERE p.name LIKE ? LIMIT 1", ['%'.post('search').'%']
                );
                if ($hint) $x['kategori'] = $hint['name'];
            }
            // ranking kategori
            $postCats = $this->posteriorPerKategori($x);
            $topCats   = array_slice(array_keys($postCats), 0, 7);
        }

        $this->db->where('p.stok', 0, '>');
        $this->db->where('c.name', $topCats, 'IN');
        $this->db->join('categories c','c.id=p.category_id','LEFT');
        $rows = $this->db->get('products p', null, 'p.*, c.name AS category');

        shuffle($rows);
        return array_slice($rows, 0, $limit);
    }
    
    

    /**
     * Ranking posterior per kategori
     */
    public function posteriorPerKategori(array $x, float $alpha = 1): array
    {
        if (!$this->model) $this->trainNaiveBayes();

        extract($this->model);
        $field = 'kategori';
        $post  = [];

        foreach ($freq[$field] as $catVal => $_) {
            $x[$field] = $catVal;
            $post[$catVal] = $this->predictNaiveBayes($x,$alpha)['posterior'][1] ?? 0;
        }
        arsort($post);
        return $post;
    }

}