# Sistem Prediksi Penjualan Bunga

## Deskripsi

Proyek ini adalah sistem prediksi penjualan bunga menggunakan **Laravel** sebagai backend dan **Python (Machine Learning)** untuk melakukan prediksi.

Model yang digunakan adalah **Linear Regression** untuk memprediksi jumlah penjualan berdasarkan data historis transaksi.

---

## Arsitektur Sistem

Alur sistem:

Database MySQL → Python Machine Learning → JSON → Laravel Controller → Dashboard

1. Data transaksi disimpan di **database MySQL** pada tabel `penjualans`.
2. Script **Python** mengambil data dari database.
3. Model **Linear Regression** melakukan prediksi penjualan.
4. Hasil prediksi dikirim dalam format **JSON**.
5. Laravel menampilkan hasil prediksi pada **dashboard**.

---

## Teknologi yang Digunakan

* Laravel (PHP Framework)
* Python
* Scikit-learn
* MySQL
* Blade Template

---

## Dataset

Dataset berasal dari **database MySQL** dengan tabel:

penjualans

Dataset berisi sekitar **91.300 transaksi penjualan bunga**.

Dataset tidak disimpan di repository karena ukurannya besar dan diambil langsung dari database saat proses machine learning dijalankan.

---

## Struktur Proyek

```
prediksi-penjualan-bunga
│
├ app
├ database
├ resources
│
├ machine_learning
│   ├ prediction.py
│   └ clean_dataset.py
│
└ README.md
```

---

## Output Model

Model menghasilkan:

* Prediksi total penjualan
* MAE (Mean Absolute Error)
* RMSE (Root Mean Squared Error)

Hasil ditampilkan pada dashboard Laravel.
