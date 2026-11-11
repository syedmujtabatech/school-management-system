<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $timetable = [
            ['period' => 1, 'time' => '08:00 - 08:50', 'monday' => 'Mathematics (Ms. Fatima)', 'tuesday' => 'Physics (Dr. Tariq)', 'wednesday' => 'Chemistry (Sir Kamran)', 'thursday' => 'Mathematics (Ms. Fatima)', 'friday' => 'Computer Science (Sir Bilal)'],
            ['period' => 2, 'time' => '08:50 - 09:40', 'monday' => 'Physics (Dr. Tariq)', 'tuesday' => 'Mathematics (Ms. Fatima)', 'wednesday' => 'English (Ms. Ayesha)', 'thursday' => 'Chemistry (Sir Kamran)', 'friday' => 'Physics Lab (Dr. Tariq)'],
            ['period' => 3, 'time' => '09:40 - 10:30', 'monday' => 'Chemistry (Sir Kamran)', 'tuesday' => 'English (Ms. Ayesha)', 'wednesday' => 'Mathematics (Ms. Fatima)', 'thursday' => 'Computer Science (Sir Bilal)', 'friday' => 'Islamic Studies (Qari Usman)'],
            ['period' => 'Break', 'time' => '10:30 - 11:00', 'monday' => 'Recess / Snack', 'tuesday' => 'Recess / Snack', 'wednesday' => 'Recess / Snack', 'thursday' => 'Recess / Snack', 'friday' => 'Recess / Snack'],
            ['period' => 4, 'time' => '11:00 - 11:50', 'monday' => 'Computer Science (Sir Bilal)', 'tuesday' => 'Islamic Studies (Qari Usman)', 'wednesday' => 'Physics (Dr. Tariq)', 'thursday' => 'English (Ms. Ayesha)', 'friday' => 'Mathematics (Ms. Fatima)'],
            ['period' => 5, 'time' => '11:50 - 12:40', 'monday' => 'English (Ms. Ayesha)', 'tuesday' => 'Chemistry Lab (Sir Kamran)', 'wednesday' => 'Physical Edu (Mr. Zain)', 'thursday' => 'Physics (Dr. Tariq)', 'friday' => 'Library / Mentoring'],
        ];

        return view('timetable.index', compact('timetable'));
    }
}
