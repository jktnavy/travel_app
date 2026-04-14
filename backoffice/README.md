# Deny Trans Office Dashboard

Backoffice internal untuk user:

- admin
- finance
- owner

Stack yang sudah terpasang:

- Laravel 13
- Filament 5
- Spatie `laravel-permission`

Stack target proyek:

- MySQL
- Midtrans Snap integration

## Fondasi yang sudah disiapkan

- satu panel Filament internal di `/admin`
- akses panel dibatasi ke user yang punya role `admin`, `finance`, atau `owner`
- `User` model sudah memakai `HasRoles`
- seeder role awal sudah tersedia
- dashboard minimal sudah ada dengan widget placeholder berbeda untuk tiap role

## Local setup

1. Masuk ke folder app:

```bash
cd backoffice
```

2. Install dependency PHP dan frontend:

```bash
composer install
npm install
```

3. Salin environment file lalu sesuaikan database MySQL:

```bash
cp .env.example .env
php artisan key:generate
```

Contoh konfigurasi minimum di `.env`:

```env
APP_NAME="Deny Trans Office Dashboard"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=deny_trans_backoffice
DB_USERNAME=root
DB_PASSWORD=
```

4. Jalankan migration dan seeder role:

```bash
php artisan migrate
php artisan db:seed
```

5. Buat user internal pertama lalu assign role lewat Tinker:

```bash
php artisan tinker
```

```php
$user = \App\Models\User::create([
    'name' => 'Admin Deny Trans',
    'email' => 'admin@denytrans.test',
    'password' => 'password',
]);

$user->assignRole('admin');
```

6. Jalankan server lokal:

```bash
npm run build
php artisan serve
```

Lalu buka `http://127.0.0.1:8000/admin`.

## Seeder

Seeder yang tersedia saat ini:

- `Database\\Seeders\\RoleSeeder`

Role awal yang dibuat:

- `admin`
- `finance`
- `owner`

## Testing

Jalankan test:

```bash
php artisan test
```

Test dasar yang sudah ada:

- guest diarahkan ke login Filament
- user tanpa role internal ditolak dari panel
- user dengan role internal bisa mengakses panel
