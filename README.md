Prasyarat (Prerequisites)
Sebelum menjalankan, pastikan kamu punya:

PHP versi 8.1 atau lebih tinggi (Laravel biasanya butuh ini).
Composer (untuk mengelola dependensi PHP).
Node.js dan NPM (untuk frontend, minimal versi 14+).
Database seperti MySQL, PostgreSQL, atau SQLite (konfigurasi di .env).
Git untuk clone repositori.
Akses ke terminal/command prompt.

Langkah-langkah Instalasi dan Menjalankan

Clone Repositori:
Buka terminal dan jalankan:textgit clone https://github.com/varelsaurus/giveit.git
cd giveit
Instal Dependensi PHP:
Jalankan Composer untuk install paket Laravel:textcomposer install
Konfigurasi Environment:
Salin file contoh environment:textcp .env.example .envBuka file .env dengan editor teks (seperti VS Code), dan sesuaikan pengaturan, terutama:
APP_KEY (akan digenerate di langkah berikutnya).
Database: DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD.
Lainnya jika diperlukan (misalnya email atau API keys).

Generate Application Key:textphp artisan key:generate
Setup Database (Migration):
Jika proyek punya schema database, jalankan migration:textphp artisan migrate(Pastikan database sudah dibuat dan terhubung di .env.)
Instal Dependensi Frontend:
Proyek ini pakai Tailwind CSS dan Vite, jadi install Node dependencies:textnpm install
Compile Assets Frontend:
Untuk development (live reload):textnpm run devAtau untuk production (build sekali):textnpm run build
Jalankan Server Development:
Jalankan server Laravel lokal:textphp artisan serveBuka browser di http://127.0.0.1:8000 (atau port yang ditampilkan).

Tips Tambahan

Error Umum:
Jika ada error permission di storage/logs: Jalankan chmod -R 777 storage bootstrap/cache.
Jika database error: Cek koneksi di .env dan pastikan server database berjalan (misalnya mysql service).

Deployment ke Production:
Gunakan server seperti Apache/Nginx dengan PHP-FPM.
Jalankan php artisan config:cache dan php artisan route:cache untuk optimasi.
Upload ke hosting (Heroku, Vercel, atau VPS) dan sesuaikan .env untuk production (APP_ENV=production).

Update Dependensi:
Jika perlu update: composer update dan npm update.
Testing:
Jalankan unit tests dengan php artisan test atau ./vendor/bin/phpunit.

Jika proyek punya fitur khusus (tidak terlihat dari repo), mungkin perlu cek kode di folder app, routes, atau resources. Kalau ada pertanyaan lebih lanjut atau error, kasih tau detailnya! 😊
