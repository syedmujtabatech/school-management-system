@extends('layouts.app')

@section('title', 'Examinations & Marksheets')

@section('content')
<div class="space-y-6">
  <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-bold text-slate-800">Examinations & Marksheet Center</h2>
      <p class="text-xs text-slate-500">Calculate GPAs, record marks, and generate official terminal progress reports</p>
    </div>
    @if ($students->count() > 0)
      <a href="{{ route('reports.marksheet', $students->first()->id) }}" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
        <i data-lucide="printer" class="w-4 h-4"></i> Preview Sample Marksheet
      </a>
    @endif
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach ($students as $s)
      @php
        $marks = $s->marks ?? [];
        $subs = array_keys($marks);
        $avg = count($subs) > 0 ? round(array_sum($marks) / count($subs)) : 0;
      @endphp
      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">{{ $s->admission_no }}</span>
            <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $avg >= 80 ? 'bg-emerald-100 text-emerald-800' : ($avg < 50 ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800') }}">
              Avg: {{ $avg }}%
            </span>
          </div>
          <h4 class="font-bold text-slate-900 text-sm">{{ $s->name }}</h4>
          <p class="text-xs text-slate-500 mb-4">{{ $s->class_name }} ({{ $s->section }}) • Roll #{{ $s->roll_no }}</p>

          <div class="space-y-1.5 text-xs">
            @foreach (array_slice($subs, 0, 4) as $sub)
              <div class="flex justify-between py-1 border-b border-slate-100">
                <span class="text-slate-600">{{ $sub }}</span>
                <span class="font-bold font-mono {{ ($marks[$sub] ?? 0) >= 80 ? 'text-emerald-600' : (($marks[$sub] ?? 0) < 50 ? 'text-rose-600' : 'text-slate-800') }}">
                  {{ $marks[$sub] ?? 0 }}/100
                </span>
              </div>
            @endforeach
          </div>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
          <span class="text-[11px] text-slate-400">Term 1 Results</span>
          <a href="{{ route('reports.marksheet', $s->id) }}" target="_blank" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold border border-indigo-200 transition flex items-center gap-1">
            <i data-lucide="download" class="w-3.5 h-3.5"></i> Marksheet (PDF)
          </a>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
