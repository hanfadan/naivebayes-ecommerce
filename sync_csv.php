<?php
/*  sync_csv.php  – ekspor dataset training Naive Bayes ke assets/survey_sync.csv  */
ini_set('display_errors',1); error_reporting(E_ALL);

$mysqli = new mysqli('localhost','root','','pro_naive_bayes');
if ($mysqli->connect_errno) die($mysqli->connect_error);

$outDir = __DIR__.'/assets';
if (!is_dir($outDir)) mkdir($outDir,0777,true);
$csv    = $outDir.'/survey_sync.csv';
$fh     = fopen($csv,'w');

/* header */
fputcsv($fh,[
  'user_id','gender','age_group','income_band','job_status',
  'buy_freq','budget_band','style','category','label'
]);

/* query gabungan — pakai transactions t -> user u */
$sql = "
 SELECT
   u.id                                 AS user_id,
   u.gender, u.age_group, u.income_band, u.job_status,

   (SELECT answer FROM survey_responses
     WHERE user_id=u.id AND qcode='buy_freq'   LIMIT 1) AS buy_freq,

   (SELECT answer FROM survey_responses
     WHERE user_id=u.id AND qcode='budget_band' LIMIT 1) AS budget_band,

   (SELECT GROUP_CONCAT(style_slug)
     FROM user_styles WHERE user_id=u.id) AS style,

   c.name                                AS category,
   IF(p.stok > 50, 1, 0)                 AS label        -- stok banyak = 1
 FROM transactions_details  td
 JOIN transactions          t  ON t.id        = td.tran_id
 JOIN users                 u  ON u.id        = t.user_id
 JOIN products              p  ON p.id        = td.product_id
 JOIN categories            c  ON c.id        = p.category_id
 GROUP BY u.id, p.id
";

$res = $mysqli->query($sql) or die($mysqli->error);
while ($row = $res->fetch_assoc()) fputcsv($fh,$row);
fclose($fh);

echo "✔ dataset CSV dibuat (".$res->num_rows." baris) → $csv\n";
