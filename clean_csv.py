import pandas as pd
import os

# Path ke file CSV kamu (pastikan berada di direktori yang sama atau ganti path-nya)
input_file = 'data_bayes.csv'
output_file = 'data_bayes_cleaned.csv'

# Cek apakah file ada
if not os.path.exists(input_file):
    print(f"❌ File '{input_file}' tidak ditemukan.")
    exit()

# Baca file CSV
df = pd.read_csv(input_file)

# Tampilkan jumlah data awal dan nilai kosong
print(f"Jumlah data awal: {len(df)}")
print("Nilai kosong per kolom:")
print(df.isnull().sum())

# Bersihkan: hapus baris yang memiliki nilai kosong
df_cleaned = df.dropna()

# Simpan ke file baru
df_cleaned.to_csv(output_file, index=False)

# Konfirmasi
print(f"\n✔ File '{output_file}' berhasil dibuat.")
print(f"Jumlah data setelah dibersihkan: {len(df_cleaned)}")
