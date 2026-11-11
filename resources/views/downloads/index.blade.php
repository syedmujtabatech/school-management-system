@extends('layouts.app')

@section('title', 'Admin Document Download Hub')

@section('content')
<div class="space-y-6">
  <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 rounded-3xl p-6 md:p-8 text-white shadow-xl">
    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold text-amber-300 border border-white/10 mb-2">
      <i data-lucide="download-cloud" class="w-4 h-4"></i> Official Export & Download Center
    </div>
    <h2 class="text-2xl font-black">Admin Document & Report Download Hub</h2>
    <p class="text-indigo-200 text-xs max-w-2xl mt-1">
      Generate, export, and download all school administrative records in 1-click. Formatted for standard A4 and badge printing, or full Excel (.csv) spreadsheets.
    </p>
  </div>

  <!-- Download Cards Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    <!-- 3-Ply Bank Fee Vouchers -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
          <i data-lucide="receipt" class="w-6 h-6"></i>
        </div>
        <h3 class="font-bold text-slate-900 text-base">3-Ply Bank Fee Challans</h3>
        <p class="text-xs text-slate-500 mt-1">Official triple-copy vouchers (School Copy, Bank Copy, Student Copy) complete with barcodes & account details.</p>
      </div>
      <div class="mt-6 space-y-2">
        <a href="{{ route('reports.challans.bulk') }}" target="_blank" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
          <i data-lucide="printer" class="w-4 h-4"></i> Print All Pending Challans (PDF)
        </a>
      </div>
    </div>

    <!-- Official Student ID Badges -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
          <i data-lucide="badge-check" class="w-6 h-6"></i>
        </div>
        <h3 class="font-bold text-slate-900 text-base">Student ID Cards (Batch)</h3>
        <p class="text-xs text-slate-500 mt-1">Dual-sided CR80 printable identity passes featuring student photos, emergency phone, barcodes, and principal signature.</p>
      </div>
      <div class="mt-6 space-y-2">
        <a href="{{ route('reports.id_cards.bulk', ['class' => 'Class 10']) }}" target="_blank" class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
          <i data-lucide="printer" class="w-4 h-4"></i> Download Class 10 Badges (PDF)
        </a>
      </div>
    </div>

    <!-- Complete Student Directory (CSV) -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
          <i data-lucide="file-spreadsheet" class="w-6 h-6"></i>
        </div>
        <h3 class="font-bold text-slate-900 text-base">Student Master Directory</h3>
        <p class="text-xs text-slate-500 mt-1">Full database export with admission numbers, parents' contact details, addresses, blood groups, and fee statuses.</p>
      </div>
      <div class="mt-6 space-y-2">
        <a href="{{ route('reports.export.students') }}" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
          <i data-lucide="download" class="w-4 h-4"></i> Download Excel (.csv)
        </a>
      </div>
    </div>

    <!-- Fee Defaulters & Arrears Sheet -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
          <i data-lucide="alert-circle" class="w-6 h-6"></i>
        </div>
        <h3 class="font-bold text-slate-900 text-base">Fee Defaulters Ledger</h3>
        <p class="text-xs text-slate-500 mt-1">Filtered spreadsheet of all overdue tuition amounts, student roll numbers, and parent contact information.</p>
      </div>
      <div class="mt-6 space-y-2">
        <a href="{{ route('reports.export.defaulters') }}" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
          <i data-lucide="download" class="w-4 h-4"></i> Download Defaulters ({{ $defaultersCount }}) (.csv)
        </a>
      </div>
    </div>

    <!-- Monthly Attendance Register -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
          <i data-lucide="calendar" class="w-6 h-6"></i>
        </div>
        <h3 class="font-bold text-slate-900 text-base">Attendance Register Sheet</h3>
        <p class="text-xs text-slate-500 mt-1">Class-wise monthly attendance percentage matrix, absentee rates, and biometric log verification.</p>
      </div>
      <div class="mt-6 space-y-2">
        <a href="{{ route('reports.export.attendance', ['class' => 'Class 10']) }}" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
          <i data-lucide="download" class="w-4 h-4"></i> Download Attendance (.csv)
        </a>
      </div>
    </div>

    <!-- Database JSON Backup -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
      <div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
          <i data-lucide="database" class="w-6 h-6"></i>
        </div>
        <h3 class="font-bold text-slate-900 text-base">System Database Backup</h3>
        <p class="text-xs text-slate-500 mt-1">Export full Laravel SQLite database snapshot to JSON format for offline safe-keeping.</p>
      </div>
      <div class="mt-6 space-y-2">
        <a href="{{ route('reports.export.backup') }}" class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
          <i data-lucide="download" class="w-4 h-4"></i> Backup Database (.json)
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
