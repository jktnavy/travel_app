# Architecture Overview

## Applications

### Backoffice

Internal office dashboard untuk:

- admin
- finance
- owner

Tanggung jawab utama:

- kelola jadwal
- kelola kendaraan
- kelola driver
- kelola booking
- kelola pembayaran
- lihat laporan operasional

### Mobile Web

Aplikasi penumpang untuk:

- memilih rute dan jadwal
- membuat booking
- melakukan pembayaran
- menerima tiket

## Shared business rules

Aturan inti yang harus dijaga di seluruh implementasi:

- cegah konflik jadwal kendaraan
- cegah konflik jadwal driver
- cegah overbooking
- buat tiket hanya setelah pembayaran sukses
- sinkronkan status booking dan payment
- webhook payment harus idempotent

## Delivery strategy

Bangun `backoffice` terlebih dahulu, lalu `mobile-web`.

Strategi ini dipilih agar:

- model data inti stabil lebih awal
- aturan bisnis tervalidasi sebelum dipakai UI publik
- integrasi payment dan ticketing tidak berubah-ubah saat mobile web mulai dibangun
