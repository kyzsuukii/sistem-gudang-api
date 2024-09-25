# Dokumentasi Sistem Gudang API

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Prasyarat](#prasyarat)
3. [Instalasi dan Pengaturan](#instalasi-dan-pengaturan)
4. [Migrasi Database](#migrasi-database)
5. [Memverifikasi Status Layanan](#memverifikasi-status-layanan)
6. [Mengakses Aplikasi](#mengakses-aplikasi)
7. [Dokumentasi API](#dokumentasi-api)

## 1. Pendahuluan
Dokumen ini menyediakan instruksi untuk mengatur dan menjalankan Sistem Gudang API menggunakan Docker.

## 2. Prasyarat
Pastikan `docker` telah terinstal di sistem Anda sebelum melanjutkan instalasi.

## 3. Instalasi dan Pengaturan
Untuk membangun dan menjalankan aplikasi menggunakan Docker Compose, jalankan perintah berikut:

```bash
docker compose up -d --build
```

## 4. Migrasi Database
Setelah aplikasi dibangun dan berjalan, lakukan migrasi database:

```bash
docker compose exec api php artisan migrate:fresh
```

Untuk menyertakan data sampel, gunakan perintah berikut:

```bash
docker compose exec api php artisan migrate:fresh --seed
```

## 5. Memverifikasi Status Layanan
Untuk memastikan semua layanan berjalan dengan benar, gunakan perintah-perintah berikut:

Periksa status semua kontainer:
```bash
docker compose ps
```

Lihat log untuk semua layanan:
```bash
docker compose logs
```

## 6. Mengakses Aplikasi
Setelah semua layanan berjalan, akses aplikasi di:

[http://127.0.0.1:8000](http://127.0.0.1:8000)

## 7. Dokumentasi API
Untuk dokumentasi API yang lebih rinci, silakan merujuk ke koleksi Postman kami:

[Koleksi Postman Sistem Gudang API](https://elements.getpostman.com/redirect?entityId=31192578-44bc2019-864e-46af-94bd-02652f253619&entityType=collection)