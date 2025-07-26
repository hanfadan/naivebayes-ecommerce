import pymysql
import random
from datetime import datetime, timedelta

# Koneksi ke database
conn = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    database='pro_naive_bayes',
    charset='utf8mb4',
    autocommit=True
)
cursor = conn.cursor()

warna_choices = ['hitam', 'putih', 'merah', 'biru', 'hijau', 'coklat']
for warna in warna_choices:
    cursor.execute("INSERT IGNORE INTO colors (slug, name) VALUES (%s, %s)", (warna, warna.capitalize()))

style_choices = ['casual', 'streetwear', 'formal', 'vintage', 'minimalist']
for style in style_choices:
    cursor.execute("INSERT IGNORE INTO styles (slug, name) VALUES (%s, %s)", (style, style.capitalize()))
    
brand_choices = ['Zara', 'H&M', 'Uniqlo', 'LocalBrand']
for brand in brand_choices:
    cursor.execute("INSERT IGNORE INTO brands (slug, name) VALUES (%s, %s)", (brand, brand))

# --- Konfigurasi ---
jumlah_user = 500
gender_choices = ['m', 'f']
style_choices = ['casual', 'streetwear', 'formal', 'vintage', 'minimalist']
warna_choices = ['hitam', 'putih', 'merah', 'biru', 'hijau', 'coklat']
brand_choices = ['Zara', 'H&M', 'Uniqlo', 'LocalBrand']
survey_questions = {
    'buy_freq': ['Setiap minggu', 'Setiap bulan', 'Beberapa kali setahun'],
    'buy_factor': ['Harga', 'Gaya', 'Brand', 'Review'],
    'channel_main': ['Marketplace', 'Website brand', 'Offline store'],
    'review_consider': ['Selalu', 'Kadang-kadang', 'Tidak pernah'],
    'eco_interest': ['Ya', 'Tidak'],
    'eco_paymore': ['Ya', 'Tidak']
}

# Ambil produk acak
cursor.execute("SELECT id FROM products ORDER BY RAND() LIMIT 1")
produk = cursor.fetchone()
produk_id = produk[0] if produk else 1

# Insert data
for i in range(jumlah_user):
    name = f'dummy_user_{i+1}'
    email = f'{name}@example.com'
    gender = random.choice(gender_choices)
    birth = datetime.now() - timedelta(days=random.randint(20*365, 35*365))
    password = 'dummy123'

    # 1. Tambah user
    cursor.execute("""
        INSERT INTO users (name, email, gender, birth, password, role)
        VALUES (%s, %s, %s, %s, %s, 'user')
    """, (name, email, gender, birth.strftime('%Y-%m-%d'), password))

    user_id = cursor.lastrowid

    # 2. Label gaya (target)
    cursor.execute("INSERT INTO user_styles (user_id, style_slug) VALUES (%s, %s)",
                   (user_id, random.choice(style_choices)))

    # 3. Warna favorit
    cursor.execute("INSERT INTO user_colors (user_id, color_slug) VALUES (%s, %s)",
                   (user_id, random.choice(warna_choices)))

    # 4. Merek favorit
    cursor.execute("INSERT INTO user_brands (user_id, brand_slug) VALUES (%s, %s)",
                   (user_id, random.choice(brand_choices)))

    # 5. Kuisioner
    for qcode, answers in survey_questions.items():
        cursor.execute("""
            INSERT INTO survey_responses (user_id, qcode, answer)
            VALUES (%s, %s, %s)
        """, (user_id, qcode, random.choice(answers)))

    # 6. Transaksi
    invoice = f'INV{datetime.now().strftime("%Y%m%d")}{i:04d}'
    cursor.execute("""
        INSERT INTO transactions (invoice, user_id, total, created)
        VALUES (%s, %s, %s, NOW())
    """, (invoice, user_id, 1))

    tran_id = cursor.lastrowid

    # 7. Transaksi detail
    cursor.execute("""
        INSERT INTO transactions_details (tran_id, product_id, qty, price)
        VALUES (%s, %s, %s, %s)
    """, (tran_id, produk_id, 1, 1))

# Selesai
cursor.close()
conn.close()
print("✅ Feeder selesai: 500 data dummy berhasil disisipkan.")
