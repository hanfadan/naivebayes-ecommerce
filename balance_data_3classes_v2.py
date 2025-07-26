from google.colab import files
uploaded = files.upload()

import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.naive_bayes import CategoricalNB
from sklearn.metrics import accuracy_score, classification_report, confusion_matrix

# STEP 1: Load dataset
df = pd.read_csv("data_bayes_cleaned_3classes_balanced.csv")
print("Jumlah data:", len(df))

# STEP 2: Cek distribusi label
print("\nJumlah kategori setelah digabung:")
print(df["style_pref"].value_counts())

# STEP 3: Pisahkan fitur dan label
X = df.drop("style_pref", axis=1)
y = df["style_pref"]

# STEP 4: Split dataset
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=42)

# STEP 5: Encode fitur secara aman hanya dari training set
le_dict = {}
for col in X.columns:
    le = LabelEncoder()
    X_train[col] = le.fit_transform(X_train[col])
    X_test[col] = le.transform(X_test[col])  # hanya transform, tidak fit ulang!
    le_dict[col] = le

# STEP 6: Encode label target
le_target = LabelEncoder()
y_train = le_target.fit_transform(y_train)
y_test = le_target.transform(y_test)

# STEP 7: Inisialisasi dan latih model Naive Bayes
model = CategoricalNB()
model.fit(X_train, y_train)

# STEP 8: Prediksi
y_pred = model.predict(X_test)

# STEP 9: Evaluasi hasil
print("\nAkurasi:", accuracy_score(y_test, y_pred))
print("\n=== Classification Report ===")
print(classification_report(y_test, y_pred))
print("\n=== Confusion Matrix ===")
print(confusion_matrix(y_test, y_pred))
