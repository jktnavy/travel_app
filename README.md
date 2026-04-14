# Deny Trans Office Dashboard

Repository ini disiapkan untuk pengembangan dua aplikasi yang saling terkait, tetapi dipisah dengan jelas:

- `backoffice/` untuk dashboard internal kantor berbasis Laravel 13 + Filament 5
- `mobile-web/` untuk aplikasi penumpang yang mobile-first
- `docs/` untuk catatan arsitektur dan panduan implementasi

## Struktur repo

```text
.
|-- backoffice/
|-- mobile-web/
|-- docs/
|-- 01-persiapan-proyek/
|-- 02-foundation-backoffice/
|-- 03-data-model-dan-migration/
|-- 04-filament-resource-dan-dashboard/
|-- 05-midtrans-dan-ticketing/
`-- 06-mobile-web-penumpang/
```

Folder bernomor tetap dipakai sebagai panduan implementasi bertahap. Folder aplikasi utama adalah `backoffice` dan `mobile-web`.

## Arsitektur yang dipilih

### 1. Backoffice

Digunakan untuk user internal:

- admin
- finance
- owner

Stack yang disepakati:

- Laravel 13
- Filament 5
- MySQL
- Spatie `laravel-permission`
- Midtrans Snap

Catatan implementasi:

- gunakan satu panel Filament internal
- tampilkan navigasi berdasarkan role/permission
- simpan business logic di service class, bukan di resource Filament
- gunakan enum untuk status penting
- gunakan policy dan permission untuk otorisasi

### 2. Mobile Web

Digunakan untuk penumpang/public booking flow.

Prinsip awal:

- mobile-first
- terpisah dari panel admin
- konsumsi API/backend yang sama secara terkontrol
- fokus pada booking, payment, ticket, dan riwayat transaksi

## Urutan implementasi yang disarankan

Implementasikan `backoffice` lebih dulu.

Alasannya:

- model data inti, otorisasi, jadwal, armada, driver, booking, dan payment flow lebih aman distabilkan dari sisi internal
- aturan bisnis seperti conflict schedule, overbooking, sinkronisasi booking-payment, dan ticket generation perlu matang dulu
- mobile web akan lebih cepat dibangun jika kontrak data dan alur backend sudah jelas

## Setup notes singkat

### `backoffice/`

Target Step 02 dan seterusnya:

- scaffold Laravel 13 app
- install Filament 5
- siapkan autentikasi panel internal
- tambahkan Spatie permission

### `mobile-web/`

Belum discaffold pada step ini.

Fokus tahap awal:

- definisikan peran aplikasi sebagai UI penumpang
- tunggu backend inti stabil sebelum bangun flow penuh

### `docs/`

Simpan dokumen seperti:

- keputusan arsitektur
- boundary antara backoffice dan mobile web
- flow booking dan payment

## Next steps

1. Lanjut ke `02-foundation-backoffice`
2. Scaffold Laravel 13 di `backoffice/`
3. Pasang Filament 5 dan Spatie permission
4. Setelah fondasi backoffice stabil, lanjut ke data model dan migration
