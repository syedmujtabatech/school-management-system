# 🎓 Apex International Academy - School Management System (ERP v2.6)

An advanced, modern, research-backed **School Management System & ERP** equipped with 2026/2027 EdTech innovations: **AI Student Success Early-Warning Engine**, **Live Biometric / RFID Attendance Simulator**, **Official 3-Ply Bank Fee Challan Generator**, **Dual-Sided Student ID Cards**, **Terminal Examination Marksheets**, and a dedicated **Admin Document Download Hub**.

---

## 🌟 Key Researched & Innovative Features (2026 / 2027)

1. **🤖 AI Student Success & Early Dropout Warning System**:
   - Analyzes real-time multi-factor indicators: attendance rates (<75%), test averages (<50%), and financial distress indicators.
   - Generates composite risk scores (Critical, Needs Attention, Safe) up to 3 weeks prior to terminal exams.
   - Generates personalized remedial plans and 1-click Guardian Warning Notices.

2. **📥 Admin Document Download & Export Center ("Admin Download Kar Sakay")**:
   - **Official 3-Ply Bank Fee Vouchers**: Triple-copy layout (School Copy, Bank Copy, Student Copy) with bank accounts, barcodes, fee breakdowns, and cashier signatures (Printable / PDF).
   - **Smart Dual-Sided ID Badges**: CR80 standard badges with student photo, roll number, emergency contact, barcode, and dynamic QR verification code.
   - **Academic Terminal Marksheets**: Official progress reports with GPA, percentage, grading criteria legend, and principal stamp.
   - **Excel (.xlsx) Master Exports**: 1-click exports for Student Directory, Fee Defaulters list, and Monthly Attendance Registers via SheetJS.
   - **Full Database JSON Backup & Restore**: Download full system snapshots and restore anytime.

3. **⏱ Live Biometric / RFID Attendance Simulator**:
   - Quick punch simulator bar supporting RFID card taps or barcode scans.
   - Real-time morning entry tracking with audible feedback and automatic activity logging.

4. **💳 Smart Fee Accounts & Defaulters Tracker**:
   - Track monthly expected revenue vs bank collected vs overdue fees.
   - 1-Click WhatsApp reminder dispatcher with pre-formatted bilingual alert templates.
   - 1-Click "Mark as Paid" with confetti confirmation.

5. **👥 Multi-Role Portal Switcher**:
   - Switch between **Admin / Principal**, **Teacher Faculty**, and **Student/Parent** views on the fly from the top header!

6. **💾 Offline Persistence & Auto-Sync**:
   - Built on robust `localStorage` state management—no database installation required.
   - Pre-populated with realistic students, teachers, classes, fee ledger, and notices.

---

## 🚀 How to Run the Application

You have two very easy ways to run the application:

### Method 1: Using Node.js (Recommended)
Open your terminal in the project directory and run:
```bash
npm start
```
Or:
```bash
node server.js
```
Then open your browser at:
👉 **`http://localhost:3000`**

### Method 2: Standalone Double-Click (Zero Setup!)
Simply double-click the **`index.html`** file in File Explorer to open it directly in Google Chrome, Microsoft Edge, or any modern web browser!

---

## 📁 Project Directory Structure

```
school-management-system/
├── index.html            # Main single-page application dashboard & modals
├── server.js             # Zero-dependency local Node.js HTTP web server
├── package.json          # Project metadata and start script
├── README.md             # Complete documentation & usage guide
├── css/
│   └── styles.css        # Custom styles, print media optimizations, animations
└── js/
    ├── data.js           # Core data store, 20+ realistic records & LocalStorage
    ├── ai_insights.js    # AI Student Success & At-Risk diagnostic engine
    ├── reports.js        # High-fidelity 3-Ply Challan, ID Card, & Excel export engine
    └── app.js            # Main application router, UI interactions & Chart.js
```

---

## 📖 Urdu / Hindi Quick Guide (ہدایات)

- **ایڈمن ڈاؤن لوڈ سینٹر (Admin Download Hub)**:
  سائیڈبار میں **Admin Download Hub** پر کلک کریں۔ یہاں سے ایڈمن تمام ضروری دستاویزات ایک کلک پر ڈاؤن لوڈ کر سکتا ہے:
  - 3-Ply فیس چالان (School, Bank & Student Copy)
  - اسٹوڈنٹ اسکول کارڈز (Student ID Badges with Barcode & QR)
  - امتحانی رزلٹ کارڈز (Terminal Marksheet with GPA)
  - ایکسل شیٹ ڈاؤن لوڈ (Student List & Fee Defaulters in `.xlsx`)
  - مکمل ڈیٹا بیس کا بیک اپ (`.json`)

- **فیس کا انتظام (Fee Management)**:
  - "Fee Accounts" ٹیب میں جا کر آپ کسی بھی طالب علم کی فیس وصول کر سکتے ہیں اور ڈائریکٹ واٹس ایپ پر ریمائنڈر بھیج سکتے ہیں۔
  
- **بایومیٹرک / آر ایف آئی ڈی پنچ (RFID Scanner)**:
  - اوپر موجود "RFID Scan" بٹن دبائیں اور کارڈ سوائپ کریں، سسٹم فوراً حاضری لگا دے گا۔

- **اے آئی سٹوڈنٹ اینالیٹکس (AI Insights)**:
  - کم نمبروں اور کم حاضری والے طلباء کو سسٹم خودکار طور پر فلیگ کرتا ہے تاکہ بروقت والدین کو مطلع کیا جا سکے۔

---

*Developed with Excellence by Apex EdTech Systems.*
