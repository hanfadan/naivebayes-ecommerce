import pandas as pd

# STEP 1: Load data
df = pd.read_csv("data_bayes_cleaned_3classes_optimized.csv")
print("Jumlah data:", len(df))

# STEP 2: Normalisasi label style_pref
df["style_pref"] = df["style_pref"].replace({
    "formal": "formal",
    "klasik": "formal",       # Digabung sebagai 1 kelas formal
    "kasual": "kasual"        # Tetap kasual
})

# STEP 3: Normalisasi budget_band
df["budget_band"] = df["budget_band"].replace({
    "<100k": "<300k",
    "100-300k": "<300k",
    "300-600k": "300-600k",
    ">600k": ">600k"
})

# STEP 4: Normalisasi price_band
df["price_band"] = df["price_band"].replace({
    "murah": "murah",
    "sedang": "sedang",
    "mahal": "mahal"
})

# STEP 5: Normalisasi buy_freq
df["buy_freq"] = df["buy_freq"].replace({
    "Setiap minggu": "Sering",
    "Setiap bulan": "Sering",
    "Beberapa bulan": "Jarang",
    "Jarang": "Jarang"
})

# STEP 6: Normalisasi eco_interest dan eco_paymore
df["eco_interest"] = df["eco_interest"].replace({
    "Sangat tertarik": "Tertarik",
    "Agak tertarik": "Tertarik",
    "Netral": "Tidak Tertarik",
    "Kurang tertarik": "Tidak Tertarik",
    "Tidak tertarik": "Tidak Tertarik"
})

df["eco_paymore"] = df["eco_paymore"].replace({
    "Pasti": "Mungkin",
    "Mungkin": "Mungkin",
    "Tidak yakin": "Tidak",
    "Tidak": "Tidak"
})

# STEP 7: Cek distribusi setelah disederhanakan
print("\nJumlah kategori setelah disederhanakan:")
print(df["style_pref"].value_counts())

# STEP 8: Simpan dataset hasil tuning
df.to_csv("data_bayes_cleaned_3classes_final_tuned.csv", index=False)
print("\nDataset berhasil disimpan sebagai data_bayes_cleaned_3classes_final_tuned.csv")
