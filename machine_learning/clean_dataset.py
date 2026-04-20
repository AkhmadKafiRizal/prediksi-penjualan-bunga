import pandas as pd

print("Memulai proses cleaning dataset...")

df = pd.read_csv("machine_learning/retail_sales.csv")

print("Jumlah data awal:", len(df))
print("Kolom dataset:", df.columns)

df.columns = df.columns.str.lower()

df = df.dropna()

df = df[df["sales"] > 0]
df = df[df["price"] > 0]

print("Jumlah data setelah cleaning:", len(df))

df["date"] = pd.to_datetime(df["date"])

df_agg = df.groupby(["date", "item_id"]).agg({
    "sales": "sum",
    "price": "mean",
    "promo": "max"
}).reset_index()

print("Jumlah data setelah agregasi:", len(df_agg))

# ubah item_1 -> 1
df_agg["product_id"] = df_agg["item_id"].str.replace("item_", "").astype(int)

df_agg = df_agg.rename(columns={
    "date": "tanggal",
    "sales": "jumlah",
    "price": "harga"
})

df_final = df_agg[
    ["product_id", "tanggal", "jumlah", "harga", "promo"]
]

# simpan CSV yang bersih untuk MySQL
df_final.to_csv(
    "machine_learning/cleaned_flower_sales_dataset.csv",
    index=False,
    sep=",",
    encoding="utf-8"
)

print("Cleaning selesai!")
print("Total data akhir:", len(df_final))