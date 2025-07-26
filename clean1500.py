import pandas as pd

# Langkah 1: Load dataset awal
df = pd.read_csv('data_bayes_cleaned.csv')

# Langkah 2: Tampilkan jumlah awal dan cek kolom
print("Jumlah data awal:", len(df))
print("Kolom:", df.columns.tolist())

# Langkah 3: Ganti nama kolom jika tidak rapi (opsional)
# Misalnya jika kolom pertama bernama "35+" bisa diganti jadi "age_group"
df.columns = [
    "age_group", "gender", "category", "budget_band",
    "price_band", "buy_freq", "buy_factor", "channel_main",
    "review_consider", "eco_interest", "eco_paymore",
    "brand_preference", "style_pref"
]

# Langkah 4: Hapus baris yang memiliki nilai kosong
df_cleaned = df.dropna()
print("Setelah drop NA:", len(df_cleaned))

# Langkah 5: Ambil 1500 data secara acak dari data bersih
df_sampled = df_cleaned.sample(n=1500, random_state=42)

# Langkah 6: Simpan ke file baru
df_sampled.to_csv('data_bayes_cleaned_1500.csv', index=False)
print("✔ File data_bayes_cleaned_1500.csv berhasil disimpan.")
