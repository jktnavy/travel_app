# Rekomendasi Mobile Web untuk Deny Trans

## Pilihan terbaik saat ini
Buat **mobile web / PWA** untuk penumpang, dan biarkan **Filament** hanya untuk kantor.

## Kenapa ini paling pas
Karena user penumpang butuh:
- buka cepat dari HP
- tidak perlu install dari Play Store
- flow booking singkat
- pembayaran cepat
- tiket langsung muncul

## Pilihan teknologi

### Opsi 1 — Laravel Blade + Tailwind
Cocok jika:
- ingin cepat jadi
- satu tim fokus ke Laravel
- mau biaya development lebih hemat

Kelebihan:
- lebih cepat dibuat
- satu stack
- integrasi backend lebih mudah

### Opsi 2 — Laravel API + Next.js
Cocok jika:
- mau UX lebih modern
- mau aplikasi publik yang lebih scalable
- tim familiar React

Kelebihan:
- frontend lebih fleksibel
- cocok untuk PWA modern
- enak jika nanti bikin app native

## Saran saya
Mulai dari:
- Backoffice: Laravel + Filament
- Passenger app: Laravel Blade + Tailwind mobile-first

Nanti kalau bisnis tumbuh, sisi passenger bisa di-upgrade ke Next.js.

## Flow customer yang wajib
1. daftar / login email
2. pilih rute
3. pilih tanggal dan jam
4. pilih kendaraan
5. isi data penumpang
6. konfirmasi
7. bayar Midtrans
8. tiket berhasil
9. lihat riwayat booking

## Struktur domain
- admin.denytrans.com
- booking.denytrans.com

## Catatan penting
- jangan campur UI penumpang ke panel Filament
- pakai backend dan database yang sama
- payment dan ticket service bisa dipakai bersama
