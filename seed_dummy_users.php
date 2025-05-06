<?php
/*  seed_dummy_users.php
    ------------------------------------------------------------
    Mengisi:
      - users (300 baris dummy)
      - survey_responses
      - user_styles
      - user_colors
      - user_brands
    ------------------------------------------------------------ */
ini_set('display_errors',1); error_reporting(E_ALL);

/* ---------- koneksi MySQL ---------- */
$mysqli = new mysqli('localhost','root','','pro_naive_bayes');
if ($mysqli->connect_errno) die("MySQL error: ".$mysqli->connect_error);

/* ---------- kamus data acak ---------- */
$age     = ['18-24','25-34','35-44','45+'];
$income  = ['<2jt','2-5jt','5-10jt','>10jt'];
$job     = ['Pelajar','Mahasiswa','Pegawai','Wiraswasta','Freelance','Lainnya'];
$buyFreq = ['Setiap minggu','Setiap bulan','Beberapa bulan','Jarang'];
$budget  = ['<100k','100-300k','300-600k','>600k'];
$faktor  = ['Harga','Kualitas','Merek','Trend'];
$channel = ['Marketplace','Sosmed','Web brand','Offline'];
$review  = ['Tak pernah','Kadang','Sering','Selalu'];
$brands  = ['Uniqlo','H&M','Zara','Adidas','Nike','Levis'];

/* ---------- ambil atau fallback style & color ---------- */
$styles = array_column(
            $mysqli->query("SELECT slug FROM styles")->fetch_all(MYSQLI_NUM)
           ?: [['kasual'],['formal'],['sporty']], 0);

$colors = array_column(
            $mysqli->query("SELECT slug FROM colors")->fetch_all(MYSQLI_NUM)
           ?: [['hitam'],['putih'],['biru']], 0);

/* ---------- prepared statements ---------- */
$stUser = $mysqli->prepare(
  "INSERT INTO users
   (name,email,phone,birth,gender,address,password,role,status,
    age_group,income_band,job_status)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)")       or die("prep user: ".$mysqli->error);

$stResp  = $mysqli->prepare(
  "INSERT INTO survey_responses(user_id,qcode,answer) VALUES (?,?,?)")
  or die("prep resp: ".$mysqli->error);

$stStyle = $mysqli->prepare(
  "INSERT INTO user_styles(user_id,style_slug) VALUES (?,?)")
  or die("prep style: ".$mysqli->error);

$stColor = $mysqli->prepare(
  "INSERT INTO user_colors(user_id,color_slug) VALUES (?,?)")
  or die("prep color: ".$mysqli->error);

$stBrand = $mysqli->prepare(
  "INSERT INTO user_brands(user_id,brand_name,freq) VALUES (?,?,?)")
  or die("prep brand: ".$mysqli->error);

/* ---------- generator 300 user ---------- */
for ($i = 1; $i <= 300; $i++) {

    /* --- data pokok user --- */
    $name   = "dummy_$i";
    $email  = "d$i@test";
    $phone  = "08".rand(1000000000,9999999999);
    $birth  = '2000-01-01';
    $gender = $i % 2 ? 'm' : 'f';
    $addr   = '-';
    $pass   = '-';
    $role   = 'user';
    $status = 1;
    $ageGrp = $age[array_rand($age)];
    $incGrp = $income[array_rand($income)];
    $jobGrp = $job[array_rand($job)];

    $stUser->bind_param(
        'sssssssissss',
        $name,$email,$phone,$birth,$gender,$addr,$pass,
        $role,$status,$ageGrp,$incGrp,$jobGrp
    );
    $stUser->execute();
    $uid = $mysqli->insert_id;

    /* --- survey (single choice) --- */
    foreach ([
        ['buy_freq',      $buyFreq],
        ['budget_band',   $budget],
        ['buy_factor',    $faktor],
        ['channel_main',  $channel],
        ['review_consider',$review],
        ['eco_interest', ['Tidak tertarik','Agak tertarik','Tertarik']],
        ['eco_paymore',  ['Ya','Tidak','Mungkin']]
    ] as [$qcode,$arr]) {

        $ans = $arr[array_rand($arr)];
        $stResp->bind_param('iss',$uid,$qcode,$ans);
        $stResp->execute();
    }

    /* --- multi style (1-3) --- */
    $randStyleKeys = (array) array_rand(
        $styles, rand(1, min(3, count($styles)))
    );
    foreach ($randStyleKeys as $k) {
        $slug = $styles[$k];
        $stStyle->bind_param('is',$uid,$slug);
        $stStyle->execute();
    }

    /* --- multi color (1-2) --- */
    $randColorKeys = (array) array_rand(
        $colors, rand(1, min(2, count($colors)))
    );
    foreach ($randColorKeys as $k) {
        $slug = $colors[$k];
        $stColor->bind_param('is',$uid,$slug);
        $stColor->execute();
    }

    /* --- preferensi brand (≈50 %) --- */
    if (rand(0,1)) {
        $brandName = $brands[array_rand($brands)];
        $freq      = ['Sering','Kadang','Jarang'][rand(0,2)];
        $stBrand->bind_param('iss',$uid,$brandName,$freq);
        $stBrand->execute();
    }
}

echo "✔ 300 user + kuesioner selesai\n";
