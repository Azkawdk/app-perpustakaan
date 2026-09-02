Nama    : Muhammad Rillo Aditya Azka Saputra
NRP     : 3125500051
Kelas   : D3 TEKNIK INFORMATIKA B

Tentu. Kalau kamu sedang belajar **PHP dan web development**, Laravel adalah salah satu framework yang sangat penting untuk dipahami. Aku akan jelaskan dari **dasar sampai konsep yang lebih lanjut**, termasuk struktur folder, MVC, routing, controller, model, migration, database, Blade, middleware, authentication, API, sampai contoh project.

# 📚 Panduan Lengkap Laravel

## 1. Apa Itu Laravel?

**Laravel** adalah framework PHP yang digunakan untuk membangun aplikasi web.

Laravel menyediakan berbagai fitur yang membuat pengembangan aplikasi PHP menjadi lebih:

* Terstruktur
* Cepat
* Aman
* Mudah dikembangkan
* Mudah dipelihara
* Cocok untuk aplikasi kecil hingga besar

Tanpa framework, aplikasi PHP biasanya bisa menjadi seperti:

```text
index.php
login.php
register.php
proses_login.php
proses_register.php
koneksi.php
produk.php
edit_produk.php
hapus_produk.php
...
```

Ketika aplikasinya semakin besar, kode akan sulit dikelola.

Laravel memberikan struktur yang lebih jelas:

```text
Laravel Project
│
├── app/
│   ├── Models/
│   └── Http/
│       ├── Controllers/
│       └── Middleware/
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── api.php
│
└── public/
```

---

# 2. Laravel Menggunakan PHP

Laravel adalah framework yang dibangun menggunakan **PHP**.

Jadi kalau kamu sudah memahami:

```text
PHP
HTML
CSS
JavaScript
SQL
MySQL
```

belajar Laravel akan jauh lebih mudah.

Contohnya PHP biasa:

```php
<?php

$nama = "Rillo";

echo "Halo $nama";
```

Di Laravel, PHP tetap digunakan, tetapi Laravel menyediakan struktur dan fitur tambahan.

---

# 3. Kenapa Menggunakan Laravel?

Beberapa alasan Laravel populer:

### 1. MVC

Laravel menggunakan konsep:

```text
Model
View
Controller
```

### 2. Routing

Laravel menyediakan sistem routing:

```php
Route::get('/home', function () {
    return view('home');
});
```

### 3. ORM Eloquent

Database bisa diakses menggunakan model:

```php
User::all();
```

daripada harus selalu menulis SQL manual.

### 4. Migration

Struktur database dapat dibuat menggunakan kode.

### 5. Blade

Laravel mempunyai template engine bernama **Blade**.

### 6. Middleware

Middleware dapat digunakan untuk:

* authentication
* authorization
* logging
* filtering request

### 7. Validation

Laravel menyediakan validasi form.

### 8. Authentication

Laravel mempunyai ekosistem yang mempermudah pembuatan login/register.

### 9. API

Laravel dapat digunakan untuk membuat REST API.

---

# 4. Konsep MVC

Ini adalah salah satu konsep **paling penting dalam Laravel**.

MVC:

```text
M = Model
V = View
C = Controller
```

Misalnya kita membuat aplikasi toko online.

User membuka:

```text
/products
```

Alurnya kira-kira:

```text
Browser
   │
   ▼
Route
   │
   ▼
Controller
   │
   ▼
Model
   │
   ▼
Database
   │
   ▼
Model
   │
   ▼
Controller
   │
   ▼
View
   │
   ▼
Browser
```

---

# 5. Model

**Model** bertugas berhubungan dengan data/database.

Contohnya:

```php
Product.php
```

Model:

```php
class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock'
    ];
}
```

Model tersebut mewakili tabel:

```text
products
```

Misalnya database:

| id | name   |    price | stock |
| -: | ------ | -------: | ----: |
|  1 | Laptop | 10000000 |     5 |
|  2 | Mouse  |   150000 |    20 |

Dengan Eloquent:

```php
$products = Product::all();
```

Laravel akan mengambil data dari database.

---

# 6. View

**View** adalah bagian yang ditampilkan kepada user.

Laravel menggunakan:

```text
Blade
```

File Blade biasanya:

```text
resources/views/
```

Contoh:

```text
resources/views/products/index.blade.php
```

Isi:

```blade
<h1>Daftar Produk</h1>

@foreach ($products as $product)

    <h2>{{ $product->name }}</h2>

    <p>Rp {{ $product->price }}</p>

@endforeach
```

---

# 7. Controller

Controller menjadi penghubung antara:

```text
Route
 ↓
Controller
 ↓
Model
 ↓
View
```

Contoh:

```php
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }
}
```

---

# 8. Routing Laravel

Routing menentukan:

> URL ini akan menjalankan kode apa?

File utama:

```text
routes/web.php
```

Contoh:

```php
Route::get('/', function () {
    return "Hello Laravel";
});
```

Jika server Laravel berjalan di:

```text
http://localhost:8000
```

maka:

```text
http://localhost:8000/
```

akan menghasilkan:

```text
Hello Laravel
```

---

# 9. HTTP Method

Laravel mendukung berbagai HTTP method.

### GET

Untuk mengambil/menampilkan data:

```php
Route::get('/products', function () {
    //
});
```

### POST

Untuk mengirim data:

```php
Route::post('/products', function () {
    //
});
```

### PUT

Untuk update:

```php
Route::put('/products/{id}', function ($id) {
    //
});
```

### PATCH

Untuk update sebagian:

```php
Route::patch('/products/{id}', function ($id) {
    //
});
```

### DELETE

Untuk menghapus:

```php
Route::delete('/products/{id}', function ($id) {
    //
});
```

---

# 10. Route Parameter

Misalnya:

```php
Route::get('/products/{id}', function ($id) {
    return "Produk ID: " . $id;
});
```

Jika membuka:

```text
/products/10
```

hasilnya:

```text
Produk ID: 10
```

---

# 11. Route ke Controller

Daripada menulis logic langsung di route:

```php
Route::get('/products', function () {
    // banyak kode
});
```

lebih baik:

```php
Route::get('/products', [ProductController::class, 'index']);
```

Artinya:

```text
/products
     ↓
ProductController
     ↓
index()
```

---

# 12. Controller CRUD

Misalnya:

```bash
php artisan make:controller ProductController --resource
```

Laravel akan membuat controller dengan method:

```php
index()
create()
store()
show()
edit()
update()
destroy()
```

Ini digunakan untuk CRUD.

---

# 13. CRUD

CRUD adalah:

```text
C = Create
R = Read
U = Update
D = Delete
```

Contohnya aplikasi:

```text
Manajemen Produk
```

### Create

Menambahkan produk.

### Read

Melihat produk.

### Update

Mengedit produk.

### Delete

Menghapus produk.

---

# 14. Resource Route

Laravel mempermudah CRUD menggunakan:

```php
Route::resource('products', ProductController::class);
```

Secara konsep Laravel membuat route seperti:

| Method    | URL                        | Controller |
| --------- | -------------------------- | ---------- |
| GET       | `/products`                | index      |
| GET       | `/products/create`         | create     |
| POST      | `/products`                | store      |
| GET       | `/products/{product}`      | show       |
| GET       | `/products/{product}/edit` | edit       |
| PUT/PATCH | `/products/{product}`      | update     |
| DELETE    | `/products/{product}`      | destroy    |

Ini sangat berguna untuk aplikasi CRUD.

---

# 15. Artisan

Laravel memiliki command-line tool bernama:

```text
Artisan
```

Biasanya digunakan melalui:

```bash
php artisan
```

Untuk melihat semua command:

```bash
php artisan list
```

---

# 16. Membuat Controller

```bash
php artisan make:controller ProductController
```

Resource controller:

```bash
php artisan make:controller ProductController --resource
```

---

# 17. Membuat Model

```bash
php artisan make:model Product
```

Model sekaligus migration:

```bash
php artisan make:model Product -m
```

Model + migration + controller:

```bash
php artisan make:model Product -mc
```

Bahkan bisa:

```bash
php artisan make:model Product -mcr
```

Artinya membuat:

```text
Model
Migration
Controller
Resource
```

---

# 18. Migration

Migration digunakan untuk mendefinisikan struktur database menggunakan kode.

Misalnya:

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->integer('price');
    $table->integer('stock');
    $table->timestamps();
});
```

Struktur database menjadi:

```text
products
----------------
id
name
price
stock
created_at
updated_at
```

---

# 19. Menjalankan Migration

Setelah konfigurasi database selesai:

```bash
php artisan migrate
```

Laravel akan membuat tabel berdasarkan migration.

---

# 20. Membatalkan Migration

Untuk rollback:

```bash
php artisan migrate:rollback
```

Untuk menghapus semua migration:

```bash
php artisan migrate:reset
```

Untuk mengulang migration:

```bash
php artisan migrate:refresh
```

Untuk menghapus database lalu menjalankan migration lagi:

```bash
php artisan migrate:fresh
```

**Hati-hati dengan `migrate:fresh`**, karena tabel database akan dihapus lalu dibuat ulang.

---

# 21. Konfigurasi Database

Laravel biasanya menggunakan file:

```text
.env
```

Contoh:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko
DB_USERNAME=root
DB_PASSWORD=
```

Misalnya database MySQL:

```text
toko
```

maka:

```env
DB_DATABASE=toko
```

---

# 22. Eloquent ORM

Eloquent adalah ORM Laravel.

ORM:

> Object Relational Mapping

Tujuannya membuat interaksi database menjadi lebih mudah menggunakan object/model.

Misalnya:

```php
Product::all();
```

Mengambil semua produk.

---

# 23. Mengambil Data

Semua:

```php
Product::all();
```

Berdasarkan ID:

```php
Product::find(1);
```

First:

```php
Product::first();
```

Where:

```php
Product::where('price', '>', 1000000)->get();
```

---

# 24. Insert Data

```php
$product = new Product();

$product->name = "Laptop";
$product->price = 10000000;
$product->stock = 5;

$product->save();
```

Atau:

```php
Product::create([
    'name' => 'Laptop',
    'price' => 10000000,
    'stock' => 5
]);
```

Tetapi untuk `create()`, field harus diizinkan melalui `$fillable` atau mekanisme mass assignment yang sesuai.

---

# 25. Update Data

```php
$product = Product::find(1);

$product->name = "Laptop Gaming";
$product->price = 12000000;

$product->save();
```

---

# 26. Delete Data

```php
$product = Product::find(1);

$product->delete();
```

---

# 27. Blade Template

Blade adalah template engine Laravel.

File:

```text
.blade.php
```

Contoh:

```blade
<h1>{{ $title }}</h1>
```

---

# 28. Menampilkan Variabel

```blade
{{ $nama }}
```

Misalnya controller:

```php
return view('home', [
    'nama' => 'Rillo'
]);
```

Blade:

```blade
<h1>Halo {{ $nama }}</h1>
```

Hasil:

```text
Halo Rillo
```

---

# 29. Conditional Blade

```blade
@if ($age >= 17)

    <p>Sudah cukup umur</p>

@else

    <p>Belum cukup umur</p>

@endif
```

---

# 30. Looping Blade

```blade
@foreach ($products as $product)

    <p>{{ $product->name }}</p>

@endforeach
```

---

# 31. Blade Layout

Misalnya kita mempunyai:

```text
layouts/
    app.blade.php
```

Layout:

```blade
<html>

<head>
    <title>@yield('title')</title>
</head>

<body>

    @yield('content')

</body>

</html>
```

Kemudian halaman:

```blade
@extends('layouts.app')

@section('title', 'Products')

@section('content')

<h1>Daftar Produk</h1>

@endsection
```

Keuntungannya kita tidak perlu menulis:

```html
<html>
<head>
<body>
```

berulang kali.

---

# 32. Form Laravel

Contoh:

```blade
<form action="/products" method="POST">

    @csrf

    <input type="text" name="name">

    <input type="number" name="price">

    <button type="submit">
        Simpan
    </button>

</form>
```

---

# 33. Apa Itu `@csrf`?

CSRF:

> Cross-Site Request Forgery

Laravel menyediakan perlindungan CSRF.

Pada form POST Laravel biasanya membutuhkan:

```blade
@csrf
```

Ini menghasilkan token keamanan.

Jangan menghapus `@csrf` dari form POST tanpa memahami konsekuensinya.

---

# 34. Validation

Misalnya:

```php
$request->validate([
    'name' => 'required',
    'price' => 'required|numeric',
    'stock' => 'required|integer'
]);
```

Laravel akan memeriksa:

```text
name  → wajib
price → wajib + angka
stock → wajib + integer
```

---

# 35. Contoh Controller Store

```php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|integer'
    ]);

    Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock
    ]);

    return redirect('/products');
}
```

---

# 36. Middleware

Middleware bisa dianggap sebagai:

> "penjaga pintu" sebelum request masuk ke aplikasi.

Contohnya:

```text
User
 ↓
Middleware
 ↓
Controller
```

Misalnya halaman admin hanya boleh diakses user yang sudah login.

```text
/admin
   ↓
Auth Middleware
   ↓
Login?
 ┌───┴────┐
Ya       Tidak
↓          ↓
Admin     Login
```

---

# 37. Authentication

Authentication berarti:

> Memastikan siapa user tersebut.

Contoh:

```text
Login
 ↓
Email
Password
 ↓
Authentication
 ↓
Dashboard
```

Laravel memiliki ekosistem resmi untuk membantu scaffolding authentication, dan pilihan paketnya dapat berbeda menurut versi Laravel.

---

# 38. Authorization

Authentication:

> "Kamu siapa?"

Authorization:

> "Kamu boleh melakukan apa?"

Misalnya:

```text
Admin
 ├── tambah produk
 ├── edit produk
 ├── hapus produk
 └── melihat laporan

User
 ├── melihat produk
 └── membeli produk
```

---

# 39. Relationship Database

Ini bagian penting dalam aplikasi yang lebih besar.

Misalnya:

```text
users
products
orders
order_items
```

Relasinya:

```text
User
 │
 └── memiliki banyak Order
          │
          └── memiliki banyak OrderItem
                       │
                       └── Product
```

---

# 40. One to One

Contoh:

```text
User
 │
 └── Profile
```

Model:

```php
public function profile()
{
    return $this->hasOne(Profile::class);
}
```

---

# 41. One to Many

Contoh:

```text
User
 │
 ├── Post
 ├── Post
 └── Post
```

Model User:

```php
public function posts()
{
    return $this->hasMany(Post::class);
}
```

Model Post:

```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

---

# 42. Many to Many

Contoh:

```text
Students
     ↕
Enrollments
     ↕
Courses
```

Satu student dapat mengambil banyak course.

Satu course dapat mempunyai banyak student.

Laravel menggunakan:

```php
belongsToMany()
```

---

# 43. Seeder

Seeder digunakan untuk memasukkan data awal.

Misalnya:

```text
Admin
Produk
Kategori
```

Buat seeder:

```bash
php artisan make:seeder ProductSeeder
```

Contoh:

```php
Product::create([
    'name' => 'Laptop',
    'price' => 10000000,
    'stock' => 10
]);
```

Jalankan:

```bash
php artisan db:seed
```

---

# 44. Factory

Factory digunakan untuk membuat data dummy.

Contohnya:

```text
100 User
500 Product
1000 Order
```

Untuk testing/development.

Contoh konsep:

```php
User::factory()->count(100)->create();
```

---

# 45. Laravel API

Laravel juga dapat digunakan untuk membuat backend API.

Misalnya:

```text
GET /api/products
```

Response:

```json
[
    {
        "id": 1,
        "name": "Laptop",
        "price": 10000000
    }
]
```

Frontend seperti:

```text
React
Vue
Angular
Flutter
Android
```

dapat mengakses API tersebut.

---

# 46. Laravel + React

Arsitektur modern bisa seperti:

```text
React
   │
   │ HTTP/API
   ▼
Laravel
   │
   ▼
MySQL
```

React mengurus:

```text
UI
Frontend
State
```

Laravel mengurus:

```text
API
Business Logic
Authentication
Database
```

---

# 47. Laravel + MySQL

Stack yang sangat umum:

```text
Frontend
   │
HTML/CSS/JS
   │
Laravel
   │
Eloquent
   │
MySQL
```

Untuk project kuliah, CRUD, sistem informasi, maupun aplikasi bisnis, kombinasi ini sangat bagus untuk dipelajari.

---

# 48. Struktur Folder Laravel

Struktur sederhananya:

```text
project/
│
├── app/
│
├── bootstrap/
│
├── config/
│
├── database/
│
├── public/
│
├── resources/
│
├── routes/
│
├── storage/
│
├── tests/
│
├── vendor/
│
├── .env
├── artisan
└── composer.json
```

Mari kita bahas.

---

# 49. Folder `app`

Berisi kode utama aplikasi.

Misalnya:

```text
app/
├── Models/
└── Http/
    ├── Controllers/
    └── Middleware/
```

---

# 50. Folder `Models`

Berisi model:

```text
User.php
Product.php
Order.php
Category.php
```

---

# 51. Folder `Http/Controllers`

Berisi controller:

```text
ProductController.php
UserController.php
OrderController.php
```

---

# 52. Folder `resources`

Berisi resource frontend.

Misalnya:

```text
resources/
├── views/
├── css/
└── js/
```

Blade berada di:

```text
resources/views
```

---

# 53. Folder `routes`

Berisi route.

Umumnya:

```text
routes/
├── web.php
└── api.php
```

Tergantung versi dan konfigurasi Laravel yang digunakan, struktur route yang tersedia bisa berbeda.

---

# 54. Folder `database`

Berisi:

```text
migrations/
seeders/
factories/
```

Ini sangat penting untuk database development.

---

# 55. Folder `public`

Folder yang dapat diakses oleh web server.

Biasanya berisi:

```text
index.php
favicon.ico
assets
```

Dalam deployment, web server sebaiknya diarahkan ke:

```text
public/
```

bukan root project Laravel.

---

# 56. File `.env`

Berisi konfigurasi environment.

Contoh:

```env
APP_NAME=LaravelApp
APP_ENV=local
APP_KEY=...
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

**Jangan sembarangan membagikan `.env`**, karena dapat berisi credential atau secret.

---

# 57. Composer

Laravel menggunakan:

```text
Composer
```

untuk dependency PHP.

Contoh:

```bash
composer install
```

atau:

```bash
composer update
```

File penting:

```text
composer.json
```

---

# 58. NPM

Laravel juga sering menggunakan Node.js/NPM untuk frontend assets.

Contohnya:

```bash
npm install
```

Kemudian:

```bash
npm run dev
```

Untuk build production:

```bash
npm run build
```

---

# 59. Instalasi Laravel

Secara umum kamu membutuhkan:

```text
PHP
Composer
Node.js + NPM
Database
```

Kemudian project Laravel dapat dibuat menggunakan Composer.

Contoh:

```bash
composer create-project laravel/laravel toko
```

Masuk:

```bash
cd toko
```

Jalankan:

```bash
php artisan serve
```

Kemudian buka:

```text
http://localhost:8000
```

**Catatan:** perintah dan requirement dapat berubah antar versi Laravel, jadi untuk project baru sebaiknya cek dokumentasi resmi versi Laravel yang sedang kamu gunakan.

---

# 60. Alur Kerja Laravel

Misalnya user membuka:

```text
/products
```

Prosesnya:

```text
                Browser
                   │
                   ▼
             HTTP Request
                   │
                   ▼
                Route
                   │
                   ▼
          ProductController
                   │
                   ▼
              Product Model
                   │
                   ▼
                MySQL
                   │
                   ▼
              Product Model
                   │
                   ▼
          ProductController
                   │
                   ▼
             Blade View
                   │
                   ▼
                HTML
                   │
                   ▼
                Browser
```

Ini adalah konsep yang sangat penting.

---

# 61. Contoh Project Laravel Sederhana

Misalnya kita ingin membuat:

# 🛒 Sistem Manajemen Produk

Fitur:

```text
Login
Dashboard
Produk
 ├── Tambah
 ├── Lihat
 ├── Edit
 └── Hapus

Kategori
 ├── Tambah
 ├── Edit
 └── Hapus

User
 └── Logout
```

Struktur:

```text
Laravel
│
├── Authentication
│
├── Dashboard
│
├── Products
│   ├── Index
│   ├── Create
│   ├── Edit
│   └── Show
│
├── Categories
│
└── Users
```

---

# 62. Contoh Migration Product

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 12, 2);
    $table->integer('stock');
    $table->timestamps();
});
```

---

# 63. Model Product

```php
class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock'
    ];
}
```

---

# 64. Controller

```php
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }
}
```

---

# 65. Route

```php
use App\Http\Controllers\ProductController;

Route::resource(
    'products',
    ProductController::class
);
```

---

# 66. View

```blade
<h1>Daftar Produk</h1>

<a href="/products/create">
    Tambah Produk
</a>

@foreach ($products as $product)

    <div>
        <h2>{{ $product->name }}</h2>

        <p>
            Rp {{ number_format($product->price) }}
        </p>

        <p>
            Stok: {{ $product->stock }}
        </p>
    </div>

@endforeach
```

Dengan beberapa bagian tersebut kita sudah memiliki dasar aplikasi CRUD.

---

# 67. Laravel Service Container

Ini merupakan konsep Laravel yang lebih advanced.

Service Container digunakan Laravel untuk mengelola dependency.

Misalnya:

```php
class ProductController
{
    public function __construct(
        ProductService $productService
    ) {
        $this->productService = $productService;
    }
}
```

Laravel dapat melakukan dependency injection terhadap class tersebut.

Konsep ini penting ketika aplikasi mulai besar.

---

# 68. Service Layer

Untuk project sederhana, logic dapat berada di controller.

Tetapi ketika project semakin besar:

```text
Controller
     │
     ▼
Service
     │
     ▼
Repository / Model
     │
     ▼
Database
```

Contohnya:

```text
ProductController
       ↓
ProductService
       ↓
Product Model
       ↓
MySQL
```

Tujuannya agar controller tidak terlalu penuh.

---

# 69. Events & Listeners

Laravel juga mempunyai event system.

Contoh:

```text
User Registered
       │
       ├── Kirim email
       ├── Buat profile
       └── Catat aktivitas
```

Event:

```text
UserRegistered
```

Listener:

```text
SendWelcomeEmail
```

Ini berguna untuk aplikasi kompleks.

---

# 70. Queue

Queue digunakan untuk pekerjaan yang tidak harus dilakukan langsung.

Contoh:

```text
User upload file
       ↓
Laravel
       ↓
Queue
       ↓
Process file
```

Atau:

```text
Kirim 10.000 email
```

Daripada membuat user menunggu lama, pekerjaan dapat diproses oleh queue worker.

---

# 71. Job

Job merepresentasikan pekerjaan yang dapat dijalankan.

Contoh konsep:

```text
SendEmailJob
GenerateReportJob
ProcessImageJob
```

Kemudian job dimasukkan ke queue.

---

# 72. Task Scheduling

Laravel mempunyai scheduler untuk menjalankan pekerjaan berdasarkan waktu.

Contoh:

```text
Setiap hari 00:00
        ↓
Backup database
```

atau:

```text
Setiap jam
   ↓
Update data
```

---

# 73. File Storage

Laravel menyediakan abstraction untuk penyimpanan file.

Contohnya:

```text
Foto profil
Foto produk
Dokumen
PDF
```

Dengan filesystem Laravel, aplikasi dapat bekerja dengan storage lokal maupun layanan cloud yang didukung.

---

# 74. Pagination

Misalnya terdapat:

```text
10.000 produk
```

Jangan menampilkan semuanya sekaligus.

Gunakan:

```php
$products = Product::paginate(10);
```

Kemudian di Blade:

```blade
{{ $products->links() }}
```

Hasilnya:

```text
1 2 3 4 5 Next
```

---

# 75. Query Builder

Selain Eloquent, Laravel menyediakan Query Builder.

Contoh:

```php
$products = DB::table('products')
    ->where('stock', '>', 0)
    ->get();
```

Jadi Laravel memberikan beberapa cara berinteraksi dengan database:

```text
Eloquent ORM
Query Builder
Raw SQL
```

---

# 76. Security Laravel

Laravel memiliki berbagai fitur keamanan dan developer tooling, seperti:

* CSRF protection
* Password hashing
* Validation
* Authentication ecosystem
* Authorization
* SQL injection mitigation melalui parameterized queries/Eloquent
* Secure cookie/session mechanisms
* Encryption facilities

Tetapi **Laravel bukan berarti aplikasi otomatis aman**.

Developer tetap harus memperhatikan:

```text
Validation
Authorization
Authentication
Input handling
File upload
Secrets
Dependencies
Database permissions
```

---

# 77. Laravel dan XAMPP

Kalau sebelumnya kamu menggunakan:

```text
XAMPP
PHP
MySQL
phpMyAdmin
```

Laravel tetap bisa menggunakan MySQL dari XAMPP.

Misalnya:

```text
XAMPP
├── Apache
└── MySQL
```

Database:

```text
MySQL
   ↓
laravel_db
```

Laravel:

```text
Laravel
   ↓
.env
   ↓
MySQL XAMPP
```

Tetapi untuk menjalankan aplikasi Laravel, kamu tidak harus menggunakan Apache XAMPP; development server Laravel juga dapat digunakan.

---

# 78. Laravel vs PHP Native

| PHP Native                         | Laravel                        |
| ---------------------------------- | ------------------------------ |
| Struktur dibuat sendiri            | Struktur sudah tersedia        |
| Routing manual                     | Routing tersedia               |
| ORM tidak built-in                 | Eloquent                       |
| Validation manual                  | Validation tersedia            |
| Security banyak dikerjakan sendiri | Banyak fitur security tersedia |
| CRUD lebih panjang                 | CRUD lebih terstruktur         |
| Cocok belajar dasar PHP            | Cocok aplikasi modern          |
| Lebih bebas                        | Lebih opinionated/terstruktur  |

Contoh PHP native:

```php
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
```

Laravel:

```php
$products = Product::all();
```

---

# 79. Laravel vs CodeIgniter

| Laravel                 | CodeIgniter                           |
| ----------------------- | ------------------------------------- |
| Fitur sangat lengkap    | Lebih ringan/sederhana                |
| Eloquent ORM            | Query Builder/Model                   |
| Blade                   | View system                           |
| Artisan                 | Spark/CLI tooling                     |
| Ekosistem besar         | Lebih minimal                         |
| Cocok aplikasi kompleks | Cocok aplikasi ringan hingga menengah |

Keduanya bagus, tetapi Laravel sangat populer untuk pengembangan aplikasi PHP modern.

---

# 80. Laravel untuk Apa?

Laravel dapat digunakan untuk membuat:

### Sistem Informasi

```text
Sistem Akademik
Sistem Perpustakaan
Sistem Rumah Sakit
Sistem Inventaris
Sistem Keuangan
```

### E-Commerce

```text
Produk
Cart
Checkout
Order
Payment
```

### Website

```text
Blog
Portal berita
Company profile
CMS
```

### API

```text
REST API
Mobile backend
React backend
Vue backend
```

### Sistem Admin

```text
Dashboard
CRUD
User management
Role & permission
Reports
```

---

# 81. Roadmap Belajar Laravel

Kalau kamu ingin serius belajar Laravel, **jangan langsung lompat ke authentication/API/Livewire**.

Ikuti urutan:

```text
                PHP
                 │
                 ▼
              OOP PHP
                 │
                 ▼
             Composer
                 │
                 ▼
              Laravel
                 │
       ┌─────────┴─────────┐
       ▼                   ▼
    Routing              Blade
       │                   │
       └─────────┬─────────┘
                 ▼
             Controller
                 │
                 ▼
               Model
                 │
                 ▼
             Migration
                 │
                 ▼
              MySQL
                 │
                 ▼
              Eloquent
                 │
                 ▼
               CRUD
                 │
                 ▼
            Validation
                 │
                 ▼
             Middleware
                 │
                 ▼
        Authentication
                 │
                 ▼
        Authorization
                 │
                 ▼
          Relationships
                 │
                 ▼
              API
                 │
                 ▼
        Testing / Deployment
```

---

# 82. Urutan Materi yang Saya Sarankan

Kalau kamu ingin belajar Laravel dari **nol sampai bisa membuat project**, saya sarankan:

### LEVEL 1 — Fundamental

Pelajari:

```text
1. PHP dasar
2. Function
3. Array
4. Form
5. Session
6. OOP PHP
7. SQL
8. MySQL
9. Composer
```

### LEVEL 2 — Laravel Basic

```text
10. Instalasi Laravel
11. Struktur folder
12. Artisan
13. Routing
14. Controller
15. Blade
16. Layout Blade
```

### LEVEL 3 — Database

```text
17. Migration
18. Model
19. Eloquent
20. Query Builder
21. Seeder
22. Factory
```

### LEVEL 4 — CRUD

```text
23. Create
24. Read
25. Update
26. Delete
27. Validation
28. Pagination
29. Search
30. Upload file
```

### LEVEL 5 — Security

```text
31. Middleware
32. Authentication
33. Authorization
34. CSRF
35. Hashing
36. Session
37. Roles & Permissions
```

### LEVEL 6 — Advanced

```text
38. Relationships
39. API
40. API Authentication
41. Events
42. Listeners
43. Queue
44. Jobs
45. Scheduler
46. Notifications
47. Mail
48. Cache
```

### LEVEL 7 — Professional

```text
49. Testing
50. Git
51. Deployment
52. Environment configuration
53. Database optimization
54. Query optimization
55. Security
56. Architecture
57. Docker
58. CI/CD
```

---

# 83. Project Latihan yang Bagus

Untuk belajar Laravel, jangan cuma membaca teori.

Buat project bertahap:

### Project 1

**Todo List**

```text
Tambah task
Edit task
Hapus task
Centang selesai
```

### Project 2

**Manajemen Produk**

```text
CRUD Produk
CRUD Kategori
Search
Pagination
Upload gambar
```

### Project 3

**Sistem Perpustakaan**

```text
User
Buku
Kategori
Peminjaman
Pengembalian
```

### Project 4

**Sistem Akademik**

```text
Mahasiswa
Dosen
Mata Kuliah
KRS
Nilai
```

### Project 5

**E-Commerce**

```text
User
Product
Category
Cart
Order
Payment
Admin
Dashboard
```

---

# 84. Inti Laravel yang Wajib Kamu Pahami

Kalau nanti kamu ditanya:

> "Apa itu Laravel?"

Jawaban sederhananya:

> **Laravel adalah framework PHP untuk membangun aplikasi web secara terstruktur dengan berbagai fitur seperti routing, MVC, Blade, Eloquent ORM, migration, validation, middleware, authentication, dan API.**

Dan kalau ditanya:

> "Bagaimana alur Laravel?"

Ingat:

```text
USER
 ↓
ROUTE
 ↓
CONTROLLER
 ↓
MODEL
 ↓
DATABASE
 ↓
MODEL
 ↓
CONTROLLER
 ↓
VIEW
 ↓
USER
```

Sedangkan konsep besarnya:

```text
                LARAVEL
                   │
       ┌───────────┼───────────┐
       │           │           │
     ROUTE      CONTROLLER    VIEW
       │           │         (Blade)
       │           │
       └───────────┤
                   │
                 MODEL
                   │
                ELOQUENT
                   │
                DATABASE
```

**Kalau kamu sudah benar-benar memahami `Route → Controller → Model → Eloquent → Database → View/Blade`, kamu sudah memegang fondasi utama Laravel.** Setelah itu baru naik ke Authentication, Middleware, Relationship, API, Queue, Testing, dan Deployment.
#   a p p - p e r p u s t a k a a n  
 #   a p p - p e r p u s t a k a a n  
 #   a p p - p e r p u s t a k a a n  
 