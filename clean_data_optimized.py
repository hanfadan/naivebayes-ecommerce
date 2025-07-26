import pandas as pd

# Load data
df = pd.read_csv("data_bayes_cleaned_3classes.csv")
print("Jumlah awal:", len(df))

# Filter hanya style_pref yang valid
df = df[df["style_pref"].isin(["kasual", "klasik", "formal"])]

# Normalisasi kategori style_pref
df["style_pref"] = df["style_pref"].replace({
    "kasual": "kasual",
    "klasik": "klasik",
    "formal": "formal"
})

# Buang data yang tidak konsisten antara budget dan price band
def is_consistent(row):
    if row["budget_band"] == ">600k" and row["price_band"] == "murah":
        return False
    if row["budget_band"] == "<100k" and row["price_band"] == "mahal":
        return False
    return True

df = df[df.apply(is_consistent, axis=1)]

# Pastikan seimbang 300 per kelas (jika tersedia)
final_df = pd.concat([
    df[df["style_pref"] == "kasual"].sample(n=300, random_state=42),
    df[df["style_pref"] == "klasik"].sample(n=300, random_state=42),
    df[df["style_pref"] == "formal"].sample(n=300, random_state=42)
])

# Reset index
final_df = final_df.reset_index(drop=True)

# Simpan hasil
final_df.to_csv("data_bayes_cleaned_3classes_optimized.csv", index=False)
print("Selesai! Data disimpan sebagai 'data_bayes_cleaned_3classes_optimized.csv'")
print("Jumlah data akhir:", len(final_df))
print(final_df["style_pref"].value_counts())
