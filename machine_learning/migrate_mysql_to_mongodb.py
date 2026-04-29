import pandas as pd
from sqlalchemy import create_engine
from pymongo import MongoClient

MYSQL_URL = "mysql+pymysql://root:@localhost/prediksi_bunga"
MONGO_URL = "mongodb://localhost:27017/"

MYSQL_TABLE = "penjualans"
MONGO_DB = "prediksi_bunga"
MONGO_COLLECTION = "penjualans"

print("Mengambil data dari MySQL...")

engine = create_engine(MYSQL_URL)

query = """
SELECT 
    id,
    product_id,
    tanggal,
    jumlah,
    harga,
    promo,
    created_at,
    updated_at
FROM penjualans
ORDER BY id
"""

df = pd.read_sql(query, engine)

print(f"Jumlah data dari MySQL: {len(df)}")

if df.empty:
    raise Exception("Data MySQL kosong. Migrasi dibatalkan.")

df["tanggal"] = pd.to_datetime(df["tanggal"]).dt.strftime("%Y-%m-%d")

if "created_at" in df.columns:
    df["created_at"] = pd.to_datetime(df["created_at"], errors="coerce").astype(str)

if "updated_at" in df.columns:
    df["updated_at"] = pd.to_datetime(df["updated_at"], errors="coerce").astype(str)

records = df.to_dict(orient="records")

print("Menghubungkan ke MongoDB...")

client = MongoClient(MONGO_URL)
db = client[MONGO_DB]
collection = db[MONGO_COLLECTION]

print("Menghapus isi collection lama agar tidak duplikat...")
collection.delete_many({})

print("Memasukkan data ke MongoDB...")
collection.insert_many(records)

jumlah_mongo = collection.count_documents({})

print("Migrasi selesai.")
print(f"Jumlah data di MongoDB: {jumlah_mongo}")

if jumlah_mongo == len(df):
    print("VALID: jumlah data MySQL dan MongoDB sama.")
else:
    print("PERINGATAN: jumlah data tidak sama.")