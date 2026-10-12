# Perpustakaan Pintar

Perpustakaan Pintar adalah aplikasi web untuk membantu pengelolaan data dan transaksi perpustakaan. Aplikasi dibuat menggunakan Laravel dan menyediakan akses berbeda untuk administrator dan anggota.

## Fitur

- **Akun dan autentikasi**: daftar akun dengan nama lengkap, username, dan kata sandi; login dan logout.
- **Notifikasi sambutan**: setelah login, nama lengkap yang diisi saat pendaftaran ditampilkan selama 3 detik.
- **Dashboard**: ringkasan jumlah anggota, buku, kategori, peminjaman, dan anggota yang memiliki denda.
- **Data master**: kelola data anggota, buku, kategori buku, dan tarif denda.
- **Peminjaman**: catat peminjaman beberapa buku untuk anggota, lihat dan ubah data transaksi, serta catat pengembalian.
- **Denda keterlambatan**: hitung denda berdasarkan jumlah hari keterlambatan dan tarif denda yang dipilih.
- **Laporan**: tampilkan dan cetak laporan seluruh peminjaman.
- **Manajemen pengguna**: administrator dapat mengelola akun pengguna sistem.
- **Detail peminjaman**: lihat rincian buku dalam transaksi.

## Teknologi

- PHP 8.1 atau lebih baru
- Laravel 10
- MySQL atau database lain yang didukung Laravel
- Bootstrap 5

## Persiapan dan instalasi

1. Pasang dependency PHP:

   ```bash
   composer install
   ```

2. Buat file konfigurasi lokal dari contoh:

   ```bash
   cp .env.example .env
   ```

   Di Windows PowerShell, gunakan:

   ```powershell
   Copy-Item .env.example .env
   ```

3. Buat database, lalu sesuaikan pengaturan `DB_*` di `.env` dengan koneksi database lokal.

4. Buat application key:

   ```bash
   php artisan key:generate
   ```

5. Buat tabel dan data contoh:

   ```bash
   php artisan migrate --seed
   ```

   Migrasi menambahkan kolom `full_name` yang dipakai untuk menyimpan nama lengkap pengguna.

6. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

   Buka alamat yang ditampilkan Artisan, biasanya `http://127.0.0.1:8000`.

## Akun contoh

Seeder membuat akun berikut:

| Peran | Username | Kata sandi |
|---|---|---|
| Administrator | `admin` | `password` |
| Anggota | `anggota` | `password` |

Ganti kata sandi akun contoh sebelum aplikasi digunakan di lingkungan bersama atau produksi.

Pengunjung juga dapat membuat akun melalui halaman **Register**. Akun yang didaftarkan mendapat peran anggota.

## Hak akses

- **Administrator** dapat mengakses fitur data perpustakaan dan halaman manajemen pengguna.
- **Anggota** dapat mengakses fitur data perpustakaan, peminjaman, dan laporan.

## Catatan penggunaan

- Pengembalian buku dicatat pada detail peminjaman. Jika tanggal kembali melewati masa pinjam, sistem menghitung denda berdasarkan tarif per hari.
- Data contoh dimasukkan oleh seeder. Untuk mengisi ulang database dari awal, gunakan `php artisan migrate:fresh --seed`; perintah ini menghapus seluruh tabel dan data yang ada.
