<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bulk_Fee_Challans_Batch_{{ date('Y-m-d') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fff; color: #1e293b; }
    .barcode { font-family: 'Libre Barcode 39 Text', cursive; font-size: 26px; }
    @media print {
      .no-print { display: none !important; }
      .page-break { page-break-after: always; }
      body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
  </style>
</head>
<body class="p-6">
  <div class="no-print mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between max-w-6xl mx-auto">
    <div>
      <h4 class="font-bold text-indigo-900">Bulk Fee Challan Batch Ready ({{ $students->count() }} vouchers)</h4>
      <p class="text-xs text-indigo-700">Click Print to batch print or export all challans to PDF.</p>
    </div>
    <button onclick="window.print()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition flex items-center gap-2 text-xs">
      🖨️ Batch Print / Save PDF
    </button>
  </div>

  @foreach ($students as $student)
    <div class="max-w-6xl mx-auto mb-10 page-break">
      <div class="text-center mb-4">
        <h2 class="text-xl font-black text-indigo-950">Crescent Model Higher Secondary School</h2>
        <p class="text-xs text-slate-500">Meezan Bank Ltd • A/C # 0102-0104928472910 • Islamabad</p>
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
          <div class="border-2 border-dashed border-slate-300 p-4 rounded-xl flex flex-col justify-between text-xs bg-white">
            <div class="text-center pb-2 border-b border-slate-200">
              <div class="font-bold text-indigo-900 text-xs uppercase">{{ $copyTitle }}</div>
            </div>

            <div class="my-2 space-y-1 bg-slate-50 p-2 rounded-lg border border-slate-100 text-[10px]">
              <div class="flex justify-between"><span>Challan:</span> <b class="font-mono">{{ $challanNo }}</b></div>
              <div class="flex justify-between"><span>Due Date:</span> <b class="text-rose-600">{{ $dueDate }}</b></div>
            </div>

            <div class="mb-2 border-b border-slate-200 pb-1.5 text-[11px]">
              <div class="font-bold text-slate-900">{{ $student->name }}</div>
              <div class="text-slate-600">S/D/O: {{ $student->father_name }}</div>
              <div class="flex justify-between text-slate-500 mt-0.5">
                <span>{{ $student->class_name }}</span>
                <span>Roll: #{{ $student->roll_no }}</span>
              </div>
            </div>

            <table class="w-full text-left text-[11px] mb-2">
              <tbody>
                <tr><td>Tuition</td><td class="text-right font-mono">{{ number_format($baseTuition) }}</td></tr>
                <tr><td>Lab/IT Fund</td><td class="text-right font-mono">{{ number_format($labFee) }}</td></tr>
                <tr><td>Exam Fund</td><td class="text-right font-mono">{{ number_format($examFund) }}</td></tr>
                @if ($lateFine > 0)
                  <tr class="text-rose-600"><td>Late Surcharge</td><td class="text-right font-mono">{{ number_format($lateFine) }}</td></tr>
                @endif
                <tr class="border-t border-slate-900 font-bold bg-indigo-50/50">
                  <td class="py-1">Total</td>
                  <td class="py-1 text-right text-indigo-700 font-bold font-mono">PKR {{ number_format($totalPayable) }}</td>
                </tr>
              </tbody>
            </table>

            <div class="barcode text-slate-400 text-center tracking-widest leading-none my-1">
              *{{ $challanNo }}*
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-between text-[9px] text-slate-400">
              <span>Bank Officer</span>
              <span>Accounts Officer</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
</body>
</html>
