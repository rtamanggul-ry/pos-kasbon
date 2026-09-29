# Instruksi Pembuatan API POS & Kasbon (Bagian 1: Pengguna & Master Data)

**Konteks Project:**
Pembuatan API menggunakan Laravel untuk aplikasi POS (Point of Sale) + Kasbon sederhana. Klien dari API ini adalah aplikasi mobile berbasis Flutter. Respons API harus menggunakan format JSON yang terstandarisasi.

**Tugas Anda:**
Tugas Anda adalah membuat Model, Migration, dan Controller untuk bagian **Pengguna dan Master Data** berdasarkan rancangan *high-level* di bawah ini. Implementasikan validasi request, autentikasi (untuk endpoint yang membutuhkan), dan kembalikan format respons JSON yang konsisten.

---

## 1. Rancangan Model & Migration

Buat file migration beserta Eloquent Model untuk entitas berikut. Pastikan tipe data pada database disesuaikan dengan kebutuhan.

### A. Model `User` (Pengguna)
*   **Tujuan:** Menyimpan data kredensial akses untuk pemilik warung.
*   **Atribut Utama:**
    *   `id` (Primary Key)
    *   `username` (String, Unique)
    *   `password` (String, akan disimpan dalam bentuk Hash)
    *   `timestamps` (created_at, updated_at)

### B. Model `Barang` (Master Data Inventaris)
*   **Tujuan:** Menjadi pusat referensi untuk setiap aktivitas transaksi dan pembaruan stok.
*   **Atribut Utama:**
    *   `id` (Primary Key)
    *   `nama_barang` (String)
    *   `harga_modal` (Integer / Decimal)
    *   `harga_jual` (Integer / Decimal)
    *   `stok` (Integer, default 0)
    *   `timestamps`

### C. Model `Pelanggan` (Master Data Pelanggan)
*   **Tujuan:** Menyimpan data identitas pembeli tetap yang sering melakukan transaksi kasbon.
*   **Atribut Utama:**
    *   `id` (Primary Key)
    *   `nama_pelanggan` (String)
    *   `no_hp` (String, opsional/nullable)
    *   `timestamps`

---

## 2. Rancangan Controller (API Endpoints)

Buat API Controller (misalnya di dalam `App\Http\Controllers\Api`) untuk mengekspos data ke aplikasi mobile. Pastikan endpoint dilindungi dengan middleware otentikasi (kecuali login).

### A. `AuthController`
*   **`POST /api/login`**
    *   Tujuan: Autentikasi `User` menggunakan `username` dan `password`.
    *   Output: Mengembalikan token API (misalnya menggunakan Laravel Sanctum) beserta data profil pengguna.
*   **`POST /api/logout`**
    *   Tujuan: Menghapus token yang sedang aktif.

### B. `BarangController` (Memerlukan Token Auth)
Fokus pada operasi CRUD dasar untuk master data barang.
*   **`GET /api/barang`:** Mengambil daftar seluruh barang (mendukung pencarian/pagination).
*   **`POST /api/barang`:** Menambahkan data barang baru.
*   **`GET /api/barang/{id}`:** Mengambil detail satu barang berdasarkan ID.
*   **`PUT/PATCH /api/barang/{id}`:** Mengubah data barang (seperti update harga atau nama). *Catatan: Update stok biasanya diatur secara terpisah melalui transaksi/restok, namun operasi dasar CRUD tetap dibutuhkan.*
*   **`DELETE /api/barang/{id}`:** Menghapus data barang.

### C. `PelangganController` (Memerlukan Token Auth)
Fokus pada operasi CRUD dasar untuk data pelanggan.
*   **`GET /api/pelanggan`:** Mengambil daftar seluruh pelanggan.
*   **`POST /api/pelanggan`:** Menambahkan data pelanggan baru.
*   **`GET /api/pelanggan/{id}`:** Mengambil detail pelanggan berdasarkan ID.
*   **`PUT/PATCH /api/pelanggan/{id}`:** Mengubah data pelanggan.
*   **`DELETE /api/pelanggan/{id}`:** Menghapus data pelanggan.

---

## 3. Format Respons API (High-Level)

Aplikasi Flutter mengharapkan format respons yang konsisten agar *parsing* data lebih mudah. Buat *Response Formatter* (atau Helper/Trait) dengan standar berikut:

**Format Berhasil (Success):**
```json
{
  "success": true,
  "message": "Pesan sukses (contoh: Data barang berhasil diambil)",
  "data": { ... } // Berisi objek atau array dari data
}
```

**Format Gagal/Error (Client Error / Validasi / Server Error):**
```json
{
  "success": false,
  "message": "Pesan error utama (contoh: Validasi gagal / Data tidak ditemukan)",
  "errors": { ... } // Berisi detail error spesifik (opsional), seperti hasil error dari Form Request Validator
}
```

---
**Catatan Implementasi Tambahan:**
1. Gunakan *Form Request Validation* Laravel untuk memisahkan logika validasi dari Controller.
2. Gunakan *Laravel Sanctum* untuk manajemen Token API autentikasi.
3. Hindari logika rumit di controller; fokuskan controller sebagai perantara antara request API dan Eloquent Model.
