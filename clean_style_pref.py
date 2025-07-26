import pandas as pd

# Baca CSV
df = pd.read_csv("data_bayes_cleaned_1500.csv")

# Gabungkan label style_pref yang sejenis
label_map = {
    "casual": "kasual",
    "kasual": "kasual",
    "trendi": "kasual",
    "minimalist": "minimalis",
    "minimalis": "minimalis",
    "bohemian": "vintage",
    "vintage": "vintage",
    "streetwear": "sporty",
    "sporty": "sporty",
    "formal": "formal",
    "klasik": "formal"  # asumsikan klasik masuk ke formal
}

df["style_pref"] = df["style_pref"].replace(label_map)

# Cek hasil distribusi setelah mapping
print("Distribusi label baru:")
print(df["style_pref"].value_counts())

# Simpan ke file baru
df.to_csv("data_bayes_cleaned_1500_simplified.csv", index=False)
print("\n✔️ File disimpan: data_bayes_cleaned_1500_simplified.csv")
