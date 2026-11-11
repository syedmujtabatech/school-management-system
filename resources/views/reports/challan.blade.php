<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fee_Challan_{{ $student->admission_no }}_{{ str_replace(' ', '_', $student->name) }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fff; color: #1e293b; }
    .barcode { font-family: 'Libre Barcode 39 Text', cursive; font-size: 26px; }
    @media print {
      .no-print { display: none !important; }
      body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
  </style>
</head>
<body class="p-6">
  <div class="no-print mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between max-w-6xl mx-auto">
    <div>
      <h4 class="font-bold text-indigo-900">Official 3-Ply Bank Challan Ready</h4>
      <p class="text-xs text-indigo-700">Click Print to save as PDF or print on standard A4 paper.</p>
    </div>
    <button onclick="window.print()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition flex items-center gap-2 text-xs">
      🖨️ Print / Save as PDF
    </button>
  </div>

  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-6">
      <h2 class="text-2xl font-black text-indigo-950">Crescent Model Higher Secondary School</h2>
      <p class="text-xs text-slate-500">Sector F-10/4, Academic Avenue, Islamabad • Tel: +92 300 1234567</p>
      <div class="inline-block px-3 py-0.5 bg-indigo-50 border border-indigo-200 text-indigo-900 font-bold text-[11px] rounded-full mt-1">
        Monthly Tuition & Laboratory Fee Voucher
      </div>
    </div>

    @php
      $challanNo = "CH-2026-{$student->roll_no}{$student->id}";
      $issueDate = date('d/m/Y');
      $dueDate = $student->fee_due_date ? $student->fee_due_date->format('d/m/Y') : '15/11/2026';
      $baseTuition = $student->fee_amount - 1500;
      $labFee = 1000;
      $examFund = 500;
      $lateFine = $student->fee_status === 'Overdue' ? 500 : 0;
      $totalPayable = $student->fee_amount + $lateFine;
      $copies = ['1. School Copy', '2. Bank Copy', '3. Student / Parent Copy'];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      @foreach ($copies as $copyTitle)
        <div class="border-2 border-dashed border-slate-300 p-4 rounded-xl flex flex-col justify-between text-xs bg-white relative">
          <div class="text-center pb-3 border-b border-slate-200">
            <div class="font-bold text-indigo-900 text-sm tracking-wide">Crescent Model School</div>
            <div class="text-[10px] text-slate-500">Meezan Bank Ltd • A/C # 0102-0104928472910</div>
            <div class="mt-1 inline-block px-2 py-0.5 bg-indigo-100 text-indigo-800 font-bold rounded uppercase text-[10px]">
              {{ $copyTitle }}
            </div>
          </div>

          <div class="my-3 space-y-1 bg-slate-50 p-2.5 rounded-lg border border-slate-100 text-[11px]">
            <div class="flex justify-between"><span class="text-slate-500">Challan No:</span> <span class="font-mono font-bold text-slate-800">{{ $challanNo }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Issue Date:</span> <span class="font-medium">{{ $issueDate }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Due Date:</span> <span class="font-bold text-rose-600">{{ $dueDate }}</span></div>
          </div>

          <div class="mb-3 border-b border-slate-200 pb-2">
            <div class="font-bold text-slate-900 text-sm">{{ $student->name }}</div>
            <div class="text-slate-600">S/D/O: <b>{{ $student->father_name }}</b></div>
            <div class="flex justify-between text-slate-600 mt-0.5">
              <span>Class: <b>{{ $student->class_name }} ({{ $student->section }})</b></span>
              <span>Roll No: <b>{{ $student->roll_no }}</b></span>
            </div>
            <div class="text-slate-500 text-[11px]">Adm No: <b>{{ $student->admission_no }}</b></div>
          </div>

          <table class="w-full text-left mb-3">
            <thead>
              <tr class="border-b border-slate-300 text-slate-600 text-[11px]">
                <th class="py-1">Description</th>
                <th class="py-1 text-right">Amount (PKR)</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr><td class="py-1">Tuition Fee</td><td class="py-1 text-right font-mono">{{ number_format($baseTuition) }}</td></tr>
              <tr><td class="py-1">Science & IT Lab Fund</td><td class="py-1 text-right font-mono">{{ number_format($labFee) }}</td></tr>
              <tr><td class="py-1">Exam & Library Fund</td><td class="py-1 text-right font-mono">{{ number_format($examFund) }}</td></tr>
              @if ($lateFine > 0)
                <tr class="text-rose-600"><td class="py-1">Late Payment Surcharge</td><td class="py-1 text-right font-mono">{{ number_format($lateFine) }}</td></tr>
              @endif
              <tr class="border-t-2 border-slate-900 font-bold text-slate-900 bg-indigo-50/50">
                <td class="py-1.5 px-1 font-bold">Total Payable</td>
                <td class="py-1.5 px-1 text-right font-mono text-sm text-indigo-700 font-bold">PKR {{ number_format($totalPayable) }}</td>
              </tr>
            </tbody>
          </table>

          <div class="barcode text-slate-400 text-center tracking-widest my-1">
            *{{ $challanNo }}*
          </div>

          <div class="pt-6 border-t border-slate-200 flex justify-between items-end text-[10px] text-slate-500">
            <div class="text-center">
              <div class="w-20 border-b border-slate-400 mb-1"></div>
              <span>Bank Officer</span>
            </div>
            <div class="text-center">
              <div class="w-20 border-b border-slate-400 mb-1"></div>
              <span>Accounts Officer</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</body>
</html>
