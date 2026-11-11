<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Notice;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportDownloadController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::all();
        $defaultersCount = Student::where('fee_status', '!=', 'Paid')->count();
        return view('downloads.index', compact('classes', 'defaultersCount'));
    }

    /**
     * 1. 3-Ply Bank Fee Challan (School, Bank & Student Copy)
     */
    public function feeChallan(Student $student)
    {
        return view('reports.challan', compact('student'));
    }

    /**
     * Bulk Fee Challans for all pending / overdue students
     */
    public function bulkFeeChallans()
    {
        $students = Student::where('fee_status', '!=', 'Paid')->get();
        return view('reports.bulk_challans', compact('students'));
    }

    /**
     * 2. CR80 Standard Dual-Sided Student ID Badge
     */
    public function idCard(Student $student)
    {
        return view('reports.id_card', compact('student'));
    }

    /**
     * Bulk ID Cards for an entire class
     */
    public function bulkIdCards(Request $request)
    {
        $className = $request->input('class', 'Class 10');
        $students = Student::where('class_name', $className)->get();
        return view('reports.bulk_id_cards', compact('students', 'className'));
    }

    /**
     * 3. Academic Terminal Marksheet / Progress Report Card
     */
    public function marksheet(Student $student)
    {
        return view('reports.marksheet', compact('student'));
    }

    /**
     * 4. Export Master Student Directory to CSV / Excel
     */
    public function exportStudentsCsv(): StreamedResponse
    {
        $fileName = 'Crescent_Student_Directory_' . date('Y-m-d') . '.csv';
        $students = Student::orderBy('class_name')->orderBy('roll_no')->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Sr #', 'Admission No', 'Student Name', 'Father Name', 'Class', 'Section', 'Roll No', 'Gender', 'Phone', 'Guardian Email', 'Fee Status', 'Fee Amount (PKR)', 'Attendance Rate', 'RFID Tag'];

        $callback = function() use ($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $index => $s) {
                fputcsv($file, [
                    $index + 1,
                    $s->admission_no,
                    $s->name,
                    $s->father_name,
                    $s->class_name,
                    $s->section,
                    $s->roll_no,
                    $s->gender,
                    $s->phone,
                    $s->guardian_email,
                    $s->fee_status,
                    $s->fee_amount,
                    $s->attendance_rate . '%',
                    $s->rfid_tag ?? 'N/A'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 5. Export Fee Defaulters & Arrears to CSV / Excel
     */
    public function exportDefaultersCsv(): StreamedResponse
    {
        $fileName = 'Crescent_Fee_Defaulters_' . date('Y-m-d') . '.csv';
        $defaulters = Student::where('fee_status', '!=', 'Paid')->orderBy('class_name')->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Sr #', 'Admission No', 'Student Name', 'Father Name', 'Class', 'Roll No', 'Parent Phone', 'Fee Status', 'Pending Amount (PKR)', 'Due Date', 'Action Status'];

        $callback = function() use ($defaulters, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($defaulters as $index => $d) {
                fputcsv($file, [
                    $index + 1,
                    $d->admission_no,
                    $d->name,
                    $d->father_name,
                    $d->class_name,
                    $d->roll_no,
                    $d->phone,
                    $d->fee_status,
                    $d->fee_amount,
                    $d->fee_due_date ? $d->fee_due_date->format('Y-m-d') : 'Immediate',
                    $d->fee_status === 'Overdue' ? 'Urgent Call Needed' : 'Normal Notice'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 6. Export Attendance Register to CSV / Excel
     */
    public function exportAttendanceCsv(Request $request): StreamedResponse
    {
        $class = $request->input('class', 'Class 10');
        $fileName = 'Crescent_Attendance_' . str_replace(' ', '_', $class) . '_' . date('Y-m-d') . '.csv';
        $students = Student::where('class_name', $class)->orderBy('roll_no')->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Roll No', 'Admission No', 'Student Name', 'Father Name', 'Attendance Rate', 'Status Classification'];

        $callback = function() use ($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $s) {
                fputcsv($file, [
                    $s->roll_no,
                    $s->admission_no,
                    $s->name,
                    $s->father_name,
                    $s->attendance_rate . '%',
                    $s->attendance_rate >= 80 ? 'Regular' : 'Irregular / At-Risk'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 7. Full Database JSON Backup
     */
    public function backupDatabaseJson()
    {
        $backup = [
            'exported_at' => now()->toIso8601String(),
            'school' => 'Crescent Model Higher Secondary School',
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'classes' => SchoolClass::all(),
            'notices' => Notice::all(),
        ];

        $fileName = 'Crescent_School_DB_Backup_' . date('Y-m-d') . '.json';
        return response()->streamDownload(function() use ($backup) {
            echo json_encode($backup, JSON_PRETTY_PRINT);
        }, $fileName, ['Content-Type' => 'application/json']);
    }
}
