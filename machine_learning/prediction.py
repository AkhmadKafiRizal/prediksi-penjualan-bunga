import pandas as pd
import json
from sqlalchemy import create_engine

from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_absolute_error, mean_squared_error
from sklearn.model_selection import train_test_split

# ====================================
# 1. Koneksi database (SQLAlchemy)
# ====================================

try:
    engine = create_engine(
        "mysql+pymysql://root:@localhost/prediksi_bunga"
    )
except Exception:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 2. Ambil data dari database
# ====================================

try:

    query = """
    SELECT product_id, tanggal, jumlah, harga, promo
    FROM penjualans
    ORDER BY tanggal
    """

    data = pd.read_sql(query, engine)

except Exception:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 3. Validasi data
# ====================================

if len(data) < 10:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 4. Feature engineering dari tanggal
# ====================================

data["tanggal"] = pd.to_datetime(data["tanggal"])

data["weekday"] = data["tanggal"].dt.weekday
data["month"] = data["tanggal"].dt.month

# ====================================
# 5. Ambil semua produk
# ====================================

product_ids = data["product_id"].unique()

results = []

# ====================================
# 6. Loop model per produk
# ====================================

for pid in product_ids:

    df = data[data["product_id"] == pid]

    if len(df) < 10:
        continue

    X = df[["harga", "promo", "weekday", "month"]]
    Y = df["jumlah"]

    # ====================================
    # 7. Split data training & testing
    # ====================================

    X_train, X_test, y_train, y_test = train_test_split(
        X,
        Y,
        test_size=0.2,
        shuffle=False
    )

    # ====================================
    # 8. Training model
    # ====================================

    model = LinearRegression()
    model.fit(X_train, y_train)

    # ====================================
    # 9. Prediksi data test
    # ====================================

    y_pred = model.predict(X_test)

    # ====================================
    # 10. Evaluasi model
    # ====================================

    mae = mean_absolute_error(y_test, y_pred)
    rmse = mean_squared_error(y_test, y_pred) ** 0.5

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
    prediction_value = int(prediction[0])

    results.append({
        "product_id": int(pid),
        "prediction": prediction_value,
        "mae": round(mae, 2),
        "rmse": round(rmse, 2)
    })

# ====================================
# 12. Output JSON untuk Laravel
# ====================================

print(json.dumps(results, indent=4))import pandas as pd
import json
from sqlalchemy import create_engine

from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_absolute_error, mean_squared_error
from sklearn.model_selection import train_test_split

# ====================================
# 1. Koneksi database (SQLAlchemy)
# ====================================

try:
    engine = create_engine(
        "mysql+pymysql://root:@localhost/prediksi_bunga"
    )
except Exception:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 2. Ambil data dari database
# ====================================

try:

    query = """
    SELECT product_id, tanggal, jumlah, harga, promo
    FROM penjualans
    ORDER BY tanggal
    """

    data = pd.read_sql(query, engine)

except Exception:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 3. Validasi data
# ====================================

if len(data) < 10:
    print(json.dumps({
        "prediction": 0,
        "mae": 0,
        "rmse": 0
    }))
    exit()

# ====================================
# 4. Feature engineering dari tanggal
# ====================================

data["tanggal"] = pd.to_datetime(data["tanggal"])

data["weekday"] = data["tanggal"].dt.weekday
data["month"] = data["tanggal"].dt.month

# ====================================
# 5. Ambil semua produk
# ====================================

product_ids = data["product_id"].unique()

results = []

# ====================================
# 6. Loop model per produk
# ====================================

for pid in product_ids:

    df = data[data["product_id"] == pid].copy()

    # pastikan urutan waktu benar
    df = df.sort_values("tanggal")

    if len(df) < 10:
        continue

    X = df[["harga", "promo", "weekday", "month"]]
    Y = df["jumlah"]

    # ====================================
    # 7. Split data training & testing
    # ====================================

    X_train, X_test, y_train, y_test = train_test_split(
        X,
        Y,
        test_size=0.2,
        shuffle=False
    )

    # ====================================
    # 8. Training model
    # ====================================

    model = LinearRegression()
    model.fit(X_train, y_train)

    # ====================================
    # 9. Prediksi data test
    # ====================================

    y_pred = model.predict(X_test)

    # ====================================
    # 10. Evaluasi model
    # ====================================

    mae = mean_absolute_error(y_test, y_pred)
    rmse = mean_squared_error(y_test, y_pred) ** 0.5

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

    # cegah nilai negatif
    if prediction_value < 0:
        prediction_value = 0

    results.append({
        "product_id": int(pid),
        "prediction": prediction_value,
        "mae": round(mae, 2),
        "rmse": round(rmse, 2)
    })

# ====================================
# 12. Output JSON untuk Laravel
# ====================================

print(json.dumps(results, indent=4))