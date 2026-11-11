@extends('layouts.app')

@section('title', 'AI Student Success & Early Warning')

@section('content')
<div class="space-y-6">
  <div class="bg-gradient-to-r from-purple-900 via-indigo-900 to-slate-900 p-6 md:p-8 rounded-3xl text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div class="space-y-2">
      <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold text-purple-300 border border-white/10">
        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-300"></i> AI Dropout Prevention & Remedial Engine
      </div>
      <h2 class="text-2xl font-black">AI Student Diagnostic & Early Warning</h2>
      <p class="text-purple-200 text-xs max-w-xl">
        Predictive heuristic scanning student attendance (<75%), continuous assessment scores (<50%), and financial strain to alert teachers 3 weeks prior to terminal exams.
      </p>
    </div>
    <div class="flex items-center gap-3">
      <span class="px-3.5 py-2 bg-white/15 rounded-xl text-xs font-bold backdrop-blur-md border border-white/20">
        Engine: Laravel 12 Active Model
      </span>
    </div>
  </div>

  <!-- AI Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    <div class="bg-white p-5 rounded-2xl border border-rose-200 shadow-sm bg-rose-50/20">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase text-rose-600">Critical At-Risk</span>
        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
      </div>
      <div class="text-3xl font-black text-rose-700 mt-3">{{ $diagnostics['criticalCount'] }} Students</div>
      <p class="text-xs text-rose-600 mt-1">Requires emergency parent meeting</p>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm bg-amber-50/20">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase text-amber-600">Needs Attention</span>
        <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500"></i>
      </div>
      <div class="text-3xl font-black text-amber-700 mt-3">{{ $diagnostics['attentionCount'] }} Students</div>
      <p class="text-xs text-amber-600 mt-1">Requires remedial coaching & mentor check-in</p>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm bg-emerald-50/20">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase text-emerald-600">Safe & Excelling</span>
        <i data-lucide="star" class="w-4 h-4 text-emerald-500"></i>
      </div>
      <div class="text-3xl font-black text-emerald-700 mt-3">{{ $diagnostics['safeCount'] }} Students</div>
      <p class="text-xs text-emerald-600 mt-1">Nominated for academic honors</p>
    </div>
  </div>

  <!-- Detailed AI Diagnoses List -->
  <div class="space-y-4">
    <h3 class="font-bold text-slate-800 text-base">Comprehensive Student Diagnostic Records</h3>

    @foreach ($diagnostics['analyses'] as $a)
      <div class="bg-white rounded-2xl border {{ $a['riskScore'] >= 60 ? 'border-rose-300 ring-2 ring-rose-100' : ($a['riskScore'] >= 35 ? 'border-amber-200' : 'border-slate-200') }} p-5 shadow-sm transition">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $a['riskScore'] >= 60 ? 'bg-rose-100 text-rose-700' : ($a['riskScore'] >= 35 ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }} flex items-center justify-center font-bold text-sm">
              {{ $a['riskScore'] }}%
            </div>
            <div>
              <h4 class="font-bold text-slate-900 text-sm">{{ $a['student']->name }} <span class="text-xs font-normal text-slate-500">({{ $a['student']->class_name }} • Roll #{{ $a['student']->roll_no }})</span></h4>
              <p class="text-xs text-slate-400 font-mono">Admission ID: {{ $a['student']->admission_no }}</p>
            </div>
          </div>

          <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $a['badgeClass'] }}">
              {{ $a['status'] }}
            </span>
            <button onclick="navigator.clipboard.writeText(`{{ addslashes($a['parentAlertDraft']) }}`); alert('Guardian message copied to clipboard!')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition flex items-center gap-1.5">
              <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy Guardian Alert
            </button>
          </div>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
          <div>
            <h5 class="font-bold text-slate-700 mb-2 flex items-center gap-1.5">
              <i data-lucide="brain-circuit" class="w-3.5 h-3.5 text-indigo-600"></i> AI Actionable Interventions:
            </h5>
            <ul class="space-y-1.5 text-slate-600">
              @foreach ($a['recommendations'] as $rec)
                <li>{{ $rec }}</li>
              @endforeach
            </ul>
          </div>

          <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-1 text-slate-600">
            <div class="flex justify-between"><span class="text-slate-400">Current Academic Avg:</span><b class="text-slate-900">{{ $a['avgMarks'] }}%</b></div>
            <div class="flex justify-between"><span class="text-slate-400">Attendance Index:</span><b class="{{ $a['attendanceRate'] >= 80 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $a['attendanceRate'] }}%</b></div>
            <div class="flex justify-between"><span class="text-slate-400">Fee Compliance:</span><b class="{{ $a['student']->fee_status === 'Paid' ? 'text-emerald-600' : 'text-rose-600' }}">{{ $a['student']->fee_status }}</b></div>
            @if (!empty($a['weakSubjects']))
              <div class="pt-1 text-rose-600 font-semibold">Flagged Subjects: {{ implode(', ', $a['weakSubjects']) }}</div>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
