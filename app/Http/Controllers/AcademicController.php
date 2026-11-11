<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('class_name')->orderBy('roll_no')->get();
        return view('academics.index', compact('students'));
    }
}
