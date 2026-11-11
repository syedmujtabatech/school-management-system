@extends('layouts.app')

@section('title', 'Attendance & RFID')

@section('content')
<div class="space-y-6">
  <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-bold text-slate-800">Smart Attendance & Biometric Portal</h2>
      <p class="text-xs text-slate-500">Live RFID card swipe simulation and daily roll call register</p>
    </div>
    <div class="flex items-center gap-3">
      <button onclick="openBiometricModal()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
        <i data-lucide="scan" class="w-4 h-4"></i> RFID Card Swipe Simulator
      </button>
      <a href="{{ route('reports.export.attendance', ['class' => 'Class 10']) }}" class="px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl border border-indigo-200 transition flex items-center gap-1.5">
        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Download Sheet (.csv)
      </a>
    </div>
  </div>

  <!-- Roll Call Matrix -->
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-slate-200 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="font-bold text-slate-800 text-sm">Today's Roll Call:</span>
        <span class="text-xs font-mono bg-slate-100 px-2.5 py-1 rounded-md text-slate-700">{{ now()->format('l, d F Y') }}</span>
      </div>
      <span class="text-xs text-emerald-600 font-bold">Auto-Syncing with RFID Gateway</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
          <tr>
            <th class="py-3 px-4">Roll</th>
            <th class="py-3 px-4">Student</th>
            <th class="py-3 px-4">Class</th>
            <th class="py-3 px-4">RFID Tag #</th>
            <th class="py-3 px-4">Attendance Rate</th>
            <th class="py-3 px-4 text-center">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach ($students as $s)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="py-3 px-4 font-mono font-bold text-slate-900">{{ $s->roll_no }}</td>
              <td class="py-3 px-4">
                <div class="font-bold text-slate-900">{{ $s->name }}</div>
                <div class="text-[11px] text-slate-400 font-mono">{{ $s->admission_no }}</div>
              </td>
              <td class="py-3 px-4 text-slate-700">{{ $s->class_name }} ({{ $s->section }})</td>
              <td class="py-3 px-4 font-mono text-[11px] text-indigo-600 font-semibold">{{ $s->rfid_tag ?? 'RFID-DEFAULT' }}</td>
              <td class="py-3 px-4">
                <div class="flex items-center gap-2">
                  <div class="w-24 bg-slate-200 rounded-full h-2 overflow-hidden">
                    <div class="h-full {{ $s->attendance_rate >= 80 ? 'bg-emerald-500' : 'bg-rose-500' }}" style="width: {{ $s->attendance_rate }}%"></div>
                  </div>
                  <span class="font-bold text-slate-700">{{ $s->attendance_rate }}%</span>
                </div>
              </td>
              <td class="py-3 px-4 text-center">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $s->attendance_rate >= 80 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                  {{ $s->attendance_rate >= 80 ? 'Present' : 'Irregular' }}
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
