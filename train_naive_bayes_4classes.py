import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import OneHotEncoder
from sklearn.naive_bayes import MultinomialNB
from sklearn.metrics import accuracy_score, classification_report

# STEP 1: Load data
df = pd.read_csv("data_bayes_cleaned_1500_simplified.csv")
print("Jumlah data:", len(df))

# Cek kolom target
target_column = "style_pref"
print("\nJumlah kategori setelah digabung:")
print(df[target_column].value_counts())

# STEP 2: Pisahkan fitur dan label
X = df.drop(columns=[target_column])
y = df[target_column]

# STEP 3: One-hot encode semua fitur kategorikal
encoder = OneHotEncoder()
X_encoded = encoder.fit_transform(X)

# STEP 4: Split train/test
X_train, X_test, y_train, y_test = train_test_split(
    X_encoded, y, test_size=0.3, random_state=42
)

# STEP 5: Latih model
model = MultinomialNB()
model.fit(X_train, y_train)

# STEP 6: Evaluasi
y_pred = model.predict(X_test)
print("\nAkurasi:", accuracy_score(y_test, y_pred))
print("\n=== Classification Report ===")
print(classification_report(y_test, y_pred))
