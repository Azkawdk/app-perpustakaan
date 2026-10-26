# Dokumentasi API Perpustakaan

Dokumentasi ini mengikuti route, controller, request validation, dan JSON Resource yang ada di source code.

- Semua URL menggunakan prefix `/api` dan menerima/mengembalikan JSON.
- Untuk request dengan body, gunakan header `Content-Type: application/json` dan `Accept: application/json`.
- Endpoint yang terdaftar hanya menggunakan middleware `api`; tidak ada middleware autentikasi pada route-route ini.
- ID, nama, tanggal, dan timestamp dalam contoh adalah nilai ilustrasi.
- Daftar buku, anggota, dan peminjaman menggunakan pagination 10 data per halaman. `page` dapat digunakan untuk memilih halaman.

## Dokumentasi endpoint

| Method | URL | Body (jika ada) | Contoh Response |
|---|---|---|---|
| `GET` | `/api/books`<br>Query: `judul`, `category_id`, `page` | - | `200 OK`<br>`{"data":[{...}],"links":{...},"meta":{...}}`<br>Gagal: `500` |
| `GET` | `/api/books/{id}` | - | `200 OK`<br>`{"data":{"id":1,"judul":"Laskar Pelangi",...}}`<br>Gagal: `404` |
| `POST` | `/api/books` | [JSON buku](#body-buku) | `201 Created`<br>`{"data":{"id":1,"judul":"...",...}}`<br>Gagal: `422`, `500` |
| `PUT` | `/api/books/{id}` | [JSON buku](#body-buku) | `200 OK`<br>`{"data":{"id":1,"judul":"...",...}}`<br>Gagal: `404`, `422` |
| `DELETE` | `/api/books/{id}` | - | `200 OK`<br>`{"message":"Buku berhasil dihapus."}`<br>Gagal: `404` |
| `GET` | `/api/members`<br>Query: `nama`, `page` | - | `200 OK`<br>`{"data":[{...}],"links":{...},"meta":{...}}`<br>Gagal: `500` |
| `GET` | `/api/members/{id}` | - | `200 OK`<br>`{"data":{"id":1,"nama":"Ayu Lestari",...}}`<br>Gagal: `404` |
| `GET` | `/api/loans`<br>Query: `page` | - | `200 OK`<br>`{"data":[{...}],"links":{...},"meta":{...}}`<br>Gagal: `500` |
| `POST` | `/api/loans` | [JSON peminjaman](#body-peminjaman) | `201 Created`<br>`{"data":{"id":1,"status":"dipinjam","books":[...]}}`<br>Gagal: `422`, `500` |
| `PUT` | `/api/loans/{id}/kembalikan` | - | `200 OK`<br>`{"data":{"id":1,"status":"dikembalikan",...}}`<br>Gagal: `404`, `422` |
| `GET` | `/api/stats` | - | `200 OK`<br>`{"success":true,"message":"Statistik berhasil dimuat","data":{...}}`<br>Gagal: `500` |

**Catatan:** Tanda `...` meringkas field lain yang tetap dikirim API. Daftar buku, anggota, dan peminjaman menggunakan pagination 10 data per halaman. Kirim header `Accept: application/json`; request dengan body juga perlu `Content-Type: application/json`.

## Contoh body request

<a id="body-buku"></a>
### Buku — `POST /api/books` dan `PUT /api/books/{id}`

```json
{
  "judul": "Laskar Pelangi",
  "penulis": "Andrea Hirata",
  "penerbit": "Bentang Pustaka",
  "tahun_terbit": 2005,
  "isbn": "9789793062792",
  "stok": 3,
  "category_id": 1
}
```

<a id="body-peminjaman"></a>
### Peminjaman — `POST /api/loans`

```json
{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-10-26",
  "tanggal_kembali": "2026-11-02",
  "book_ids": [1]
}
```

## Rincian validasi

### Buku

`POST /api/books` dan `PUT /api/books/{id}` menerima field berikut:

| Field | Ketentuan |
|---|---|
| `judul` | Wajib, string, maksimal 200 karakter |
| `penulis` | Wajib, string, maksimal 100 karakter |
| `penerbit` | Wajib, string, maksimal 100 karakter |
| `tahun_terbit` | Wajib, integer, antara 1900 dan tahun berjalan |
| `isbn` | Opsional/null, string, maksimal 20 karakter; kolom database memiliki constraint unik |
| `stok` | Wajib, integer, minimal 0 |
| `category_id` | Wajib, integer, harus cocok dengan ID kategori yang ada |

Request pembaruan buku juga wajib mengirim seluruh field wajib; ini bukan partial update. Field `sampul` muncul pada response resource, tetapi tidak diterima dalam validasi store/update saat ini.

Pada `POST`, aturan request tidak mengecek keunikan ISBN; duplikasi ditolak oleh constraint database dan dapat menghasilkan error server. Pada `PUT`, aturan validasi secara eksplisit mengecek keunikan ISBN (dengan mengecualikan record buku yang sedang diperbarui), sehingga ISBN duplikat menghasilkan **422**.

Contoh response validasi buku yang gagal (`category_id` tidak terdaftar), status **422**:

```json
{
  "message": "Kategori yang dipilih tidak tersedia.",
  "errors": {
    "category_id": [
      "Kategori yang dipilih tidak tersedia."
    ]
  }
}
```

### Peminjaman

`POST /api/loans` menerima:

| Field | Ketentuan |
|---|---|
| `member_id` | Wajib, integer, harus cocok dengan ID anggota yang ada |
| `user_id` | Wajib, integer, harus cocok dengan ID user/petugas yang ada |
| `tanggal_pinjam` | Wajib, tanggal valid |
| `tanggal_kembali` | Wajib, tanggal valid dan tidak sebelum `tanggal_pinjam` |
| `book_ids` | Wajib, array berisi minimal satu ID buku |
| `book_ids.*` | Setiap elemen harus berupa integer dan cocok dengan ID buku yang ada |

Peminjaman sukses mengurangi stok setiap buku. Jika salah satu stok habis, proses transaksi dibatalkan dan source melempar exception, yang menghasilkan status **500**. Validasi gagal menghasilkan **422** dengan format Laravel, misalnya:

```json
{
  "message": "The selected member id is invalid.",
  "errors": {
    "member_id": [
      "The selected member id is invalid."
    ]
  }
}
```

Pengembalian mengubah status menjadi `dikembalikan`, mengisi `tanggal_dikembalikan` dengan tanggal saat request, dan menambah kembali stok buku. Jika peminjaman sudah dikembalikan, response **422**:

```json
{
  "message": "Peminjaman ini sudah dikembalikan sebelumnya."
}
```

## Catatan endpoint

- Response satu resource menggunakan pembungkus `data`; response daftar memiliki `data`, `links`, dan `meta`.
- ID pada body harus cocok dengan record yang tersedia di database.
- Endpoint anggota yang tersedia hanya `GET /api/members` dan `GET /api/members/{id}`.
