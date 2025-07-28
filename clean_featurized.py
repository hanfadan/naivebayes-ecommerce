import pandas as pd

# Load data
df = pd.read_csv("data_bayes_cleaned_3classes_balanced_v2.csv")
print("Jumlah data awal:", len(df))
print("Kolom yang tersedia:", df.columns.tolist())

# 1. Kelompokkan usia (dari 'age_group')
df["age_group"] = df["age_group"].replace({
    "18-24": "<25",
    "25-34": "25-35",
    "35+": ">35"
})

# 2. Binning kategori harga (price_band)
df["price_band"] = df["price_band"].replace({
    "low": "murah",
    "medium": "sedang",
    "high": "mahal"
})

# 3. Sederhanakan frekuensi pembelian (buy_freq)
df["buy_freq"] = df["buy_freq"].replace({
    "1x/bulan": "jarang",
    "2-3x/bulan": "sering",
    "4x/bulan": "sering"
})

# 4. Kelompokkan preferensi brand (brand_preference)
brand_mapping = {
    "zara": "moderat", "uniqlo": "moderat", "bershka": "moderat",
    "h&m": "kasual", "pull&bear": "kasual", "stradivarius": "kasual",
    "lv": "formal", "gucci": "formal", "prada": "formal"
}
df["brand_preference"] = df["brand_preference"].str.lower().map(brand_mapping).fillna("moderat")

# Simpan hasil
df.to_csv("data_bayes_cleaned_featurized.csv", index=False)
print("✅ Data berhasil disimpan ke 'data_bayes_cleaned_featurized.csv'")
