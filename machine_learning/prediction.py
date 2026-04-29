import pandas as pd
import json
from pymongo import MongoClient

from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_absolute_error, mean_squared_error
from sklearn.model_selection import train_test_split

# ====================================
# 1. Koneksi database MongoDB
# ====================================

try:
    client = MongoClient("mongodb://localhost:27017/")
    db = client["prediksi_bunga"]
    collection = db["penjualans"]
except Exception:
    print(json.dumps([]))
    exit()

# ====================================
# 2. Ambil data dari MongoDB
# ====================================

try:
    records = list(collection.find())

    data = pd.DataFrame(records)

    # Hapus kolom bawaan MongoDB / kolom yang tidak dipakai model
    kolom_dihapus = ["_id", "id", "created_at", "updated_at"]
    data = data.drop(columns=[kolom for kolom in kolom_dihapus if kolom in data.columns])

except Exception:
    print(json.dumps([]))
    exit()

# ====================================
# 3. Validasi data
# ====================================

if len(data) < 10:
    print(json.dumps([]))
    exit()

required_columns = ["product_id", "tanggal", "jumlah", "harga", "promo"]

if not all(col in data.columns for col in required_columns):
    print(json.dumps([]))
    exit()
# ====================================
# 4. Feature engineering dari tanggal
# ====================================

data["tanggal"] = pd.to_datetime(data["tanggal"])

data["weekday"] = data["tanggal"].dt.weekday #weekday = hari dalam minggu
data["month"] = data["tanggal"].dt.month #month = bulan
#bukti menunjukkan fitur waktu

# ====================================
# 5. Ambil semua produk
# ====================================

product_ids = sorted(data["product_id"].unique())

results = []

# ====================================
# 6. Loop model per produk
# ====================================

for pid in product_ids:

    df = data[data["product_id"] == pid].copy()

    # Pastikan urutan waktu benar
    df = df.sort_values("tanggal")

    if len(df) < 20:
        continue

    X = df[["harga", "promo", "weekday", "month"]]
    Y = df["jumlah"]

    # ====================================
    # 7. Split data: Train, Validation, Test
    # ====================================
    # Train      = 70%
    # Validation = 15%
    # Test       = 15%
    # shuffle=False karena data memiliki urutan waktu

    X_train, X_temp, y_train, y_temp = train_test_split(
        X,
        Y,
        test_size=0.30,
        shuffle=False
    )
#shuffle false karena memakai data time series. (TIDAK DIACAK) bukti
    X_val, X_test, y_val, y_test = train_test_split(
        X_temp,
        y_temp,
        test_size=0.50,
        shuffle=False
    )

    # ====================================
    # 8. Training model
    # ====================================

    model = LinearRegression()
    model.fit(X_train, y_train)

    # ====================================
    # 9. Validasi model
    # ====================================

    y_val_pred = model.predict(X_val)

    val_mae = mean_absolute_error(y_val, y_val_pred)
    val_rmse = mean_squared_error(y_val, y_val_pred) ** 0.5

    # ====================================
    # 10. Evaluasi final menggunakan data test
    # ====================================

    y_test_pred = model.predict(X_test)

    mae = mean_absolute_error(y_test, y_test_pred)
    rmse = mean_squared_error(y_test, y_test_pred) ** 0.5

    # ====================================
    # 11. Prediksi periode berikutnya
    # ====================================

    last_row = df.iloc[-1]

    next_data = pd.DataFrame({
        "harga": [last_row["harga"]],
        "promo": [last_row["promo"]],
        "weekday": [last_row["weekday"]],
        "month": [last_row["month"]]
    })

    prediction = model.predict(next_data)
    prediction_value = int(round(prediction[0]))

    # Cegah nilai prediksi negatif
    if prediction_value < 0:
        prediction_value = 0

    results.append({
        "product_id": int(pid),
        "prediction": prediction_value,
        "mae": round(mae, 2),
        "rmse": round(rmse, 2),
        "validation_mae": round(val_mae, 2),
        "validation_rmse": round(val_rmse, 2)
    })

# ====================================
# 12. Output JSON untuk Laravel
# ====================================

print(json.dumps(results, indent=4))
#print("Total data:", len(data)) #dimatikan supaya web tidak error
#Jalankan: python machine_learning/prediction.py melihat hasil di powershell
#        # python machine_learning/prediction.py