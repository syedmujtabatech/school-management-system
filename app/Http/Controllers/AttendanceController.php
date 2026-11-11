<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\AttendanceRecord;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('class') && $request->class !== 'All') {
            $query->where('class_name', $request->class);
        }

        $students = $query->orderBy('class_name')->orderBy('roll_no')->get();
        return view('attendance.index', compact('students'));
    }

    public function punchApi(Request $request)
    {
        $input = trim($request->input('code'));
        if (!$input) {
            return response()->json(['success' => false, 'message' => 'Please swipe a valid RFID card or type Admission ID.']);
        }

        $student = Student::where('rfid_tag', $input)
            ->orWhere('admission_no', $input)
            ->orWhere('student_code', $input)
            ->first();

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Card / Tag not recognized in Student Database!']);
        }

        $record = AttendanceRecord::create([
            'student_id' => $student->id,
            'date' => now()->toDateString(),
            'punch_time' => now()->toTimeString(),
            'status' => 'Present',
            'method' => 'RFID',
        ]);

        ActivityLog::create([
            'type' => 'attendance',
            'message' => "Biometric RFID punch logged: {$student->name} ({$student->class_name}) at " . now()->format('h:i A')
        ]);

        return response()->json([
            'success' => true,
            'student' => $student,
            'time' => now()->format('h:i:s A'),
            'message' => "Attendance Verified for {$student->name}!"
        ]);
    }
}
