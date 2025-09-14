# 🏢 Sistem Absensi Karyawan & Profil Perusahaan

Proyek ini adalah aplikasi berbasis **Laravel 10** untuk mengelola absensi karyawan sekaligus menampilkan profil perusahaan.  
Aplikasi ini dirancang untuk memudahkan pencatatan kehadiran dengan **kamera + GPS**, serta memberikan informasi lengkap mengenai profil perusahaan.

## ✨ Fitur Utama
- 📸 **Absensi Kamera** → Ambil foto sebagai bukti kehadiran.
- 📍 **Validasi GPS** → Absensi hanya bisa dilakukan di lokasi yang ditentukan.
- 👨‍💼 **Manajemen Karyawan** → Tambah, edit, hapus data karyawan.
- 🏢 **Profil Perusahaan** → Menampilkan informasi detail perusahaan.
- 📊 **Dashboard Admin** → Monitoring absensi karyawan & ringkasan data.
- 📂 **Laporan Absensi** → Rekap data absensi harian & bulanan.
- 🔐 **Autentikasi User** → Login & role management (admin/karyawan).
## 🚀 Instalasi

Ikuti langkah berikut untuk menjalankan proyek secara lokal:

### 1. Clone Repository
git clone https://github.com/alerascal/absensikaryawab_profilperusahan.git
2. Masuk ke Folder Proyek
bash
Salin kode
cd absensikaryawab_profilperusahan
3. Install Dependency Laravel
bash
Salin kode
composer install
4. Install Dependency Frontend
bash
Salin kode
npm install && npm run build
5. Copy File Environment
bash
Salin kode
cp .env.example .env
6. Generate Application Key
bash
Salin kode
php artisan key:generate
7. Konfigurasi Database
Edit file .env dan sesuaikan dengan database lokal kamu
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_db
DB_USERNAME=root
DB_PASSWORD=
8. Migrasi Database
bash
Salin kode
php artisan migrate
9. Jalankan Server
bash
Salin kode
php artisan serve
Aplikasi akan berjalan di:
👉 http://127.0.0.1:8000

⚙️ Teknologi yang Digunakan
Laravel 10

MySQL

Bootstrap / Tailwind (opsional untuk UI)

JavaScript

📌 Roadmap
 Absensi berbasis kamera

 Validasi GPS absensi

 Export laporan ke Excel/PDF

 Notifikasi email untuk absensi

 Integrasi API untuk HR system

👤 Author
Moh Sahrul Alam Syah (alerascal)
📧 Email: alerascal77@gmail.com
🔗 GitHub: alerascal

📄 Lisensi
Proyek ini dilisensikan di bawah lisensi MIT.
Silakan gunakan, modifikasi, dan distribusikan sesuai kebutuhan.
