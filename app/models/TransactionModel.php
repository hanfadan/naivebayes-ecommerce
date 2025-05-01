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

    private function loadTrainingSet(string $csvPath = null): void
    {
        if ($this->trainingSet) return;      // sudah pernah dimuat
    
        /* ---------- 1. coba query lengkap (dengan users) ---------- */
        $sqlFull = "
        SELECT
          CASE
            WHEN TIMESTAMPDIFF(YEAR,u.birth,CURDATE()) BETWEEN 18 AND 24 THEN '18-24'
            WHEN TIMESTAMPDIFF(YEAR,u.birth,CURDATE()) BETWEEN 25 AND 34 THEN '25-34'
            ELSE '35+'
          END                                       AS umur,
          c.name                                    AS kategori,
          u.gender                                  AS gender,
          /*—— label continuous = stok ÷ (terjual+1) ——*/
          (p.stok / (SUM(td.qty)+1))                AS status,
          SUM(td.qty)                               AS terjual,
          p.stok                                    AS stok
        FROM transactions_details td
        JOIN products   p ON p.id = td.product_id
        JOIN categories c ON c.id = p.category_id
        JOIN users      u ON u.id = td.user_id
        GROUP BY p.id
        ";
    
        try {
            $this->trainingSet = $this->db->rawQuery($sqlFull);
        } catch (\Exception $e) {
            /* ---------- 2. fallback: tidak ada tabel users ---------- */
            error_log('Bayes fallback (no users table): '.$e->getMessage());
    
            $sqlFallback = "
                SELECT
                    c.name             AS kategori,
                    IF(p.stok > 50,1,0) AS status
                FROM transactions_details td
                JOIN products   p ON p.id  = td.product_id
                JOIN categories c ON c.id  = p.category_id
            ";
            $this->trainingSet = $this->db->rawQuery($sqlFallback);
        }
    
        /* ---------- 3. gabung (opsional) dataset CSV ---------- */
        if ($csvPath && is_readable($csvPath)) {
            $csv = array_map('str_getcsv', file($csvPath));
            $header = array_map('trim', array_shift($csv));
            foreach ($csv as $row) {
                $this->trainingSet[] = array_combine($header, $row);
            }
        }
    }    

    public function trainNaiveBayes(string $csv = null): void
    {
        /* -- isi $this->trainingSet ------------------------------------------------ */
        $this->loadTrainingSet($csv);
    
        $freq   = [];          // [$field][$value][$bucket] => count
        $labels = [];          // [$bucket] => count
        $N      = 0;           // total contoh (setelah bucket)
    
        foreach ($this->trainingSet as $row) {
            if (!isset($row['status'])) continue;
    
            /* ----------- BUCKET stok/terjual -------------------------------------- */
            $w = (float)$row['status'];                // 0 … ∞
            if     ($w < 1) { $bkt = 0; }              // stok kecil
            elseif ($w < 2) { $bkt = 1; }              // stok sedang
            else            { $bkt = 2; }              // stok besar
    
            /* ----------- hitung label & frekuensi --------------------------------- */
            $labels[$bkt] = ($labels[$bkt] ?? 0) + 1;
            foreach ($row as $k => $v) {
                if (in_array($k, ['status','stok','terjual'])) continue;
                $freq[$k][$v][$bkt] = ($freq[$k][$v][$bkt] ?? 0) + 1;
            }
            $N++;
        }
    
        $this->model = compact('freq', 'labels', 'N');
    }
    

        /**
     * @param array $x contoh: ['umur'=>'18-24','kategori'=>'Kasual','gender'=>'m']
     * @return array hasil: ['label'=>1, 'confidence'=>0.83, 'posterior'=>[1=>0.83,0=>0.17]]
     */
    public function predictNaiveBayes(array $x, float $alpha = 1): array
    {
        if (!$this->model) $this->trainNaiveBayes();   // auto-train

        extract($this->model); // $freq, $labels, $N
        $post = [];

        foreach ($labels as $lbl => $cnt) {
            // prior
            $p = ($cnt + $alpha) / ($N + $alpha * count($labels));
            foreach ($x as $field => $val) {
                $num = $freq[$field][$val][$lbl] ?? 0;
                $den = $cnt;
                $kCard = isset($freq[$field]) ? count($freq[$field]) : 1;
                $p *= ($num + $alpha) / ($den + $alpha * $kCard);
            }
            $post[$lbl] = $p;
        }
        $sum = array_sum($post);
        foreach ($post as $lbl => $v) $post[$lbl] = $v / $sum;
        arsort($post);

        $labelPred   = (int)array_key_first($post);
        $confidence  = reset($post);

        return ['label' => $labelPred, 'confidence' => $confidence, 'posterior' => $post];
    }

    public function recommendProducts(array $x, int $limit = 8): array
    {
        /* ---------- 0. Apakah user memilih kategori secara eksplisit? ---------- */
        $userCat = $x['kategori'] ?? null;             // slug atau nama dari form
        if ($userCat && $userCat !== 'all') {
            /* form mengirim slug (mis. "jaket"), konversi ke name */
            $userCatName = $this->db->where('slug',$userCat)
                                    ->getValue('categories','name');
            if (!$userCatName) $userCatName = ucfirst(str_replace('-',' ',$userCat));
            $topCats = [$userCatName];                 // pakai kategori user saja
        } else {
            /* ---------- 1. Hint keyword pencarian (opsional) ---------- */
            if (!empty(post('search'))) {
                $kw = trim(post('search'));
                $catHint = $this->db->rawQueryOne(
                     "SELECT c.name FROM products p
                      JOIN categories c ON c.id=p.category_id
                      WHERE p.name LIKE ? LIMIT 1", ['%'.$kw.'%']);
                if ($catHint) $x['kategori'] = $catHint['name'];
            }
    
            /* ---------- 2. Dapatkan top-kategori via Naive Bayes ---------- */
            $posterior = $this->posteriorPerKategori($x);
            $topCats   = array_slice(array_keys($posterior), 0, 7);   // 7 teratas
        }
    
        /* ---------- 3. Query produk stok>0 di kategori pilihan ---------- */
        $this->db->where('p.stok', 0, '>');
        $this->db->where('c.name', $topCats, 'IN');
        $this->db->join('categories c','c.id=p.category_id','LEFT');
        $rows = $this->db->get('products p', null, 'p.*, c.name AS category');
    
        /* ---------- 4. Acak, pilih $limit ---------- */
        shuffle($rows);
        return array_slice($rows, 0, $limit);
    }
    
    

    /**
 * Hitung posterior untuk setiap nilai kategori
 * – mengasumsikan $this->model sudah berisi ['freq','labels','N']
 * – menggunakan Laplace smoothing (alpha = 1)
 *
 * @return array  ex: ['Kasual'=>0.45,'Formal'=>0.32,'Vintage'=>0.10 …]
 */
public function posteriorPerKategori(array $x, float $alpha = 1): array
{
    if (!$this->model) {
        $this->trainNaiveBayes();           // pastikan sudah ter-train
    }
    $field = 'kategori';                    // fitur yang kita ranking
    extract($this->model);                  // $freq, $labels, $N

    $post = [];
    foreach ($freq[$field] as $catVal => $dummy) {
        $x[$field] = $catVal;               // set kategori yang diuji
        /* re-gunakan fungsi predict() untuk label 1 & 0 */
        $probTrue  = $this->predictNaiveBayes($x, $alpha)['posterior'][1] ?? 0;
        $post[$catVal] = $probTrue;
    }
    arsort($post);                          // urutkan tinggi->rendah
    return $post;
}


}