@extends('layouts.app')

@section('title', 'Fee Accounts')

@section('content')
<div class="space-y-6">
  <!-- Financial Summary Header -->
  <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-bold text-slate-800">Fee Accounts & Challan Management</h2>
      <p class="text-xs text-slate-500">Track tuition payments, issue 3-ply bank vouchers, and dispatch WhatsApp alerts</p>
    </div>
    <div class="flex flex-wrap items-center gap-3">
      <a href="{{ route('reports.challans.bulk') }}" target="_blank" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-xl border border-rose-200 transition flex items-center gap-1.5">
        <i data-lucide="printer" class="w-4 h-4"></i> Print All Overdue Challans
      </a>
      <a href="{{ route('reports.export.defaulters') }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
        <i data-lucide="download" class="w-4 h-4"></i> Export Defaulters (.csv)
      </a>
    </div>
  </div>

  <!-- Metric Stat Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
      <span class="text-xs font-bold uppercase text-slate-500">Expected Total (Monthly)</span>
      <div class="text-2xl font-black text-slate-900 mt-2">PKR {{ number_format($totalExpected) }}</div>
      <p class="text-xs text-slate-400 mt-1">{{ $students->count() }} enrolled student accounts</p>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm bg-emerald-50/20">
      <span class="text-xs font-bold uppercase text-emerald-700">Collected in Bank</span>
      <div class="text-2xl font-black text-emerald-700 mt-2">PKR {{ number_format($totalCollected) }}</div>
      <p class="text-xs text-emerald-600 mt-1">{{ $totalExpected > 0 ? round(($totalCollected / $totalExpected) * 100) : 0 }}% realization rate</p>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-rose-200 shadow-sm bg-rose-50/20">
      <span class="text-xs font-bold uppercase text-rose-700">Overdue / Defaulter Sum</span>
      <div class="text-2xl font-black text-rose-700 mt-2">PKR {{ number_format($totalOverdue) }}</div>
      <p class="text-xs text-rose-600 mt-1">Requires follow-up calls</p>
    </div>
  </div>

  <!-- Fee Ledger Table -->
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-slate-200 flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-sm">Tuition Payment Ledger</h3>
      <span class="text-xs text-slate-500">Term 1 (November 2026)</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
          <tr>
            <th class="py-3 px-4">Student</th>
            <th class="py-3 px-4">Class</th>
            <th class="py-3 px-4">Monthly Fee</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4">Due Date</th>
            <th class="py-3 px-4 text-center">Actions & Downloads</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach ($students as $s)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="py-3 px-4">
                <div class="font-bold text-slate-900">{{ $s->name }}</div>
                <div class="text-[11px] text-slate-400 font-mono">{{ $s->admission_no }} • {{ $s->phone }}</div>
              </td>
              <td class="py-3 px-4 font-medium text-slate-700">{{ $s->class_name }} ({{ $s->section }})</td>
              <td class="py-3 px-4 font-mono font-bold text-slate-900">PKR {{ number_format($s->fee_amount) }}</td>
              <td class="py-3 px-4">
                <span class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase {{ $s->fee_status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : ($s->fee_status === 'Pending' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                  {{ $s->fee_status }}
                </span>
              </td>
              <td class="py-3 px-4 text-slate-500 font-mono">{{ $s->fee_due_date ? $s->fee_due_date->format('d/m/Y') : '15/11/2026' }}</td>
              <td class="py-3 px-4 text-center">
                <div class="flex items-center justify-center gap-2">
                  <!-- Mark as Paid -->
                  @if ($s->fee_status !== 'Paid')
                    <form action="{{ route('fees.pay', $s->id) }}" method="POST" onsubmit="return confirm('Confirm payment receipt for {{ $s->name }}?')" class="inline">
                      @csrf
                      <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow transition">
                        ✓ Mark Paid
                      </button>
                    </form>
                  @else
                    <span class="text-xs text-emerald-600 font-semibold flex items-center gap-1">
                      <i data-lucide="check" class="w-3.5 h-3.5"></i> Paid
                    </span>
                  @endif

                  <!-- Print 3-Ply Voucher -->
                  <a href="{{ route('reports.challan', $s->id) }}" target="_blank" class="px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-semibold border border-indigo-200 transition flex items-center gap-1">
                    <i data-lucide="receipt" class="w-3.5 h-3.5"></i> 3-Ply Challan
                  </a>

                  <!-- WhatsApp Reminder -->
                  @if ($s->fee_status !== 'Paid')
                    @php
                      $cleanPhone = preg_replace('/[^0-9]/', '', $s->phone);
                      $msg = urlencode("CRESCENT MODEL SCHOOL FEE NOTICE\nDear Parent of {$s->name} (Class: {$s->class_name}),\nTuition fee of PKR " . number_format($s->fee_amount) . " is pending.\nKindly deposit via Meezan Bank A/C 0102-0104928472910 by due date.\nAccounts Dept.");
                    @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $msg }}" target="_blank" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold border border-emerald-200 transition flex items-center gap-1" title="Dispatch WhatsApp Alert">
                      <i data-lucide="message-square" class="w-3.5 h-3.5"></i> WhatsApp
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
