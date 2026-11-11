<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Notice;
use App\Models\ActivityLog;
use App\Services\AIStudentSuccessService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(AIStudentSuccessService $aiService)
    {
        $students = Student::all();
        $teachers = Teacher::all();
        $notices = Notice::latest()->take(4)->get();
        $activities = ActivityLog::latest()->take(6)->get();

        $totalStudents = $students->count();
        $paidRevenue = $students->where('fee_status', 'Paid')->sum('fee_amount');
        $pendingRevenue = $students->where('fee_status', '!=', 'Paid')->sum('fee_amount');
        $avgAttendance = $totalStudents > 0 ? round($students->avg('attendance_rate')) : 0;

        $aiSummary = $aiService->getSchoolDiagnostics();

        return view('dashboard', compact(
            'totalStudents',
            'paidRevenue',
            'pendingRevenue',
            'avgAttendance',
            'teachers',
            'notices',
            'activities',
            'aiSummary'
        ));
    }
}
