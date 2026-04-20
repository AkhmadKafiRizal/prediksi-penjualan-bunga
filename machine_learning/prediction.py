import pandas as pd
import os
import json
import pymysql

# import matplotlib.pyplot as plt 
# INI YANG DIHAPUS YA HAPUS KARENA SUDAH PAKAI CHART.JS

from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_absolute_error, mean_squared_error
from sklearn.model_selection import train_test_split

# ====================================
# 1. Menentukan koneksi database
# ====================================

try:
    connection = pymysql.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="prediksi_bunga"
    )
except Exception:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 2. Membaca dataset dari database
# ====================================

try:
    query = """
    SELECT bulan, tahun, jumlah_penjualan
    FROM penjualans
    ORDER BY tahun, bulan
    """
    
    data = pd.read_sql(query, connection)

    connection.close()

    # menyesuaikan nama kolom agar kode lama tetap berjalan
    data.rename(columns={
        "jumlah_penjualan": "QUANTITYORDERED"
    }, inplace=True)

except Exception:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 3. Validasi kolom
# ====================================

if "QUANTITYORDERED" not in data.columns:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 4. Membuat variabel waktu
# ====================================

data["X"] = range(1, len(data) + 1)

X = data[["X"]]
Y = data["QUANTITYORDERED"]

# ====================================
# 5. Membagi data training dan testing
# ====================================

X_train, X_test, y_train, y_test = train_test_split(
    X, Y,
    test_size=0.2,
    shuffle=False
)

# ====================================
# 6. Training model
# ====================================

model = LinearRegression()
model.fit(X_train, y_train)

# ====================================
# 7. Prediksi data test
# ====================================

y_pred = model.predict(X_test)

# ====================================
# 8. Evaluasi model
# ====================================

mae = mean_absolute_error(y_test, y_pred)
rmse = mean_squared_error(y_test, y_pred) ** 0.5

# ====================================
# 9. Prediksi bulan berikutnya
# ====================================

next_month = len(data) + 1

next_data = pd.DataFrame({
    "X": [next_month]
})

prediction = model.predict(next_data)
prediction_value = int(prediction[0])

# ====================================
# 10. Membuat grafik
# ====================================

# plt.figure()
# plt.plot(X, Y)
# plt.plot(X_test, y_pred)
# plt.scatter(next_month, prediction_value)
# plt.title("Grafik Prediksi Penjualan Bunga")
# plt.xlabel("Periode")
# plt.ylabel("Jumlah Penjualan")
# plt.legend()

# INI YANG DIHAPUS YA HAPUS KARENA SUDAH PAKAI CHART.JS

# ====================================
# 11. Simpan grafik PNG
# ====================================

# graph_path = os.path.join(
#     BASE_DIR,
#     "..",
#     "public",
#     "prediction_graph.png"
# )

# plt.savefig(graph_path)
# plt.close()

# INI YANG DIHAPUS YA HAPUS KARENA SUDAH PAKAI CHART.JS

# ====================================
# 12. Output JSON untuk Laravel
# ====================================

result = {
    "prediction": prediction_value,
    "mae": round(mae, 2),
    "rmse": round(rmse, 2)
}

print(json.dumps(result))