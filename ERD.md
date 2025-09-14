# Dokumentasi Sistem HASTANA Indonesia

## 📋 Daftar Isi

1.  1. Overview Sistem
2.  2. Entity Relationship Diagram (ERD)
3.  3. Database Schema
4.  4. API Documentation
5.  5. Installation Guide
6.  6. User Manual
7.  7. Developer Guide

## 🎯 Overview Sistem

### Tentang HASTANA Indonesia

HASTANA (Himpunan Perusahaan Penata Acara Indonesia) adalah organisasi yang menaungi wedding organizer profesional di seluruh Indonesia. Sistem web aplikasi ini dirancang untuk:

-   Mengelola keanggotaan perusahaan wedding organizer
-   Menyediakan platform showcase portfolio
-   Menyelenggarakan program sertifikasi dan pelatihan
-   Memfasilitasi networking antar anggota
-   Memberikan direktori lengkap wedding organizer Indonesia

### Fitur Utama

✅ Manajemen Keanggotaan

-   Pendaftaran dan verifikasi anggota
-   Sistem membership bertingkat (Regular, Premium, Platinum)
-   Tracking iuran keanggotaan
    ✅ Portfolio Management

-   Showcase karya wedding organizer
-   Galeri foto dan video
-   Kategorisasi berdasarkan jenis acara
    ✅ Sistem Sertifikasi

-   Program sertifikasi bertingkat
-   Tracking kompetensi anggota
-   Validasi kredibilitas
    ✅ Program Pelatihan

-   Workshop dan training
-   Manajemen peserta
-   Sertifikat completion
    ✅ Direktori Perusahaan

-   Database lengkap wedding organizer
-   Filter berdasarkan lokasi dan layanan
-   Sistem rating dan review
    ✅ Portal Informasi

-   Berita industri
-   Update organisasi
-   Event dan pengumuman

## 🗂️ Entity Relationship Diagram (ERD)

### Entitas Utama

erDiagram
USERS {
id bigint PK
username string
email string
password string
full_name string
phone string
role enum
status enum
created_at timestamp
updated_at timestamp
}

    COMPANIES {
        id bigint PK
        company_name string
        business_license string
        owner_name string
        email string
        phone string
        address text
        city string
        province string
        postal_code string
        website string
        description text
        logo_url string
        established_year year
        employee_count int
        membership_status enum
        membership_type enum
        joined_date date
        region_id bigint FK
        created_at timestamp
        updated_at timestamp
    }

    MEMBERS {
        id bigint PK
        user_id bigint FK
        company_id bigint FK
        member_number string
        position string
        join_date date
        membership_fee_status enum
        certification_level enum
        status enum
        created_at timestamp
        updated_at timestamp
    }

    EVENTS {
        id bigint PK
        company_id bigint FK
        event_name string
        event_type enum
        client_name string
        event_date date
        venue string
        city string
        province string
        budget_range string
        guest_count int
        description text
        status enum
        created_at timestamp
        updated_at timestamp
    }

    PORTFOLIOS {
        id bigint PK
        company_id bigint FK
        event_id bigint FK
        title string
        description text
        images json
        video_url string
        category string
        featured boolean
        created_at timestamp
        updated_at timestamp
    }

    USERS ||--o{ MEMBERS : "has"
    COMPANIES ||--o{ MEMBERS : "employs"
    COMPANIES ||--o{ EVENTS : "organizes"
    COMPANIES ||--o{ PORTFOLIOS : "showcases"
    EVENTS ||--o| PORTFOLIOS : "generates"

### Relasi Antar Entitas

Relasi Kardinalitas Deskripsi USERS → MEMBERS 1:N Satu user bisa menjadi member di beberapa perusahaan COMPANIES → MEMBERS 1:N Satu perusahaan memiliki banyak member COMPANIES → EVENTS 1:N Satu perusahaan menghandle banyak event COMPANIES → PORTFOLIOS 1:N Satu perusahaan memiliki banyak portfolio EVENTS → PORTFOLIOS 1:1 atau 1:N Satu event bisa menghasilkan beberapa portfolio MEMBERS → CERTIFICATIONS N:N Member bisa memiliki banyak sertifikat TRAINING_PROGRAMS → MEMBERS N:N Program training diikuti banyak member

## 🗄️ Database Schema

### Tabel Utama 1. users

CREATE TABLE users (
id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(255) UNIQUE NOT NULL,
email VARCHAR(255) UNIQUE NOT NULL,
email_verified_at TIMESTAMP NULL,
password VARCHAR(255) NOT NULL,
full_name VARCHAR(255) NOT NULL,
phone VARCHAR(255) NULL,
role ENUM('admin', 'member', 'guest') DEFAULT 'guest',
status ENUM('active', 'inactive') DEFAULT 'active',
remember_token VARCHAR(100) NULL,
created_at TIMESTAMP NULL,
updated_at TIMESTAMP NULL
);

2. companies
   CREATE TABLE companies (
   id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   company_name VARCHAR(255) NOT NULL,
   business_license VARCHAR(255) UNIQUE NOT NULL,
   owner_name VARCHAR(255) NOT NULL,
   email VARCHAR(255) UNIQUE NOT NULL,
   phone VARCHAR(255) NOT NULL,
   address TEXT NOT NULL,
   city VARCHAR(255) NOT NULL,
   province VARCHAR(255) NOT NULL,
   postal_code VARCHAR(255) NOT NULL,
   website VARCHAR(255) NULL,
   description TEXT NULL,
   logo_url VARCHAR(255) NULL,
   established_year YEAR NULL,
   employee_count INT NULL,
   membership_status ENUM('active', 'pending', 'suspended') DEFAULT 'pending',
   membership_type ENUM('regular', 'premium', 'platinum') DEFAULT 'regular',
   joined_date DATE NULL,
   region_id BIGINT UNSIGNED NULL,
   created_at TIMESTAMP NULL,
   updated_at TIMESTAMP NULL,
   FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE SET NULL
   );

3. members
   CREATE TABLE members (
   id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   user_id BIGINT UNSIGNED NOT NULL,
   company_id BIGINT UNSIGNED NOT NULL,
   member_number VARCHAR(255) UNIQUE NOT NULL,
   position VARCHAR(255) NOT NULL,
   join_date DATE NOT NULL,
   membership_fee_status ENUM('paid', 'pending', 'overdue') DEFAULT 'pending',
   certification_level ENUM('basic', 'intermediate', 'advanced', 'expert') NULL,
   status ENUM('active', 'inactive') DEFAULT 'active',
   created_at TIMESTAMP NULL,
   updated_at TIMESTAMP NULL,
   FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
   FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
   );

Indeks dan Constraints
-- Indeks untuk performa query
CREATE INDEX idx_companies_city ON companies(city);
CREATE INDEX idx_companies_province ON companies(province);
CREATE INDEX idx_events_date ON events(event_date);
CREATE INDEX idx_members_status ON members(status);
CREATE INDEX idx_portfolios_featured ON portfolios(featured);

-- Unique constraints
ALTER TABLE companies ADD CONSTRAINT uk_companies_email UNIQUE (email);
ALTER TABLE companies ADD CONSTRAINT uk_companies_license UNIQUE (business_license);
ALTER TABLE members ADD CONSTRAINT uk_members_number UNIQUE (member_number);

Trae

# Penjelasan Proses Perancangan ERD untuk HASTANA Indonesia

Berikut adalah penjelasan detail proses analisis dan perancangan ERD untuk organisasi HASTANA (Himpunan Perusahaan Penata Acara Indonesia):

## 1. Analisis Kebutuhan Bisnis

### Identifikasi Stakeholder Utama:

-   Admin Organisasi : Mengelola keseluruhan sistem
-   Perusahaan Wedding Organizer : Anggota utama organisasi
-   Member/Karyawan : Individu yang bekerja di perusahaan WO
-   Klien : Pengguna jasa wedding organizer
-   Koordinator Regional : Pengelola wilayah

### Kebutuhan Fungsional:

1.  1. Manajemen Keanggotaan : Pendaftaran, verifikasi, dan pengelolaan anggota
2.  2. Portfolio Management : Showcase karya wedding organizer
3.  3. Sistem Sertifikasi : Tracking kompetensi dan kredibilitas
4.  4. Program Pelatihan : Pengembangan skill anggota
5.  5. Direktori Perusahaan : Database lengkap WO se-Indonesia
6.  6. Sistem Review : Rating dan testimoni klien
7.  7. Manajemen Regional : Pembagian koordinator wilayah
8.  8. Portal Informasi : Berita dan update industri

## 2. Proses Identifikasi Entitas

### Entitas Inti (Core Entities):

```
USERS → MEMBERS → COMPANIES
```

Alasan Pemilihan :

-   USERS : Base entity untuk autentikasi dan otorisasi
-   MEMBERS : Junction entity yang menghubungkan users dengan companies
-   COMPANIES : Entitas utama yang merepresentasikan wedding organizer

### Entitas Pendukung (Supporting Entities):

```
EVENTS, PORTFOLIOS, SERVICES, CERTIFICATIONS, TRAINING_PROGRAMS
```

Alasan Pemilihan :

-   EVENTS : Merekam aktivitas bisnis perusahaan
-   PORTFOLIOS : Showcase hasil kerja untuk marketing
-   SERVICES : Katalog layanan yang ditawarkan
-   CERTIFICATIONS : Standar kompetensi industri
-   TRAINING_PROGRAMS : Pengembangan SDM

### Entitas Operasional:

```
REGIONS, NEWS_ARTICLES, MEMBERSHIP_FEES, COMPANY_REVIEWS
```

## 3. Proses Perancangan Relasi

### Relasi Hierarkis:

```
USERS (1) ←→ (N) MEMBERS (N) ←→ (1) COMPANIES
```

Logika Bisnis :

-   Satu user bisa menjadi member di beberapa perusahaan (freelancer)
-   Satu perusahaan memiliki banyak member (karyawan)
-   Relasi many-to-many diselesaikan dengan junction table MEMBERS

### Relasi Fungsional:

```
COMPANIES (1) ←→ (N) EVENTS (1) ←→ (N) PORTFOLIOS
COMPANIES (1) ←→ (N) SERVICES
COMPANIES (1) ←→ (N) COMPANY_REVIEWS
```

Logika Bisnis :

-   Setiap perusahaan menghandle multiple events
-   Setiap event bisa menghasilkan multiple portfolio items
-   Perusahaan menawarkan berbagai services
-   Perusahaan menerima reviews dari klien

### Relasi Sertifikasi:

```
MEMBERS (N) ←→ (N) CERTIFICATIONS
```

Diselesaikan dengan : MEMBER_CERTIFICATIONS table

Logika Bisnis :

-   Member bisa memiliki multiple sertifikat
-   Satu sertifikat bisa dimiliki banyak member
-   Tracking issue date, expiry date, dan status

### Relasi Pelatihan:

```
TRAINING_PROGRAMS (1) ←→ (N) TRAINING_PARTICIPANTS (N) ←→ (1) MEMBERS
```

Logika Bisnis :

-   Satu program training diikuti banyak peserta
-   Satu member bisa ikut banyak training
-   Tracking payment, attendance, dan completion status

## 4. Proses Normalisasi Database

### First Normal Form (1NF):

-   Semua atribut atomic (tidak ada repeating groups)
-   Contoh: images di PORTFOLIOS menggunakan JSON untuk multiple images

### Second Normal Form (2NF):

-   Eliminasi partial dependency
-   Contoh: Memisahkan REGIONS dari COMPANIES untuk menghindari redundansi data wilayah

### Third Normal Form (3NF):

-   Eliminasi transitive dependency
-   Contoh: CERTIFICATIONS terpisah dari MEMBER_CERTIFICATIONS

## 5. Pertimbangan Khusus Industri Wedding Organizer

### Business Rules Spesifik:

1.  1. Membership Hierarchy :

    ```
    Regular → Premium → Platinum
    ```

    - Berbeda benefit dan fee structure

2.  2. Event Lifecycle :

    ```
    Planned → Ongoing → Completed → Portfolio
    ```

    - Tracking status event untuk reporting

3.  3. Certification Levels :

    ```
    Basic → Intermediate → Advanced → Expert
    ```

    - Progression path untuk member

4.  4. Regional Management :

    ```
    National → Provincial → City
    ```

    - Struktur organisasi berbasis geografis

### Data Integrity Considerations:

1.  1. Referential Integrity :

    - Foreign key constraints untuk menjaga konsistensi
    - Cascade delete untuk data dependent

2.  2. Business Logic Constraints :

    - Event date tidak boleh di masa lalu
    - Expiry date sertifikat harus setelah issue date
    - Rating review harus 1-5

3.  3. Audit Trail :

    - created_at dan updated_at di semua tabel
    - Status tracking untuk perubahan data penting

## 6. Optimasi untuk Performa

### Indexing Strategy:

-   Primary keys (auto-indexed)
-   Foreign keys (auto-indexed)
-   Unique constraints (email, username, business_license)
-   Search fields (company_name, event_name)

### Query Optimization:

-   Denormalisasi terkontrol untuk reporting
-   JSON fields untuk data semi-structured
-   Enum types untuk status fields

## 7. Skalabilitas dan Extensibility

### Future Enhancements:

-   Payment Gateway Integration : Tabel untuk transaction history
-   Document Management : File attachments untuk contracts
-   Communication System : Internal messaging
-   Analytics Dashboard : Reporting dan metrics

### Modular Design:

-   Setiap modul (membership, training, portfolio) bisa dikembangkan independen
-   API-ready structure untuk mobile app integration
-   Multi-tenant ready untuk franchise expansion

## Kesimpulan

ERD ini dirancang dengan pendekatan:

1.  1. User-Centric : Fokus pada experience pengguna
2.  2. Business-Driven : Mengakomodasi semua proses bisnis HASTANA
3.  3. Scalable : Siap untuk pertumbuhan organisasi
4.  4. Maintainable : Struktur yang mudah dipelihara dan dikembangkan
       Desain ini memastikan sistem dapat mendukung ekosistem lengkap industri wedding organizer Indonesia dengan standar profesional yang tinggi.

maknawedding

Copy

Delete

baik terima kasih

bisa tolong dibuatkan dokumentasinya

Trae

# Dokumentasi Sistem HASTANA Indonesia

## 📋 Daftar Isi

1.  1. Overview Sistem
2.  2. Entity Relationship Diagram (ERD)
3.  3. Database Schema
4.  4. API Documentation
5.  5. Installation Guide
6.  6. User Manual
7.  7. Developer Guide

## 🎯 Overview Sistem

### Tentang HASTANA Indonesia

HASTANA (Himpunan Perusahaan Penata Acara Indonesia) adalah organisasi yang menaungi wedding organizer profesional di seluruh Indonesia. Sistem web aplikasi ini dirancang untuk:

-   Mengelola keanggotaan perusahaan wedding organizer
-   Menyediakan platform showcase portfolio
-   Menyelenggarakan program sertifikasi dan pelatihan
-   Memfasilitasi networking antar anggota
-   Memberikan direktori lengkap wedding organizer Indonesia

### Fitur Utama

✅ Manajemen Keanggotaan

-   Pendaftaran dan verifikasi anggota
-   Sistem membership bertingkat (Regular, Premium, Platinum)
-   Tracking iuran keanggotaan
    ✅ Portfolio Management

-   Showcase karya wedding organizer
-   Galeri foto dan video
-   Kategorisasi berdasarkan jenis acara
    ✅ Sistem Sertifikasi

-   Program sertifikasi bertingkat
-   Tracking kompetensi anggota
-   Validasi kredibilitas
    ✅ Program Pelatihan

-   Workshop dan training
-   Manajemen peserta
-   Sertifikat completion
    ✅ Direktori Perusahaan

-   Database lengkap wedding organizer
-   Filter berdasarkan lokasi dan layanan
-   Sistem rating dan review
    ✅ Portal Informasi

-   Berita industri
-   Update organisasi
-   Event dan pengumuman

## 🗂️ Entity Relationship Diagram (ERD)

### Entitas Utama

### Relasi Antar Entitas

Relasi Kardinalitas Deskripsi USERS → MEMBERS 1:N Satu user bisa menjadi member di beberapa perusahaan COMPANIES → MEMBERS 1:N Satu perusahaan memiliki banyak member COMPANIES → EVENTS 1:N Satu perusahaan menghandle banyak event COMPANIES → PORTFOLIOS 1:N Satu perusahaan memiliki banyak portfolio EVENTS → PORTFOLIOS 1:1 atau 1:N Satu event bisa menghasilkan beberapa portfolio MEMBERS → CERTIFICATIONS N:N Member bisa memiliki banyak sertifikat TRAINING_PROGRAMS → MEMBERS N:N Program training diikuti banyak member

## 🗄️ Database Schema

### Tabel Utama 1. users 2. companies 3. members

```
CREATE TABLE members (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    company_id BIGINT UNSIGNED NOT NULL,
    member_number VARCHAR(255) UNIQUE NOT NULL,
    position VARCHAR(255) NOT NULL,
    join_date DATE NOT NULL,
    membership_fee_status ENUM('paid', 'pending', 'overdue') DEFAULT 
    'pending',
    certification_level ENUM('basic', 'intermediate', 'advanced', 
    'expert') NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE 
    CASCADE
);
```

### Indeks dan Constraints

```
-- Indeks untuk performa query
CREATE INDEX idx_companies_city ON companies(city);
CREATE INDEX idx_companies_province ON companies(province);
CREATE INDEX idx_events_date ON events(event_date);
CREATE INDEX idx_members_status ON members(status);
CREATE INDEX idx_portfolios_featured ON portfolios(featured);

-- Unique constraints
ALTER TABLE companies ADD CONSTRAINT uk_companies_email UNIQUE 
(email);
ALTER TABLE companies ADD CONSTRAINT uk_companies_license UNIQUE 
(business_license);
ALTER TABLE members ADD CONSTRAINT uk_members_number UNIQUE 
(member_number);
```

## 🔌 API Documentation

### Authentication Endpoints POST /api/auth/register

Deskripsi : Registrasi user baru

Request Body :
{
"username": "john_doe",
"email": "john@example.com",
"password": "password123",
"full_name": "John Doe",
"phone": "081234567890"
}

Response:
{
"status": "success",
"message": "User registered successfully",
"data": {
"user": {
"id": 1,
"username": "john_doe",
"email": "john@example.com",
"full_name": "John Doe"
},
"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
}

POST /api/auth/login
Deskripsi : Login user

Request Body :
{
"email": "john@example.com",
"password": "password123"
}

### Company Endpoints GET /api/companies

Deskripsi : Mendapatkan daftar perusahaan

Query Parameters :

-   page : Nomor halaman (default: 1)
-   per_page : Jumlah data per halaman (default: 15)
-   city : Filter berdasarkan kota
-   province : Filter berdasarkan provinsi
-   membership_type : Filter berdasarkan tipe membership
    {
    "status": "success",
    "data": {
    "companies": [
    {
    "id": 1,
    "company_name": "Elegant Wedding Organizer",
    "city": "Jakarta",
    "province": "DKI Jakarta",
    "membership_type": "premium",
    "logo_url": "https://example.com/logo.jpg",
    "rating": 4.8
    }
    ],
    "pagination": {
    "current_page": 1,
    "total_pages": 10,
    "total_items": 150
    }
    }
    }

POST /api/companies
Deskripsi : Mendaftarkan perusahaan baru

Request Body :
{
"company_name": "Dream Wedding Organizer",
"business_license": "123456789",
"owner_name": "Jane Smith",
"email": "info@dreamwedding.com",
"phone": "021-12345678",
"address": "Jl. Sudirman No. 123",
"city": "Jakarta",
"province": "DKI Jakarta",
"postal_code": "12345",
"website": "https://dreamwedding.com",
"description": "Wedding organizer profesional dengan pengalaman 10 tahun"
}

### Portfolio Endpoints GET /api/portfolios

Deskripsi : Mendapatkan daftar portfolio
POST /api/portfolios
Deskripsi : Menambah portfolio baru

### Event Endpoints GET /api/events

Deskripsi : Mendapatkan daftar event
POST /api/events
Deskripsi : Menambah event baru

## 🚀 Installation Guide

### System Requirements

-   PHP : >= 8.1
-   Composer : >= 2.0
-   MySQL : >= 8.0 atau MariaDB >= 10.3
-   Node.js : >= 16.0
-   NPM : >= 8.0

### Step-by-Step Installation 1. Clone Repository

# Install PHP dependencies

composer install

# Install Node.js dependencies

npm install

# Install PHP dependencies

composer install

# Install Node.js dependencies

npm install

# Copy environment file

cp .env.example .env

# Generate application key

php artisan key:generate

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hastana_indonesia
DB_USERNAME=root
DB_PASSWORD=your_password

# Create database

mysql -u root -p -e "CREATE DATABASE hastana_indonesia;"

# Run migrations

php artisan migrate

# Seed initial data

php artisan db:seed

# Create storage link

php artisan storage:link

# Set permissions

chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Development

npm run dev

# Production

npm run build

php artisan serve

Aplikasi akan berjalan di http://localhost:8000

### Production Deployment 1. Server Configuration

# Apache Virtual Host

<VirtualHost \*:80>
ServerName hastana-indonesia.com
DocumentRoot /var/www/hastana-indonesia/public

    <Directory /var/www/hastana-indonesia/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/hastana_error.log
    CustomLog ${APACHE_LOG_DIR}/hastana_access.log combined

</VirtualHost>

2. Environment Production
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://hastana-indonesia.com

# Database Production

DB_CONNECTION=mysql
DB_HOST=your_production_host
DB_DATABASE=hastana_production
DB_USERNAME=your_production_user
DB_PASSWORD=your_secure_password

# Mail Configuration

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password

3. Optimization Commands

# Cache configuration

php artisan config:cache

# Cache routes

php artisan route:cache

# Cache views

php artisan view:cache

# Optimize autoloader

composer install --optimize-autoloader --no-dev

## 👥 User Manual

### Untuk Admin Organisasi 1. Dashboard Admin

-   Statistik Keanggotaan : Jumlah perusahaan aktif, pending, suspended
-   Grafik Pertumbuhan : Trend pertambahan anggota per bulan
-   Aktivitas Terbaru : Log aktivitas sistem
-   Notifikasi : Pendaftaran baru, pembayaran iuran 2. Manajemen Perusahaan
-   Verifikasi Pendaftaran : Approve/reject pendaftaran perusahaan baru
-   Update Status : Mengubah status membership (active/suspended)
-   Upgrade Membership : Mengubah tipe membership
-   View Details : Melihat detail lengkap perusahaan 3. Manajemen Member
-   Daftar Member : Semua member dari seluruh perusahaan
-   Sertifikasi : Mengelola sertifikat member
-   Tracking Iuran : Monitor pembayaran iuran 4. Program Pelatihan
-   Buat Program : Membuat program pelatihan baru
-   Manajemen Peserta : Daftar peserta dan status
-   Sertifikat : Generate sertifikat completion

### Untuk Perusahaan Wedding Organizer 1. Dashboard Perusahaan

-   Profile Overview : Informasi perusahaan
-   Portfolio Stats : Jumlah portfolio, views, likes
-   Event Calendar : Jadwal event mendatang
-   Member Team : Daftar anggota tim 2. Manajemen Portfolio
-   Upload Portfolio : Tambah karya baru dengan foto/video
-   Edit Portfolio : Update informasi portfolio
-   Kategorisasi : Organize berdasarkan jenis acara
-   Featured : Set portfolio unggulan 3. Manajemen Event
-   Add Event : Input event baru
-   Event Timeline : Tracking progress event
-   Client Management : Informasi klien
-   Budget Tracking : Monitor anggaran 4. Team Management
-   Invite Member : Undang anggota tim baru
-   Role Assignment : Set role dan permission
-   Performance : Track kinerja tim

### Untuk Member/Karyawan 1. Personal Dashboard

-   Profile : Informasi personal
-   Certifications : Sertifikat yang dimiliki
-   Training History : Riwayat pelatihan
-   Tasks : Tugas dari perusahaan 2. Training & Certification
-   Available Training : Program pelatihan tersedia
-   Registration : Daftar pelatihan
-   Progress Tracking : Monitor progress
-   Certificate Download : Download sertifikat

## 👨‍💻 Developer Guide

### Project Structure

hastana_indonesia/
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ │ │ ├── API/
│ │ │ │ ├── AuthController.php
│ │ │ │ ├── CompanyController.php
│ │ │ │ ├── EventController.php
│ │ │ │ ├── MemberController.php
│ │ │ │ ├── PortfolioController.php
│ │ │ │ └── TrainingController.php
│ │ │ ├── Admin/
│ │ │ │ ├── DashboardController.php
│ │ │ │ ├── CompanyController.php
│ │ │ │ └── MemberController.php
│ │ │ └── Web/
│ │ │ ├── HomeController.php
│ │ │ ├── CompanyController.php
│ │ │ └── PortfolioController.php
│ │ ├── Middleware/
│ │ │ ├── AdminMiddleware.php
│ │ │ ├── CompanyMiddleware.php
│ │ │ └── MemberMiddleware.php
│ │ └── Requests/
│ │ ├── CompanyRequest.php
│ │ ├── EventRequest.php
│ │ └── PortfolioRequest.php
│ ├── Models/
│ │ ├── User.php
│ │ ├── Company.php
│ │ ├── Member.php
│ │ ├── Event.php
│ │ ├── Portfolio.php
│ │ ├── Certification.php
│ │ ├── TrainingProgram.php
│ │ └── Region.php
│ └── Services/
│ ├── CompanyService.php
│ ├── PortfolioService.php
│ ├── EventService.php
│ └── NotificationService.php
├── database/
│ ├── migrations/
│ ├── seeders/
│ └── factories/
├── resources/
│ ├── views/
│ ├── js/
│ └── css/
└── routes/
├── web.php
├── api.php
└── admin.php

Coding Standards

1. PSR Standards

-   PSR-1 : Basic Coding Standard
-   PSR-2 : Coding Style Guide
-   PSR-4 : Autoloader Standard
-   PSR-12 : Extended Coding Style 2. Naming Conventions

2. Naming Conventions
   // Classes: PascalCase
   class CompanyController {}

// Methods: camelCase
public function getCompanyList() {}

// Variables: camelCase
$companyData = [];

// Constants: UPPER_SNAKE_CASE
const MAX_UPLOAD_SIZE = 1024;

// Database tables: snake_case
'companies', 'member_certifications'

// Database columns: snake_case
'company_name', 'created_at'

3. Documentation
   /\*\*

-   Get list of companies with filtering and pagination
-
-   @param Request $request
-   @return JsonResponse
-
-   @throws ValidationException
    \*/
    public function index(Request $request): JsonResponse
    {
    // Implementation
    }

Testing

1.  Unit Testing
    // tests/Unit/CompanyTest.php
    class CompanyTest extends TestCase
    {
    public function test_company_can_be_created()
    {
    $company = Company::factory()->create();

            $this->assertDatabaseHas('companies', [
                'id' => $company->id,
                'company_name' => $company->company_name
            ]);
        }

    }

2.  Feature Tests
    // tests/Feature/CompanyAPITest.php
    class CompanyAPITest extends TestCase
    {
    public function test_can_get_company_list()
    {
    $response = $this->getJson('/api/companies');

            $response->assertStatus(200)
                     ->assertJsonStructure([
                         'status',
                         'data' => [
                             'companies' => [],
                             'pagination'
                         ]
                     ]);
        }

    }

3.  Running Tests

# Run all tests

php artisan test

# Run specific test

php artisan test --filter CompanyTest

# Run with coverage

php artisan test --coverage

Deployment

# .github/workflows/deploy.yml

name: Deploy to Production

on:
push:
branches: [ main ]

jobs:
deploy:
runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v2

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'

    - name: Install dependencies
      run: composer install --no-dev --optimize-autoloader

    - name: Run tests
      run: php artisan test

    - name: Deploy to server
      run: |
        rsync -avz --delete . user@server:/var/www/hastana-indonesia/
        ssh user@server 'cd /var/www/hastana-indonesia && php artisan migrate --force'

2. Database Backup

# Daily backup script

#!/bin/bash
DATE=$(date +"%Y%m%d_%H%M%S")
mysqldump -u username -p hastana_production > backup_$DATE.sql
aws s3 cp backup\_$DATE.sql s3://hastana-backups/

### Security 1. Authentication

-   Laravel Sanctum : API token authentication
-   Password Hashing : bcrypt dengan cost 12
-   Rate Limiting : 60 requests per minute 2. Authorization
    // app/Policies/CompanyPolicy.php
    class CompanyPolicy
    {
    public function update(User $user, Company $company)
    {
    return $user->member->company_id === $company->id;
    }
    }

3. Input Validation
   // app/Http/Requests/CompanyRequest.php
   class CompanyRequest extends FormRequest
   {
   public function rules()
   {
   return [
   'company_name' => 'required|string|max:255',
   'email' => 'required|email|unique:companies,email',
   'business_license' => 'required|string|unique:companies,business_license'
   ];
   }
   }

## 📞 Support & Contact

### Technical Support

-   Email : tech-support@hastana-indonesia.org
-   Phone : +62-21-1234-5678
-   WhatsApp : +62-812-3456-7890

### Documentation

-   API Docs : https://docs.hastana-indonesia.org/api
-   User Guide : https://docs.hastana-indonesia.org/user
-   Developer Guide : https://docs.hastana-indonesia.org/dev

### Community

-   Telegram Group : @hastana_developers
-   Discord : https://discord.gg/hastana
-   GitHub : https://github.com/hastana-indonesia

## 📄 License

Copyright © 2024 HASTANA Indonesia. All rights reserved.

Sistem ini dikembangkan khusus untuk HASTANA (Himpunan Perusahaan Penata Acara Indonesia) dan tidak diperkenankan untuk didistribusikan atau digunakan tanpa izin tertulis dari organisasi.

Versi Dokumentasi : 1.0.0 Terakhir Diperbarui : Januari 2024 Penulis : Tim Developer HASTANA Indonesia
