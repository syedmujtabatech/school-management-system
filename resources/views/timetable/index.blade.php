@extends('layouts.app')

@section('title', 'Weekly Timetable')

@section('content')
<div class="space-y-6">
  <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-bold text-slate-800">Class Timetable & Schedule Matrix</h2>
      <p class="text-xs text-slate-500">Weekly schedule grid with period timing</p>
    </div>
    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg border border-indigo-200">
      Selected: Class 10 (Science Section)
    </span>
  </div>

  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-indigo-950 text-white font-semibold uppercase">
          <tr>
            <th class="py-3 px-4">Period & Time</th>
            <th class="py-3 px-4">Monday</th>
            <th class="py-3 px-4">Tuesday</th>
            <th class="py-3 px-4">Wednesday</th>
            <th class="py-3 px-4">Thursday</th>
            <th class="py-3 px-4">Friday</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach ($timetable as $slot)
            <tr class="{{ $slot['period'] === 'Break' ? 'bg-amber-50 font-bold text-amber-900' : 'hover:bg-slate-50' }}">
              <td class="py-3 px-4 font-mono font-bold text-slate-700">
                {{ $slot['period'] === 'Break' ? 'RECESS' : "Period {$slot['period']}" }}<br>
                <span class="text-[10px] text-slate-400 font-normal">{{ $slot['time'] }}</span>
              </td>
              <td class="py-3 px-4 text-slate-800">{{ $slot['monday'] }}</td>
              <td class="py-3 px-4 text-slate-800">{{ $slot['tuesday'] }}</td>
              <td class="py-3 px-4 text-slate-800">{{ $slot['wednesday'] }}</td>
              <td class="py-3 px-4 text-slate-800">{{ $slot['thursday'] }}</td>
              <td class="py-3 px-4 text-slate-800">{{ $slot['friday'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
