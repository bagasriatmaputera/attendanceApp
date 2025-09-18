<img width="1919" height="973" alt="image" src="https://github.com/user-attachments/assets/fd67dfb2-a40f-4680-813f-33764c8e836a" />

<img width="1919" height="972" alt="image" src="https://github.com/user-attachments/assets/413b28b2-6ae4-489e-a01f-1627bc6e97a6" />



# 📘 Dokumentasi Backend AttendanceApp

## 1. Persiapan Lingkungan

Pastikan sudah terinstall:

* **PHP 8.1+**
* **Composer** → [Download di sini](https://getcomposer.org/download/)
* **MySQL/MariaDB**
* **Node.js & npm** (opsional untuk Filament asset)

---

## 2. Clone Project

```bash
git clone <repo_url> attendance_app
cd attendance_app
```

---

## 3. Install Dependency via Composer

```bash
composer install
```

---

## 4. Buat File `.env`

Copy dari contoh:

```bash
cp .env.example .env
```

Edit `.env` sesuai konfigurasi lokal:

```env
APP_NAME=AttendanceApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=attendance_app
DB_USERNAME=root
DB_PASSWORD=

# untuk timezone
APP_TIMEZONE=Asia/Jakarta

# sanctum / cors
SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:5173
```

Generate key:

```bash
php artisan key:generate
```

---

## 5. Import Database

* Buka **phpMyAdmin** atau CLI MySQL.
* Buat database:

```sql
CREATE DATABASE attendance_app;
```

* Import file SQL (backup yang sudah disiapkan):

```bash
mysql -u root -p attendance_app < attendance_app.sql
```

---


## 6. Login ke Filament Admin

Jalankan server:

```bash
php artisan serve
```

Akses admin:

```
http://127.0.0.1:8000/admin
```

Gunakan user default (jika seeder disiapkan), contoh:

```
Email: admin@attendance.com
Password: password
```

---

## 7. API Routes (Autentikasi & Attendance)

Semua endpoint di-protect `auth:sanctum`.

| Method | Endpoint              | Deskripsi                 |
| ------ | --------------------- | ------------------------- |
| POST   | `/api/register`       | Register user baru        |
| POST   | `/api/login`          | Login user (return token) |
| POST   | `/api/logout`         | Logout user               |
| GET    | `/api/profile`        | Get data user login       |
| POST   | `/api/attendance/in`  | Absen masuk               |
| PATCH  | `/api/attendance/out` | Absen keluar              |

---

## 8. Jalankan Backend

```bash
php artisan serve
```

Default jalan di:
👉 `http://127.0.0.1:8000`

---

## 9. Troubleshooting

* Jika **CORS error** saat akses dari React → cek `config/cors.php` (gunakan `*` untuk dev).
* Jika error **vendor not found** → pastikan `composer install` sudah jalan.
* Jika waktu tidak sesuai (misalnya UTC) → pastikan di `.env` pakai:

  ```env
  APP_TIMEZONE=Asia/Jakarta
  ```

---
