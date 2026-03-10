import pandas as pd
import os
import matplotlib.pyplot as plt
import json

from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_absolute_error, mean_squared_error
from sklearn.model_selection import train_test_split

# ====================================
# 1. Menentukan lokasi dataset
# ====================================

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

dataset_path = os.path.join(
    BASE_DIR,
    "..",
    "dataset",
    "cleaned_flower_sales_dataset.csv"
)

# ====================================
# 2. Membaca dataset
# ====================================

try:
    data = pd.read_csv(dataset_path)
except Exception as e:
    print(json.dumps({"prediction":0,"mae":0,"rmse":0}))
    exit()

# ====================================
# 3. Validasi kolom
# ====================================

if "QUANTITYORDERED" not in data.columns:
    print(json.dumps({"prediction":0,"mae":0,"rmse":0}))
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
    X, Y, test_size=0.2, shuffle=False
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
next_data = pd.DataFrame({"X": [next_month]})

prediction = model.predict(next_data)
prediction_value = int(prediction[0])

# ====================================
# 10. Membuat grafik
# ====================================

plt.figure()

plt.plot(X, Y, label="Data Penjualan Aktual")

plt.plot(X_test, y_pred, label="Prediksi Model")

plt.scatter(next_month, prediction_value, label="Prediksi Bulan Berikutnya")

plt.title("Grafik Prediksi Penjualan Bunga")
plt.xlabel("Periode")
plt.ylabel("Jumlah Penjualan")
plt.legend()

# ====================================
# 11. Simpan grafik ke Laravel
# ====================================

graph_path = os.path.join(
    BASE_DIR,
    "..",
    "public",
    "prediction_graph.png"
)

plt.savefig(graph_path)
plt.close()

# ====================================
# 12. Output untuk Laravel (JSON)
# ====================================

result = {
    "prediction": prediction_value,
    "mae": round(mae, 2),
    "rmse": round(rmse, 2)
}

print(json.dumps(result))