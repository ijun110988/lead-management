<p align="center"><a href="" target="_blank"><img src="https://miro.medium.com/v2/resize:fit:1400/format:webp/1*ZgFKHWMkQzzzyO1teu9aGw.png" width="400" alt="Laravel Logo"></a></p>

# Lead Management API & WordPress Form

## 📌 Overview
Proyek ini merupakan sistem **Lead Management API** berbasis **Laravel**, yang dilindungi oleh **Bearer Token** statis untuk menangani prospek (*leads*). Formulir di **WordPress** digunakan untuk mengumpulkan data prospek dan mengirimkannya ke API Laravel.

## 🛠 Teknologi yang Digunakan
- **Laravel** (Backend API)
- **WordPress** (Frontend & Formulir Prospek)
- **PostgreSQL** (Database)
- **Docker & Docker Compose** (Deployment)

---

## 🚀 Cara Menjalankan Proyek dengan Docker Compose

### 1️⃣ **Clone Repository**
```sh
git clone https://github.com/username/repository.git
cd repository
```

### 2️⃣ **Jalankan Docker Compose**
```sh
docker-compose up -d --build
```

### 3️⃣ **Akses Aplikasi**
- **API Laravel:** [http://localhost:8000](http://localhost:8000)
- **WordPress:** [http://localhost:8081](http://localhost:8081)

---

## 🔐 API Authentication (Bearer Token)
Setiap request ke API harus menyertakan **Bearer Token** berikut:
```sh
Authorization: Bearer lead-management-token-2025
```

## 📡 API Endpoints
| Method | Endpoint | Deskripsi |
|--------|---------|-----------|
| `POST` | `/api/leads` | Menyimpan lead baru |
| `GET` | `/api/leads` | Menampilkan semua leads |
| `GET` | `/api/leads/{id}` | Menampilkan lead berdasarkan ID |
| `PUT` | `/api/leads/{id}` | Mengupdate lead berdasarkan ID |
| `DELETE` | `/api/leads/{id}` | Menghapus lead berdasarkan ID |

### 📝 **Contoh Request via cURL**
```sh
curl --location 'http://localhost:8000/api/leads' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer lead-management-token-2025' \
--data-raw '{
    "name": "Ijun Wahyudin",
    "email": "ijun@example.com",
    "phone": "08123456789",
    "source": "Tiktok",
    "message": "I am interested"
}'
```

---

## 📝 Formulir WordPress
Form ini digunakan untuk menangkap prospek dan mengirimkannya ke API Laravel.

### ✅ **Fitur Formulir**
- **Validasi:** Nama, Email, dan Nomor Telepon wajib diisi.
- **Otomatis mengambil sumber (*source*) dari UTM Parameter di URL.**
- **Menampilkan pesan sukses/gagal setelah submit.**

### 🔧 **Cara Menggunakan Form di WordPress**
1. Tambahkan shortcode berikut di halaman WordPress:
   ```sh
   [lead_capture_form]
   ```
2. Pastikan halaman diakses dengan UTM Parameter, misalnya:
   ```sh
   http://localhost:8081?utm_campaign=FacebookAds
   ```
3. Jika berhasil, field "Sumber" otomatis akan terisi dengan "FacebookAds".

---

## 🔄 Migrasi Database Laravel
Jika perlu menjalankan ulang database:
```sh
docker-compose exec app php artisan migrate --seed
```

---

## 🛠️ Troubleshooting
Jika mengalami kendala:

### 📜 **Cek Log Laravel**
```sh
docker-compose exec app tail -f storage/logs/laravel.log
```

### 🚀 **Pastikan Container Berjalan**
```sh
docker ps
```

### 🔄 **Hentikan & Jalankan Ulang**
```sh
docker-compose down && docker-compose up -d --build
```