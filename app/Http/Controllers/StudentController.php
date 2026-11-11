<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('class') && $request->class !== 'All') {
            $query->where('class_name', $request->class);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%")
                  ->orWhere('father_name', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('class_name')->orderBy('roll_no')->get();
        $classes = SchoolClass::all();

        return view('students.index', compact('students', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'class_name' => 'required|string',
            'section' => 'nullable|string',
            'roll_no' => 'required|integer',
            'gender' => 'required|string',
            'phone' => 'required|string',
            'guardian_email' => 'nullable|email',
            'fee_amount' => 'required|numeric',
            'address' => 'nullable|string',
            'blood_group' => 'nullable|string',
        ]);

        $count = Student::count() + 1;
        $validated['student_code'] = 'STU-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        $validated['admission_no'] = 'ADM-2026-' . (100 + $count);
        $validated['fee_status'] = 'Pending';
        $validated['fee_due_date'] = now()->addDays(15);
        $validated['attendance_rate'] = 95;
        $validated['rfid_tag'] = 'RFID-' . rand(100000, 999999);
        $validated['avatar'] = $validated['gender'] === 'Female' 
            ? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80'
            : 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150&q=80';
        $validated['marks'] = [
            'Mathematics' => 85,
            'Physics' => 80,
            'Chemistry' => 78,
            'English' => 84,
            'Computer Science' => 90
        ];

        $student = Student::create($validated);

        ActivityLog::create([
            'type' => 'student',
            'message' => "New student enrolled: {$student->name} in {$student->class_name}"
        ]);

        return redirect()->route('students.index')->with('success', "Student {$student->name} enrolled successfully!");
    }

    public function destroy(Student $student)
    {
        $name = $student->name;
        $student->delete();

        ActivityLog::create([
            'type' => 'student',
            'message' => "Student record removed: {$name}"
        ]);

        return redirect()->route('students.index')->with('success', "Student {$name} removed.");
    }
}
