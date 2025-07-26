import pandas as pd

# Load data
df = pd.read_csv("data_bayes_cleaned_3classes_final_tuned.csv")
print("Jumlah data awal:", len(df))

# Tampilkan distribusi awal
print("\nDistribusi awal:")
print(df["style_pref"].value_counts())

# Ambil 300 data dari masing-masing kelas
df_formal = df[df["style_pref"] == "formal"].sample(n=300, random_state=42)
df_kasual = df[df["style_pref"] == "kasual"].sample(n=300, random_state=42)

# Gabungkan kembali
df_balanced = pd.concat([df_formal, df_kasual]).sample(frac=1, random_state=42).reset_index(drop=True)

# Tampilkan distribusi akhir
print("\nDistribusi setelah penyeimbangan:")
print(df_balanced["style_pref"].value_counts())

# Simpan ke file baru
df_balanced.to_csv("data_bayes_cleaned_3classes_balanced.csv", index=False)
print("\nData tersimpan sebagai 'data_bayes_cleaned_3classes_balanced.csv'")
