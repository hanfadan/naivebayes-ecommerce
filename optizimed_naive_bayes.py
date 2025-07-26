import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import OrdinalEncoder
from sklearn.naive_bayes import CategoricalNB
from sklearn.metrics import classification_report, accuracy_score

# Step 1: Load dataset
df = pd.read_csv("data_bayes_cleaned_1500_simplified.csv")
print("Jumlah data:", len(df))

# Step 2: Gabungkan label style_pref
gabung_style = {
    "casual": "kasual", "kasual": "kasual", "klasik": "kasual", "trendi": "kasual",
    "formal": "formal", "minimalis": "minimalis", "minimalist": "minimalis",
    "sporty": "sporty", "streetwear": "sporty", "bohemian": "kasual", "vintage": "kasual"
}
df["style_pref"] = df["style_pref"].replace(gabung_style)

# Step 3: Pilih fitur
fitur = [
    "umur", "gender", "kategori_produk", "budget_band",
    "buy_freq", "review_consider", "brand_pref"
]
X = df[fitur]
y = df["style_pref"]

# Step 4: Encode fitur
encoder = OrdinalEncoder()
X_encoded = encoder.fit_transform(X)

# Step 5: Split
X_train, X_test, y_train, y_test = train_test_split(
    X_encoded, y, test_size=0.3, random_state=42, stratify=y
)

# Step 6: Train Naive Bayes
model = CategoricalNB()
model.fit(X_train, y_train)

# Step 7: Evaluasi
y_pred = model.predict(X_test)
print("\nAkurasi:", accuracy_score(y_test, y_pred))
print("\n=== Classification Report ===")
print(classification_report(y_test, y_pred))
