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

    private function loadTrainingSet(string $csv = null): void
    {
        if ($this->trainingSet) return;   // sudah ada

        /* --------- ambil data transaksi (DB) --------- */
        $sql = "SELECT
                    CASE
                        WHEN TIMESTAMPDIFF(YEAR, u.birth, CURDATE()) BETWEEN 18 AND 24 THEN '18-24'
                        WHEN TIMESTAMPDIFF(YEAR, u.birth, CURDATE()) BETWEEN 25 AND 34 THEN '25-34'
                        ELSE '35+'
                    END                    AS umur,
                    c.name                 AS kategori,
                    u.gender               AS gender,
                    IF(p.stok > 50, 1, 0)  AS status   -- label
                FROM transactions_details td
                JOIN products       p ON p.id = td.product_id
                JOIN categories     c ON c.id = p.category_id
                JOIN users          u ON u.id = td.user_id";
        $this->trainingSet = $this->db->rawQuery($sql);

        /* --------- (opsional) gabung CSV kuesioner --------- */
        if ($csv && is_readable($csv)) {
            if (($h = fopen($csv, 'r')) !== false) {
                $header = array_map('trim', fgetcsv($h));
                while ($row = fgetcsv($h)) {
                    $assoc = array_combine($header, $row);
                    $this->trainingSet[] = [
                        'umur'     => $assoc['Usia'],
                        'kategori' => $assoc['Apa gaya berpakaian...'],  // sesuaikan nama kolom
                        'gender'   => strtolower($assoc['Jenis Kelamin']) === 'laki-laki' ? 'm' : 'f',
                        'status'   => (int)$assoc['Label Persediaan']     // tambahkan kolom label di CSV
                    ];
                }
                fclose($h);
            }
        }
    }

    public function trainNaiveBayes(string $csv = null): void
    {
        $this->loadTrainingSet($csv);   // isi $this->trainingSet

        $freq   = [];   // [$field][$value][$label] => count
        $labels = [];   // [$label] => count
        $N      = count($this->trainingSet);

        foreach ($this->trainingSet as $row) {
            $label = $row['status'];
            $labels[$label] = ($labels[$label] ?? 0) + 1;
            foreach ($row as $k => $v) {
                if ($k === 'status') continue;
                $freq[$k][$v][$label] = ($freq[$k][$v][$label] ?? 0) + 1;
            }
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
        // 1. latih / muat model (cache di properti)
        $this->trainNaiveBayes(APP_PATH.'/assets/survey.csv');

        // 2. prediksi kategori yg paling mungkin
        $predict = $this->predictNaiveBayes($x);      // ['posterior'=>…, 'label'=>1]
        $topKat  = $x['kategori'];                    // pakai input gaya
        // kalau mau mapping otomatis:
        // $topKat = array_key_first($predict['posterior_per_kategori']);

        // 3. ambil produk laris sesuai kategori (persediaan banyak)
        $sql = "SELECT SUM(td.qty) qty, p.*, c.name category
                FROM transactions_details td
                JOIN products  p ON p.id = td.product_id
                JOIN categories c ON c.id = p.category_id
                WHERE c.name = ?                  /* hasil prediksi */
                GROUP BY td.product_id
                ORDER BY qty DESC
                LIMIT ?";
        return $this->db->rawQuery($sql, [$topKat, $limit]);
    }


}