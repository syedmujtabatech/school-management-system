# 🎓 Crescent Model Higher Secondary School - Laravel School ERP (v12.0)

A full-fledged, research-driven **Laravel 12 School Management System & ERP** for **Crescent Model Higher Secondary School** featuring **AI Student Success Early-Warning**, **Smart Biometric/RFID Attendance Simulator**, **Official 3-Ply Bank Fee Challans**, **CR80 Dual-Sided ID Badges**, **Terminal Progress Marksheets**, and an **Admin Document Download Hub** with real CSV & JSON exports.

---

## 🌟 Researched Features (2026/2027)

1. **📥 Dedicated Admin Download Hub**:
   - **3-Ply Bank Fee Challans**: School, Bank & Student copies complete with barcode, bank accounts, and signature fields.
   - **Student ID Cards (Batch & Individual)**: CR80 dual-sided badges with student photos, barcodes, QR verification, and emergency contacts.
   - **Terminal Progress Reports (Marksheets)**: Full marks calculation, overall GPA, letter grades (A+, A, B, C, D, F), attendance summary, and principal seal.
   - **Master Excel/CSV Exports**: 1-click downloads for Student Master Directory, Fee Defaulters list, and Monthly Attendance Registers.
   - **Database JSON Snapshot Backup**: Full offline database backup.

2. **🤖 AI Student Success & Early Dropout Warning Engine**:
   - Multi-factor risk analysis tracking attendance (<75%), test averages (<50%), and financial compliance flags.
   - Automatically categories students into **Critical Risk**, **Needs Attention**, and **Safe & Excelling**.
   - Generates personalized teacher interventions and 1-click **Guardian Warning Notices**.

3. **⏱ Smart RFID & Biometric Card Scanner Simulator**:
   - Interactive modal simulating RFID/barcode card swipes.
   - Tapping demo tags (`RFID-994821`, `RFID-994822`, `ADM-2026-103`) instantly verifies enrollment, logs attendance, and logs activity.

4. **💳 Fee Accounts & Defaulters WhatsApp Dispatcher**:
   - Live revenue tracking: Total Expected, Bank Realized, and Overdue sums.
   - 1-Click "Mark as Paid" transaction confirmation.
   - 1-Click pre-formatted bilingual WhatsApp payment reminder generator.

---

## 🚀 How to Run the Laravel Application

### 1. Start Laravel Server
In your terminal, navigate to this directory:
```bash
cd "C:\Users\Mujtaba Arshad\.gemini\antigravity\scratch\school-management-laravel"
php artisan serve --port=8000
```

Then open your browser at:
👉 **`http://localhost:8000`**

### 2. Database
The application is pre-configured with **SQLite** (`database/database.sqlite`) and pre-seeded with 12+ students, 8 faculty teachers, classes, notices, and activity logs. No MySQL setup is required!
To re-seed fresh demo data anytime:
```bash
php artisan migrate:fresh --seed
```

---

## 📁 Directory & Architectural Overview

- **Models**: `app/Models/` (`Student`, `Teacher`, `SchoolClass`, `AttendanceRecord`, `Notice`, `ActivityLog`)
- **Services**: `app/Services/AIStudentSuccessService.php` (AI early warning analytics)
- **Controllers**: `app/Http/Controllers/`
  - `DashboardController.php` (Overview & charts)
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
