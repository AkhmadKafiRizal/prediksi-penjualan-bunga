import pandas as pd
from sklearn.linear_model import LinearRegression
import os

# =========================
# Mendapatkan lokasi file python
# =========================
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# lokasi dataset
dataset_path = os.path.join(BASE_DIR, "..", "dataset", "cleaned_flower_sales_dataset.csv")

# =========================
# Membaca dataset
# =========================
try:
    data = pd.read_csv(dataset_path)
except Exception as e:
    print("Gagal membaca dataset:", e)
    exit()

# =========================
# Validasi kolom
# =========================
if "QUANTITYORDERED" not in data.columns:
    print("Kolom tersedia:", list(data.columns))
    print("Kolom QUANTITYORDERED tidak ditemukan.")
    exit()

# =========================
# Membuat variabel waktu
# =========================
data["X"] = range(1, len(data) + 1)

X = data[["X"]]
Y = data["QUANTITYORDERED"]

# =========================
# Model regresi
# =========================
model = LinearRegression()
model.fit(X, Y)

# =========================
# Prediksi bulan berikutnya
# =========================
next_month = len(data) + 1
next_data = pd.DataFrame({"X": [next_month]})
prediction = model.predict(next_data)

print("Total data:", len(data))
print("Prediksi penjualan bulan berikutnya:", int(prediction[0]))