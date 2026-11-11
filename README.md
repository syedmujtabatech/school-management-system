# 🎓 Crescent Model Higher Secondary School - Laravel School ERP (v12.0)

[![Laravel CI](https://github.com/syedmujtabatech/school-management-system/actions/workflows/ci.yml/badge.svg)](https://github.com/syedmujtabatech/school-management-system/actions)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php)](https://php.net)

A full-fledged, research-driven **Laravel 12 School Management System & ERP** designed for **Crescent Model Higher Secondary School** featuring:
- 🤖 **AI Student Success & Early Dropout Warning Engine**
- ⏱ **Smart Biometric/RFID Attendance Simulator**
- 📥 **Dedicated Admin Document & Report Download Hub**
- 🧾 **Official 3-Ply Bank Fee Challans (School, Bank & Student copies)**
- 🪪 **CR80 Dual-Sided ID Badges with Barcodes & Dynamic QR Codes**
- 📊 **Academic Terminal Marksheets with GPA & Criteria Legends**
- 📑 **Direct Master Excel (.csv) & Database (.json) Exports**

---

## 🌐 Live Cloud Deployment Guide (Live Kaise Karein)

Aap is project ko **Render.com**, **Railway.app**, ya **kisi bhi Linux/Docker VPS** par 2 minute mein bilkul muft (free) live host kar sakte hain:

### Option 1: 1-Click Free Hosting on Render.com (Recommended)
1. [Render.com](https://render.com) par free account banayein ya GitHub se login karein.
2. Dashboard par ja kar **"New +"** -> **"Web Service"** select karein.
3. Apna repository **`syedmujtabatech/school-management-system`** connect karein.
4. Render automatically `Dockerfile` aur `render.yaml` ko detect kar lega.
5. **"Deploy Web Service"** dabayein — 2 minute mein aap ka School ERP internet par live URL (`https://crescent-school-erp.onrender.com`) ke sath active ho jayega!

---

### Option 2: 1-Click Free Hosting on Railway.app
1. [Railway.app](https://railway.app) par jayen aur GitHub account se sign in karein.
2. **"New Project"** -> **"Deploy from GitHub repo"** choose karein.
3. **`school-management-system`** select karein.
4. Railway automatically `Procfile` aur dependencies detect karke instant live URL generate kar dega.

---

### Option 3: Docker Deployment on VPS (DigitalOcean / AWS / Hetzner)
Aap ke pass agar koi VPS ya Docker machine hai, to bas yeh command chalayein:
```bash
git clone https://github.com/syedmujtabatech/school-management-system.git
cd school-management-system
docker compose up -d --build
```
Aap ka portal `http://YOUR_SERVER_IP:8000` par live ho jayega.

---

### Option 4: Linux / Ubuntu VPS Direct Script
```bash
git clone https://github.com/syedmujtabatech/school-management-system.git
cd school-management-system
chmod +x deploy.sh
./deploy.sh
```

---

## 💻 Local Machine Par Run Karne Ka Tareeqa

### Windows / macOS / Linux:
```bash
git clone https://github.com/syedmujtabatech/school-management-system.git
cd school-management-system

# Install dependencies
composer install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database migration & realistic school data seeding
touch database/database.sqlite
php artisan migrate --force --seed

# Start development server
php artisan serve --port=8000
```
Browser mein open karein:
👉 **`http://localhost:8000`**

---

## 🌟 Researched Features (2026/2027 Innovations)

1. **📥 Dedicated Admin Download Hub (`/downloads`)**:
   - **3-Ply Bank Fee Challans**: School, Bank & Student copies complete with barcode, bank accounts, and signature fields.
   - **Student ID Cards (Batch & Individual)**: CR80 dual-sided badges with student photos, barcodes, QR verification, and emergency contacts.
   - **Terminal Progress Reports (Marksheets)**: Full marks calculation, overall GPA, letter grades (A+, A, B, C, D, F), attendance summary, and principal seal.
   - **Master Excel/CSV Exports**: 1-click downloads for Student Master Directory, Fee Defaulters list, and Monthly Attendance Registers.
   - **Database JSON Snapshot Backup**: Full offline database backup.

2. **🤖 AI Student Success & Early Dropout Warning Engine (`/ai-insights`)**:
   - Multi-factor risk analysis tracking attendance (<75%), test averages (<50%), and financial compliance flags.
   - Automatically categories students into **Critical Risk**, **Needs Attention**, and **Safe & Excelling**.
   - Generates personalized teacher interventions and 1-click **Guardian Warning Notices**.

3. **⏱ Smart RFID & Biometric Card Scanner Simulator (`/attendance`)**:
   - Interactive modal simulating RFID/barcode card swipes.
   - Tapping demo tags (`RFID-994821`, `RFID-994822`, `ADM-2026-103`) instantly verifies enrollment, logs attendance, and logs activity.

4. **💳 Fee Accounts & Defaulters WhatsApp Dispatcher (`/fees`)**:
   - Live revenue tracking: Total Expected, Bank Realized, and Overdue sums.
   - 1-Click "Mark as Paid" transaction confirmation.
   - 1-Click pre-formatted bilingual WhatsApp payment reminder generator.

---

## 📁 Project Architecture

- **Models**: `app/Models/` (`Student`, `Teacher`, `SchoolClass`, `AttendanceRecord`, `Notice`, `ActivityLog`)
- **Services**: `app/Services/AIStudentSuccessService.php` (AI early warning analytics)
- **Controllers**: `app/Http/Controllers/`
  - `DashboardController.php` (Overview & Chart.js metrics)
  - `StudentController.php` (Enrollment & directory)
  - `TeacherController.php` (Faculty management)
  - `FeeController.php` (Collections & ledger)
  - `AttendanceController.php` (RFID swipe simulator)
  - `AcademicController.php` (Terminal grades)
  - `AIInsightsController.php` (Diagnostic analytics)
  - `ReportDownloadController.php` (3-Ply Challan, ID Card, Marksheets, CSV & JSON exports)
- **Blade Views**: `resources/views/`
  - `layouts/app.blade.php` (Responsive layout, sidebar, topbar, RFID modal)
  - `dashboard.blade.php`, `students/index.blade.php`, `fees/index.blade.php`, `attendance/index.blade.php`
  - `downloads/index.blade.php` (Admin Document Download Center)
  - `reports/challan.blade.php`, `reports/id_card.blade.php`, `reports/marksheet.blade.php`

---

*Crescent Model Higher Secondary School ERP • Developed with Excellence by Syed Mujtaba.*
