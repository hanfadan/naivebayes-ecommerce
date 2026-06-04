<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class NaiveBayesService
{
    private array $trainingSet = [];
    private array $model = [];

    private function loadTrainingSet(): void
    {
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
  SELECT user_id, style_slug FROM user_styles GROUP BY user_id ORDER BY COUNT(*) DESC
) us ON us.user_id = u.id
LEFT JOIN (
  SELECT user_id, color_slug FROM user_colors GROUP BY user_id ORDER BY COUNT(*) DESC
) uc ON uc.user_id = u.id
GROUP BY td.id
SQL;

        try {
            $rows = DB::select($sql);
            $this->trainingSet = array_map(fn($r) => (array) $r, $rows);
        } catch (\Exception $e) {
            error_log('Bayes fallback: ' . $e->getMessage());
            $rows = DB::select("
                SELECT c.slug AS kategori,
                       CASE WHEN p.stok>50 THEN 'tersedia' ELSE 'kosong' END AS status
                FROM transactions_details td
                JOIN products p ON p.id=td.product_id
                JOIN categories c ON c.id=p.category_id
            ");
            $this->trainingSet = array_map(fn($r) => (array) $r, $rows);
        }
    }

    public function train(): void
    {
        $this->loadTrainingSet();

        $freq   = [];
        $labels = [];
        $N      = 0;

        foreach ($this->trainingSet as $row) {
            if (!isset($row['status'])) continue;

            $w   = (float) $row['status'];
            $bkt = $w < 1 ? 0 : ($w < 2 ? 1 : 2);

            $labels[$bkt] = ($labels[$bkt] ?? 0) + 1;

            foreach ($row as $k => $v) {
                if (in_array($k, ['status', 'stok', 'terjual'])) continue;
                $v = $v ?: 'unknown';
                $freq[$k][$v][$bkt] = ($freq[$k][$v][$bkt] ?? 0) + 1;
            }
            $N++;
        }

        $this->model = compact('freq', 'labels', 'N');
    }

    public function predict(array $x, float $alpha = 1): array
    {
        if (!$this->model) $this->train();

        ['freq' => $freq, 'labels' => $labels, 'N' => $N] = $this->model;
        $post = [];

        foreach ($labels as $lbl => $cnt) {
            $p = ($cnt + $alpha) / ($N + $alpha * count($labels));
            foreach ($x as $f => $v) {
                $num   = $freq[$f][$v][$lbl] ?? 0;
                $kCard = isset($freq[$f]) ? count($freq[$f]) : 1;
                $p    *= ($num + $alpha) / ($cnt + $alpha * $kCard);
            }
            $post[$lbl] = $p;
        }

        $sum = array_sum($post);
        foreach ($post as $lbl => $v) {
            $post[$lbl] = $sum > 0 ? $v / $sum : 0;
        }
        arsort($post);

        return [
            'label'      => (int) array_key_first($post),
            'confidence' => reset($post),
            'posterior'  => $post,
        ];
    }

    public function posteriorPerKategori(array $x, float $alpha = 1): array
    {
        if (!$this->model) $this->train();

        $freq  = $this->model['freq'];
        $post  = [];

        foreach ($freq['kategori'] ?? [] as $catVal => $_) {
            $x['kategori'] = $catVal;
            $post[$catVal] = $this->predict($x, $alpha)['posterior'][1] ?? 0;
        }
        arsort($post);
        return $post;
    }

    public function recommendProducts(array $x, int $limit = 8): array
    {
        $userCat = $x['kategori'] ?? null;

        if ($userCat && $userCat !== 'all') {
            $catName = DB::table('categories')->where('slug', $userCat)->value('name')
                ?: ucfirst(str_replace('-', ' ', $userCat));
            $topCats = [$catName];
        } else {
            if (!empty(request('search'))) {
                $hint = DB::table('products as p')
                    ->join('categories as c', 'c.id', '=', 'p.category_id')
                    ->where('p.name', 'LIKE', '%' . request('search') . '%')
                    ->value('c.name');
                if ($hint) $x['kategori'] = $hint;
            }
            $postCats = $this->posteriorPerKategori($x);
            $topCats  = array_slice(array_keys($postCats), 0, 7);
        }

        $rows = DB::table('products as p')
            ->select('p.*', 'c.name as category')
            ->leftJoin('categories as c', 'c.id', '=', 'p.category_id')
            ->where('p.stok', '>', 0)
            ->whereIn('c.name', $topCats)
            ->get()
            ->toArray();

        $rows = array_map(fn($r) => (array) $r, $rows);
        shuffle($rows);
        return array_slice($rows, 0, $limit);
    }
}
