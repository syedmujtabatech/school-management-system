<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('fee_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('fee_status')->orderBy('roll_no')->get();

        $totalExpected = Student::sum('fee_amount');
        $totalCollected = Student::where('fee_status', 'Paid')->sum('fee_amount');
        $totalOverdue = Student::where('fee_status', 'Overdue')->sum('fee_amount');

        return view('fees.index', compact('students', 'totalExpected', 'totalCollected', 'totalOverdue'));
    }

    public function markPaid(Request $request, Student $student)
    {
        $student->update([
            'fee_status' => 'Paid',
            'paid_date' => now(),
            'payment_method' => $request->input('payment_method', 'Bank Deposit / Online')
        ]);

        ActivityLog::create([
            'type' => 'fee',
            'message' => "Fee payment of PKR " . number_format($student->fee_amount) . " confirmed for {$student->name}"
        ]);

        return redirect()->back()->with('success', "Payment recorded for {$student->name}!");
    }
}
