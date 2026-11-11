<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\AIInsightsController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ReportDownloadController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Students
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

// Teachers
Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');

// Fees
Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
Route::post('/fees/{student}/pay', [FeeController::class, 'markPaid'])->name('fees.pay');

// Attendance & RFID Punch Simulator
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/punch-api', [AttendanceController::class, 'punchApi'])->name('attendance.punch');

// Academics & Results
Route::get('/academics', [AcademicController::class, 'index'])->name('academics.index');

// AI Early Warning & Student Success
Route::get('/ai-insights', [AIInsightsController::class, 'index'])->name('ai.index');

// Timetable & Notices
Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');
Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::post('/notices', [NoticeController::class, 'store'])->name('notices.store');

// Admin Document & Download Hub
Route::get('/downloads', [ReportDownloadController::class, 'index'])->name('downloads.index');

// Printable & Downloadable Documents
Route::get('/reports/challan/{student}', [ReportDownloadController::class, 'feeChallan'])->name('reports.challan');
Route::get('/reports/challans/bulk', [ReportDownloadController::class, 'bulkFeeChallans'])->name('reports.challans.bulk');
Route::get('/reports/id-card/{student}', [ReportDownloadController::class, 'idCard'])->name('reports.id_card');
Route::get('/reports/id-cards/bulk', [ReportDownloadController::class, 'bulkIdCards'])->name('reports.id_cards.bulk');
Route::get('/reports/marksheet/{student}', [ReportDownloadController::class, 'marksheet'])->name('reports.marksheet');

// Excel / CSV / JSON Direct Exports
Route::get('/reports/export/students-csv', [ReportDownloadController::class, 'exportStudentsCsv'])->name('reports.export.students');
Route::get('/reports/export/defaulters-csv', [ReportDownloadController::class, 'exportDefaultersCsv'])->name('reports.export.defaulters');
Route::get('/reports/export/attendance-csv', [ReportDownloadController::class, 'exportAttendanceCsv'])->name('reports.export.attendance');
Route::get('/reports/export/backup-json', [ReportDownloadController::class, 'backupDatabaseJson'])->name('reports.export.backup');
