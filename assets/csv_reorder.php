<?php
/*  CONFIG  -------------------------------------------------------------- */
$src  = __DIR__ . '/survey_sync.csv';          // ← nama file sumber BARU
$dest = __DIR__ . '/survey_sync_150rows.csv';  // ← nama file hasil ekstrak

$delimiter = ',';                              // ganti ke ';' atau "\t" jika perlu
$maxRows   = 150;                              // jumlah baris yang ingin di‑salin
$encoding  = 'UTF-8';                          // target encoding
/* ---------------------------------------------------------------------- */

/* helper kecil untuk menghentikan eksekusi dg pesan rapi */
function bail(string $msg): void {
    fwrite(STDERR, "[ERR] $msg\n");
    exit(1);
}

/* 1) Buka file sumber */
$in = fopen($src, 'r') ?: bail("Tidak bisa membuka $src");

/* 2) Buka / buat file tujuan */
$out = fopen($dest, 'w') ?: bail("Tidak bisa menulis $dest");

/* 3) Baca header, buang BOM jika ada */
$header = fgetcsv($in, 0, $delimiter);
if ($header === false) bail("File $src kosong / header tidak terbaca");

if (isset($header[0])) {
    // hapus BOM (EF BB BF) di kolom pertama
    $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
}
/* 4) Pastikan header UTF‑8 */
$header = array_map(fn($h) => mb_convert_encoding($h, $encoding, 'UTF-8,ISO-8859-1'), $header);
fputcsv($out, $header, $delimiter);

/* 5) Salin sampai batas maxRows atau EOF */
$copied = 0;
while (($row = fgetcsv($in, 0, $delimiter)) !== false) {
    // lewati baris kosong
    if ($row === [null] || $row === [] || trim(implode('', $row)) === '') continue;

    // konversi encoding untuk tiap sel
    $row = array_map(
        fn($v) => mb_convert_encoding($v, $encoding, 'UTF-8,ISO-8859-1'),
        $row
    );

    fputcsv($out, $row, $delimiter);
    if (++$copied >= $maxRows) break;
}

/* 6) Tutup handle */
fclose($in);
fclose($out);

echo "✅  Berhasil mengekstrak {$copied} baris ke {$dest}\n";
