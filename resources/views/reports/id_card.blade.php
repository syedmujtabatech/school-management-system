<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student_Badge_{{ $student->admission_no }}_{{ str_replace(' ', '_', $student->name) }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; color: #1e293b; }
    .barcode { font-family: 'Libre Barcode 39 Text', cursive; }
    @media print {
      .no-print { display: none !important; }
      body { background: #fff !important; }
    }
  </style>
</head>
<body class="p-6 flex flex-col items-center">
  <div class="no-print mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between w-full max-w-xl">
    <div>
      <h4 class="font-bold text-indigo-900">Official CR80 Identity Badge Ready</h4>
      <p class="text-xs text-indigo-700">Click to print or save as PDF.</p>
    </div>
    <button onclick="window.print()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition flex items-center gap-2 text-xs">
      🖨️ Print Badge
    </button>
  </div>

  <div class="flex flex-wrap gap-8 justify-center">
    <!-- FRONT SIDE -->
    <div class="w-[340px] h-[520px] bg-gradient-to-br from-indigo-900 via-indigo-800 to-indigo-950 rounded-2xl shadow-2xl p-5 text-white flex flex-col justify-between relative overflow-hidden border border-indigo-700">
      <div class="absolute -right-16 -top-16 w-52 h-52 bg-white/5 rounded-full pointer-events-none blur-xl"></div>
      <div class="absolute -left-16 -bottom-16 w-52 h-52 bg-indigo-500/10 rounded-full pointer-events-none blur-xl"></div>

      <!-- Header -->
      <div class="text-center relative z-10">
        <div class="flex items-center justify-center gap-2 mb-1">
          <div class="w-8 h-8 rounded-lg bg-emerald-400 flex items-center justify-center text-slate-950 font-black shadow-md">C</div>
          <span class="font-extrabold text-sm tracking-wide text-white uppercase">Crescent Model School</span>
        </div>
        <p class="text-[10px] text-indigo-200 tracking-wider uppercase font-semibold">Student Identity Pass</p>
      </div>

      <!-- Student Photo -->
      <div class="flex flex-col items-center relative z-10 my-2">
        <div class="w-28 h-28 rounded-xl p-1 bg-gradient-to-tr from-amber-400 to-indigo-400 shadow-xl">
          <img src="{{ $student->avatar }}" alt="{{ $student->name }}" class="w-full h-full object-cover rounded-lg">
        </div>
        <h4 class="font-bold text-lg mt-3 text-white text-center leading-tight">{{ $student->name }}</h4>
        <span class="text-xs text-amber-300 font-semibold mt-0.5">{{ $student->class_name }} ({{ $student->section }})</span>
      </div>

      <!-- Details Grid -->
      <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 text-xs space-y-1.5 border border-white/10 relative z-10">
        <div class="flex justify-between"><span class="text-indigo-200">Roll No:</span><span class="font-bold text-white">{{ $student->roll_no }}</span></div>
        <div class="flex justify-between"><span class="text-indigo-200">Admission No:</span><span class="font-bold text-white font-mono">{{ $student->admission_no }}</span></div>
        <div class="flex justify-between"><span class="text-indigo-200">Blood Group:</span><span class="font-bold text-rose-300">{{ $student->blood_group ?? 'O+' }}</span></div>
        <div class="flex justify-between"><span class="text-indigo-200">Valid Upto:</span><span class="font-semibold text-white">Aug 2027</span></div>
      </div>

      <!-- Barcode Footer -->
      <div class="text-center relative z-10 pt-2 border-t border-indigo-700/60">
        <div class="barcode text-2xl text-amber-300 tracking-widest leading-none">*{{ $student->admission_no }}*</div>
        <p class="text-[9px] text-indigo-300 mt-1">Authorized Student Identity Document</p>
      </div>
    </div>

    <!-- BACK SIDE -->
    <div class="w-[340px] h-[520px] bg-white rounded-2xl shadow-2xl p-5 text-slate-800 flex flex-col justify-between border border-slate-200 relative">
      <div>
        <div class="border-b border-slate-200 pb-3 text-center">
          <h5 class="font-extrabold text-sm text-indigo-900 uppercase">Emergency & Instructions</h5>
          <p class="text-[10px] text-slate-500">Sector F-10/4, Academic Ave, Islamabad</p>
        </div>

        <div class="my-4 space-y-2 text-xs">
          <div>
            <span class="text-[11px] font-semibold text-slate-400 block">Father / Guardian:</span>
            <span class="font-medium text-slate-800">{{ $student->father_name }}</span>
          </div>
          <div>
            <span class="text-[11px] font-semibold text-slate-400 block">Emergency Helpline:</span>
            <span class="font-bold text-indigo-600">{{ $student->phone }}</span>
          </div>
          <div>
            <span class="text-[11px] font-semibold text-slate-400 block">Permanent Residence:</span>
            <span class="text-slate-700 text-[11px] leading-snug">{{ $student->address }}</span>
          </div>
        </div>

        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-[10px] text-slate-600 space-y-1">
          <p>• Cardholder must wear this badge during school hours and examinations.</p>
          <p>• Loss of badge must be reported immediately to Admin desk.</p>
          <p>• Non-transferable property of Crescent Model Higher Secondary School.</p>
        </div>
      </div>

      <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
        <div class="w-16 h-16 bg-slate-100 rounded-lg border border-slate-300 flex items-center justify-center p-1">
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ $student->admission_no }}-{{ urlencode($student->name) }}" alt="QR" class="w-full h-full">
        </div>
        <div class="text-right">
          <div class="text-indigo-900 font-serif italic font-bold text-sm">Dr. Farhan Q.</div>
          <div class="w-24 border-b border-slate-400 my-1 ml-auto"></div>
          <span class="text-[10px] font-semibold text-slate-500 uppercase">Principal Signature</span>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
