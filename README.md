# NEXTLAB - Sistem Peminjaman Alat Laboratorium

NEXTLAB adalah aplikasi berbasis Laravel yang digunakan untuk mengelola peminjaman alat inventaris di lingkungan laboratorium. Sistem ini membantu proses pencatatan, pengelolaan, dan monitoring peminjaman agar lebih terstruktur dan efisien.

---

## Fitur

- Autentikasi Login & Register
- Manajemen Data Alat
- Peminjaman dan Pengembalian Alat
- Perhitungan Denda Keterlambatan
- Pembayaran Denda
- Laporan Peminjaman
- Filter berdasarkan tanggal dan status
- Export laporan ke PDF

---

## Teknologi

- Laravel
- MySQL
- Tailwind CSS
- DomPDF

---

## Konsep Sistem

Relasi utama pada sistem:

- User → Peminjaman (One to Many)  
- Alat → Peminjaman (One to Many)  

Satu user dapat melakukan banyak peminjaman, dan satu alat dapat dipinjam oleh banyak user dalam waktu yang berbeda.

---

## Author

Nama: Yogi Firman Firdaus    

---

## Catatan

Project ini dibuat untuk kebutuhan pembelajaran dan implementasi sistem peminjaman alat di lingkungan laboratorium.
