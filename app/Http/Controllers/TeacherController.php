<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderBy('name')->get();
        return view('teachers.index', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'qualification' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'salary' => 'required|numeric',
        ]);

        $count = Teacher::count() + 1;
        $validated['teacher_id'] = 'T-' . str_pad($count, 2, '0', STR_PAD_LEFT);
        $validated['status'] = 'Active';
        $validated['join_date'] = now();
        $validated['avatar'] = 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80';

        $teacher = Teacher::create($validated);

        ActivityLog::create([
            'type' => 'teacher',
            'message' => "New faculty joined: {$teacher->name} ({$teacher->subject})"
        ]);

        return redirect()->route('teachers.index')->with('success', "Faculty member {$teacher->name} added!");
    }
}
