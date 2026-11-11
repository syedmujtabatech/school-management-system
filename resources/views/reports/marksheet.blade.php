<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Progress_Report_{{ $student->admission_no }}_{{ str_replace(' ', '_', $student->name) }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; color: #1e293b; }
    @media print {
      .no-print { display: none !important; }
      body { background: #fff !important; }
    }
  </style>
</head>
<body class="p-6">
  <div class="no-print mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between max-w-4xl mx-auto">
    <div>
      <h4 class="font-bold text-indigo-900">Academic Progress Marksheet Ready</h4>
      <p class="text-xs text-indigo-700">Official terminal examination result card.</p>
    </div>
    <button onclick="window.print()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition flex items-center gap-2 text-xs">
      🖨️ Print / Save PDF
    </button>
  </div>

  @php
    $marks = $student->marks ?? [];
    $totalMax = count($marks) * 100;
    $totalObtained = array_sum($marks);
    $percentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100) : 0;
    
    $overallGrade = 'F';
    $gpa = '0.0';
    if ($percentage >= 90) { $overallGrade = 'A+'; $gpa = '4.0'; }
    elseif ($percentage >= 80) { $overallGrade = 'A'; $gpa = '3.7'; }
    elseif ($percentage >= 70) { $overallGrade = 'B'; $gpa = '3.0'; }
    elseif ($percentage >= 60) { $overallGrade = 'C'; $gpa = '2.3'; }
    elseif ($percentage >= 50) { $overallGrade = 'D'; $gpa = '1.7'; }
  @endphp

  <div class="max-w-4xl mx-auto bg-white p-8 border border-slate-300 rounded-2xl shadow-xl my-4">
    <!-- School Header -->
    <div class="text-center pb-6 border-b-2 border-indigo-900">
      <div class="flex items-center justify-center gap-3 mb-2">
        <div class="w-12 h-12 rounded-xl bg-indigo-900 text-emerald-400 flex items-center justify-center font-black text-2xl shadow">C</div>
        <div>
          <h1 class="text-2xl font-black text-indigo-950 uppercase tracking-tight">Crescent Model Higher Secondary School</h1>
          <p class="text-xs text-slate-500">Sector F-10/4, Academic Avenue, Islamabad | Tel: +92 300 1234567</p>
        </div>
      </div>
      <div class="inline-block px-4 py-1 bg-indigo-50 border border-indigo-200 text-indigo-900 font-bold text-xs uppercase rounded-full mt-2">
        Terminal Examination Progress & Performance Report Card
      </div>
    </div>

    <!-- Student Meta -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200 my-6 text-xs">
      <div><span class="text-slate-400 block font-semibold">Student Name:</span><b class="text-sm text-slate-900">{{ $student->name }}</b></div>
      <div><span class="text-slate-400 block font-semibold">Father's Name:</span><b class="text-slate-800">{{ $student->father_name }}</b></div>
      <div><span class="text-slate-400 block font-semibold">Class / Section:</span><b class="text-slate-800">{{ $student->class_name }} ({{ $student->section }})</b></div>
      <div><span class="text-slate-400 block font-semibold">Roll Number:</span><b class="text-slate-800">{{ $student->roll_no }}</b></div>
      <div><span class="text-slate-400 block font-semibold">Admission No:</span><b class="font-mono text-slate-800">{{ $student->admission_no }}</b></div>
      <div><span class="text-slate-400 block font-semibold">Attendance Rate:</span><b class="{{ $student->attendance_rate >= 80 ? 'text-emerald-700' : 'text-rose-600' }} font-bold">{{ $student->attendance_rate }}%</b></div>
      <div><span class="text-slate-400 block font-semibold">Academic Term:</span><b class="text-slate-800">Session 2026-2027 (Term 1)</b></div>
      <div><span class="text-slate-400 block font-semibold">Issue Date:</span><b class="text-slate-800">{{ date('d/m/Y') }}</b></div>
    </div>

    <!-- Marks Table -->
    <table class="w-full text-left border border-slate-200 rounded-lg overflow-hidden mb-6">
      <thead class="bg-indigo-950 text-white text-xs uppercase font-semibold">
        <tr>
          <th class="py-3 px-3">Subject</th>
          <th class="py-3 px-3 text-center">Max Marks</th>
          <th class="py-3 px-3 text-center">Marks Obtained</th>
          <th class="py-3 px-3 text-center">Grade</th>
          <th class="py-3 px-3">Faculty Remarks</th>
        </tr>
      </thead>
      <tbody class="text-xs">
        @foreach ($marks as $subject => $score)
          @php
            $grade = 'F';
            $remarks = 'Needs Urgent Tutoring';
            if ($score >= 90) { $grade = 'A+'; $remarks = 'Outstanding Excellence'; }
            elseif ($score >= 80) { $grade = 'A'; $remarks = 'Excellent Concept Mastery'; }
            elseif ($score >= 70) { $grade = 'B'; $remarks = 'Good Understanding'; }
            elseif ($score >= 60) { $grade = 'C'; $remarks = 'Satisfactory Progress'; }
            elseif ($score >= 50) { $grade = 'D'; $remarks = 'Passing Standard'; }
          @endphp
          <tr class="border-b border-slate-200">
            <td class="py-2.5 px-3 font-medium text-slate-800">{{ $subject }}</td>
            <td class="py-2.5 px-3 text-center text-slate-500">100</td>
            <td class="py-2.5 px-3 text-center font-bold text-slate-900">{{ $score }}</td>
            <td class="py-2.5 px-3 text-center font-bold {{ $score >= 80 ? 'text-emerald-600' : ($score < 50 ? 'text-rose-600' : 'text-indigo-600') }}">{{ $grade }}</td>
            <td class="py-2.5 px-3 text-slate-600 text-[11px]">{{ $remarks }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-slate-100 font-bold text-slate-900 text-xs">
        <tr>
          <td class="py-3 px-3">Cumulative Aggregate</td>
          <td class="py-3 px-3 text-center">{{ $totalMax }}</td>
          <td class="py-3 px-3 text-center text-indigo-700 text-sm">{{ $totalObtained }}</td>
          <td class="py-3 px-3 text-center text-indigo-700 text-sm">{{ $overallGrade }}</td>
          <td class="py-3 px-3 text-[11px]">Overall GPA: <b>{{ $gpa }}</b> | Aggregate: <b>{{ $percentage }}%</b></td>
        </tr>
      </tfoot>
    </table>

    <!-- Grading Legend & Signatures -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-slate-200">
      <div class="text-[11px] text-slate-500 bg-slate-50 p-3 rounded-lg border border-slate-200">
        <b class="text-slate-700 block mb-1">Standard Grading Criteria:</b>
        <span>90-100% = A+ (4.0) | 80-89% = A (3.7)<br>70-79% = B (3.0) | 60-69% = C (2.3)<br>50-59% = D (1.7) | Below 50% = F (Fail)</span>
      </div>
      <div class="text-center pt-8">
        <div class="w-36 border-b border-slate-400 mx-auto mb-1"></div>
        <span class="text-xs text-slate-500 font-semibold uppercase">Class Teacher Signature</span>
      </div>
      <div class="text-center pt-8">
        <div class="w-36 border-b border-slate-400 mx-auto mb-1"></div>
        <span class="text-xs text-slate-500 font-semibold uppercase">Principal Stamp & Signature</span>
      </div>
    </div>
  </div>
</body>
</html>
