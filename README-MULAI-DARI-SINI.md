# Deny Trans — Paket Implementasi Bertahap

Paket ini dibuat supaya urutan kerja tidak membingungkan.
Jalankan folder berdasarkan nomor:

1. `01-persiapan-proyek`
2. `02-foundation-backoffice`
3. `03-data-model-dan-migration`
4. `04-filament-resource-dan-dashboard`
5. `05-midtrans-dan-ticketing`
6. `06-mobile-web-penumpang`

## Ringkasan arsitektur yang disarankan

### A. Backoffice internal kantor
Gunakan:
- Laravel 13
- Filament 5
- MySQL
- Spatie Permission
- Midtrans

Dipakai untuk role:
- Admin
- Keuangan
- Owner

### B. Aplikasi penumpang
Jangan pakai Filament untuk sisi penumpang.
Pisahkan menjadi aplikasi mobile web / PWA.

Rekomendasi paling praktis:
- Laravel backend API
- Frontend mobile web responsif atau PWA
- Bisa 1 domain publik terpisah dari admin panel

Contoh:
- `admin.denytrans.com` → dashboard kantor
- `booking.denytrans.com` → mobile web penumpang

## Urutan kerja yang aman

### Opsi paling rapi
- Bangun backoffice dulu sampai stabil
- Setelah itu bangun mobile web penumpang
- Integrasikan ke database dan payment flow yang sama

### Opsi paling cepat
- Bangun backend core + payment flow
- Lalu bangun panel admin dan mobile web secara paralel

## Cara pakai paket ini

Setiap folder berisi:
- `README.md`
- prompt untuk Codex
- catatan output yang diharapkan

Mulai dari folder nomor 1, jangan lompat dulu.

## Hasil akhir yang dituju

### Dashboard kantor
- kelola booking
- kelola jadwal
- kelola kendaraan
- kelola driver
- kelola pembayaran
- laporan owner

### Mobile web penumpang
- daftar / login email
- pilih rute dan jadwal
- pilih kendaraan / unit
- isi data penumpang
- bayar via Midtrans
- tiket berhasil dibuat
- lihat riwayat booking
