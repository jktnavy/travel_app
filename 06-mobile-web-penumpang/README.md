# Step 06 — Mobile Web Penumpang

Ini bagian untuk aplikasi sisi customer.

## Jawaban singkat
Untuk penumpang, saya sarankan **mobile web responsif atau PWA**, bukan Filament.

## Kenapa dipisah dari Filament
Filament cocok untuk:
- dashboard admin
- CRUD internal
- operasional kantor

Filament tidak ideal untuk:
- UI booking customer
- landing page publik
- flow checkout mobile-first
- pengalaman seperti aplikasi travel

## Rekomendasi arsitektur
### Opsi terbaik
- Backend tetap Laravel
- Buat frontend customer terpisah:
  - Blade + Tailwind jika ingin cepat
  - atau Next.js / Nuxt jika ingin lebih modern
- Jadikan mobile web ini sebagai PWA

### Kenapa PWA bagus
- terasa seperti aplikasi
- bisa ditambahkan ke home screen
- lebih ringan daripada native app di fase awal
- cocok untuk booking shuttle

## Halaman yang perlu ada
- landing page
- login/register email
- home booking
- pilih jadwal
- pilih kendaraan
- isi data penumpang
- konfirmasi booking
- pembayaran Midtrans
- e-ticket
- riwayat booking
- profil

## Integrasi backend
Mobile web sebaiknya memakai:
- API Laravel
atau
- route web Laravel terpisah dari Filament panel

## Domain yang disarankan
- admin.denytrans.com
- booking.denytrans.com
