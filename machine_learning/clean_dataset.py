import pandas as pd

print("Memulai proses cleaning dataset...")

# membaca dataset baru
df = pd.read_csv('machine_learning/flowershopdata.csv')

# tampilkan jumlah data awal
print("Jumlah data awal:", len(df))

# hapus data duplikat
df = df.drop_duplicates()

print("Jumlah data setelah hapus duplikat:", len(df))

# ambil kolom yang dibutuhkan
df = df[['Name', 'Date']]

# ubah Date ke datetime
df['Date'] = pd.to_datetime(df['Date'], format='mixed', dayfirst=True, errors='coerce')

# hapus tanggal yang tidak valid
df = df.dropna(subset=['Date'])

# ambil bulan dan tahun
df['bulan'] = df['Date'].dt.month
df['tahun'] = df['Date'].dt.year

# hitung jumlah transaksi per bulan
sales = df.groupby(['tahun', 'bulan']).size().reset_index(name='jumlah_penjualan')

print("Hasil agregasi:")
print(sales)

# simpan dataset baru
sales.to_csv('machine_learning/cleaned_flower_sales_dataset.csv', index=False)

print("Cleaning selesai.")
print("File baru dibuat: cleaned_flower_sales_dataset.csv")