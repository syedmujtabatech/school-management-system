<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bulk_ID_Cards_{{ $className }}_{{ date('Y-m-d') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fff; color: #1e293b; }
    .barcode { font-family: 'Libre Barcode 39 Text', cursive; }
    @media print {
      .no-print { display: none !important; }
      .page-break { page-break-after: always; }
      body { background: #fff !important; }
    }
  </style>
</head>
<body class="p-6">
  <div class="no-print mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between max-w-4xl mx-auto">
    <div>
      <h4 class="font-bold text-indigo-900">Bulk ID Badge Batch ({{ $className }} - {{ $students->count() }} students)</h4>
      <p class="text-xs text-indigo-700">Click Print to batch output all cards.</p>
    </div>
    <button onclick="window.print()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition flex items-center gap-2 text-xs">
      🖨️ Batch Print Badges
    </button>
  </div>

  @foreach ($students as $student)
    <div class="flex flex-wrap gap-8 justify-center mb-10 page-break">
      <!-- FRONT -->
      <div class="w-[340px] h-[500px] bg-indigo-900 rounded-2xl shadow-md p-5 text-white flex flex-col justify-between border border-indigo-800">
        <div class="text-center">
          <h4 class="font-bold text-xs uppercase tracking-wider text-emerald-300">Crescent Model School</h4>
          <span class="text-[9px] text-indigo-200">Student Identity Card</span>
        </div>
        <div class="flex flex-col items-center">
          <img src="{{ $student->avatar }}" alt="{{ $student->name }}" class="w-24 h-24 rounded-xl object-cover border-2 border-amber-300 shadow">
          <h3 class="font-bold text-base mt-2 text-center">{{ $student->name }}</h3>
          <span class="text-xs text-indigo-200">{{ $student->class_name }} ({{ $student->section }})</span>
        </div>
        <div class="bg-indigo-950/60 p-2.5 rounded-xl text-xs space-y-1">
          <div class="flex justify-between"><span>Roll No:</span><b class="text-white">{{ $student->roll_no }}</b></div>
          <div class="flex justify-between"><span>Adm No:</span><b class="font-mono text-white">{{ $student->admission_no }}</b></div>
          <div class="flex justify-between"><span>Blood:</span><b class="text-rose-300">{{ $student->blood_group ?? 'O+' }}</b></div>
        </div>
        <div class="barcode text-2xl text-amber-300 text-center leading-none tracking-widest">*{{ $student->admission_no }}*</div>
      </div>

      <!-- BACK -->
      <div class="w-[340px] h-[500px] bg-white rounded-2xl shadow-md p-5 text-slate-800 flex flex-col justify-between border border-slate-300">
        <div class="text-center border-b pb-2">
          <span class="font-bold text-xs text-indigo-900 uppercase">Emergency Info</span>
        </div>
        <div class="space-y-2 text-xs">
          <div><span class="text-slate-400 block text-[10px]">Guardian:</span><b>{{ $student->father_name }}</b></div>
          <div><span class="text-slate-400 block text-[10px]">Helpline:</span><b>{{ $student->phone }}</b></div>
          <div><span class="text-slate-400 block text-[10px]">Address:</span><span class="text-[11px] leading-snug">{{ $student->address }}</span></div>
        </div>
        <div class="pt-4 border-t flex items-center justify-between">
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data={{ $student->admission_no }}" alt="QR" class="w-14 h-14 border rounded">
          <div class="text-right">
            <div class="text-xs font-serif italic font-bold">Dr. Farhan Q.</div>
            <div class="w-20 border-b border-slate-400 my-1 ml-auto"></div>
            <span class="text-[9px] text-slate-400 uppercase">Principal</span>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</body>
</html>
