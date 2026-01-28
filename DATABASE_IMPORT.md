# Database Import Instructions

## PENTING: Import Database Dulu Sebelum Lanjut

Aplikasi Laravel sudah dikonfigurasi untuk connect ke database `aplikasi_listrik_pascabayar`.

Sekarang Anda perlu **import database schema**. Pilih salah satu cara:

---

## Opsi 1: Via HeidiSQL (Laragon - RECOMMENDED) ✅

1. Klik kanan icon **Laragon** di system tray
2. Pilih **Tools** → **HeidiSQL**
3. HeidiSQL akan terbuka, connect otomatis ke MySQL
4. Klik **File** → **Run SQL file**
5. Pilih file: `C:\Jay\Serkom\Project\aplikasi-listrik\database\schema.sql`
6. Klik **Open** / **Execute**
7. Tunggu sampai muncul "Database created successfully!"

✅ **DONE! Database ready.**

---

## Opsi 2: Via Command Line

Buka Terminal/CMD dan jalankan:

```bash
# Masuk ke MySQL
mysql -u root -p

# (jika diminta password, biasanya kosong di Laragon, tekan Enter saja)

# Jalankan SQL file
source C:/Jay/Serkom/Project/aplikasi-listrik/database/schema.sql

# Keluar MySQL
exit;
```

✅ **DONE! Database ready.**

---

## Verify Database Import

Cek apakah database sudah ada:

```bash
mysql -u root -p -e "SHOW DATABASES LIKE 'aplikasi_listrik_pascabayar';"
```

Cek jumlah tables:

```bash
mysql -u root -p aplikasi_listrik_pascabayar -e "SHOW TABLES;"
```

Expected output: **8 tables** (level, user, tarif, daya_listrik, pelanggan, penggunaan, tagihan, pembayaran)

---

**Setelah database berhasil di-import, konfirmasi ke saya dan saya akan lanjut build aplikasi!** 🚀
