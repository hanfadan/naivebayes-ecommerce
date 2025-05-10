<?php
// seed_admin.php
$mysqli = new mysqli('localhost','root','','pro_naive_bayes');
if ($mysqli->connect_errno) {
    die("Connect failed: ".$mysqli->connect_error);
}

$rawPassword = 'admin1234';
$hash       = password_hash($rawPassword, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare(
  "INSERT INTO users
   (name,email,phone,birth,gender,address,password,role,status,
    age_group,income_band,job_status)
   VALUES (?,?,?,?,?,?,?,?,?,?,?,?)"
) or die($mysqli->error);

// Sesuaikan ENUM yang valid:
$params = [
  'Admin',                // name
  'admin@toko.com',       // email
  '081234567890',         // phone
  '1980-01-01',           // birth
  'm',                    // gender
  'Kantor Pusat',         // address
  $hash,                  // password (hash)
  'admin',                // role
  1,                      // status aktif
  '45+',                  // **age_group**  ← pakai yang valid
  '>10jt',                // income_band  (pastikan juga valid)
  'Pegawai'               // job_status   (pastikan juga valid)
];

$stmt->bind_param('sssssssissss', ...$params);
if ($stmt->execute()) {
    echo "✔ Admin berhasil dibuat (email: admin@toko.com, pwd: admin1234)\n";
} else {
    echo "‼ Gagal: ".$stmt->error."\n";
}
