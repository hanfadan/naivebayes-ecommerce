import pandas as pd

# Load data awal
df = pd.read_csv("data_bayes_cleaned_1500_simplified.csv")

# Gabungkan style ke 3 kelas utama
def simplify_style(style):
    style = style.lower()
    if style in ["klasik", "minimalis", "minimalist", "vintage"]:
        return "klasik"
    elif style in ["kasual", "casual", "streetwear", "trendi", "bohemian"]:
        return "kasual"
    elif style in ["formal", "sporty"]:
        return "formal"
    else:
        return None

df["style_pref"] = df["style_pref"].apply(simplify_style)

# Buang yang None
df = df[df["style_pref"].notnull()]

# Hitung jumlah minimum dari 3 kelas
min_count = df["style_pref"].value_counts().min()

print("Jumlah minimum per kelas yang tersedia:", min_count)

# Ambil sample dari tiap kelas sebanyak min_count
df_klasik = df[df["style_pref"] == "klasik"].sample(n=min_count, random_state=42)
df_kasual = df[df["style_pref"] == "kasual"].sample(n=min_count, random_state=42)
df_formal = df[df["style_pref"] == "formal"].sample(n=min_count, random_state=42)

# Gabungkan dan acak ulang
df_final = pd.concat([df_klasik, df_kasual, df_formal]).sample(frac=1, random_state=42).reset_index(drop=True)

# Simpan ke file baru
df_final.to_csv("data_bayes_cleaned_3classes.csv", index=False)

print("✔ Dataset disimpan sebagai 'data_bayes_cleaned_3classes.csv'")
print("\nJumlah per kelas:")
print(df_final["style_pref"].value_counts())
