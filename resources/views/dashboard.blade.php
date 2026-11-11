@extends('layouts.app')

@section('title', 'Executive Dashboard')

@section('content')
<div class="space-y-6">
  <!-- Top Welcome Banner -->
  <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10 space-y-2">
      <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold text-amber-300 border border-white/10">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
        Laravel 12 Engine Active
      </div>
      <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Crescent Model School Management ERP</h1>
      <p class="text-indigo-200 text-xs md:text-sm max-w-xl">
        Complete school operations overview: Real-time student enrollment, fee collections, biometric RFID attendance, and AI academic risk predictions.
      </p>
    </div>

    <div class="relative z-10 flex flex-wrap gap-3">
      <button onclick="openBiometricModal()" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-lg transition flex items-center gap-2">
        <i data-lucide="scan" class="w-4 h-4"></i> RFID Card Punch
      </button>
      <a href="{{ route('downloads.index') }}" class="px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white backdrop-blur-md rounded-xl text-xs font-bold border border-white/20 transition flex items-center gap-2">
        <i data-lucide="download" class="w-4 h-4"></i> Admin Download Hub
      </a>
    </div>
  </div>

  <!-- Metric KPI Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <!-- Total Students -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Enrolled</span>
        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
          <i data-lucide="users" class="w-5 h-5"></i>
        </div>
      </div>
      <div class="mt-4 flex items-baseline gap-2">
        <span class="text-3xl font-extrabold text-slate-900">{{ $totalStudents }}</span>
        <span class="text-xs font-semibold text-emerald-600 flex items-center">+4 this month</span>
      </div>
      <div class="mt-2 text-xs text-slate-500">Across 6 academic classes</div>
    </div>

    <!-- Total Revenue Collected -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Fees Collected</span>
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
          <i data-lucide="credit-card" class="w-5 h-5"></i>
        </div>
      </div>
      <div class="mt-4 flex items-baseline gap-2">
        <span class="text-2xl font-extrabold text-slate-900">PKR {{ number_format($paidRevenue / 1000, 1) }}k</span>
        <span class="text-xs font-semibold text-slate-500">of {{ number_format(($paidRevenue + $pendingRevenue) / 1000, 1) }}k</span>
      </div>
      <div class="mt-2 flex items-center justify-between text-xs">
        <span class="text-rose-600 font-medium">PKR {{ number_format($pendingRevenue) }} Pending</span>
        <span class="text-emerald-600 font-bold">{{ $paidRevenue + $pendingRevenue > 0 ? round(($paidRevenue / ($paidRevenue + $pendingRevenue)) * 100) : 0 }}%</span>
      </div>
    </div>

    <!-- Average Attendance -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Daily Attendance</span>
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
          <i data-lucide="calendar-check" class="w-5 h-5"></i>
        </div>
      </div>
      <div class="mt-4 flex items-baseline gap-2">
        <span class="text-3xl font-extrabold text-slate-900">{{ $avgAttendance }}%</span>
        <span class="text-xs font-semibold text-emerald-600 flex items-center">Normal</span>
      </div>
      <div class="mt-2 text-xs text-slate-500">Active Biometric RFID tracking</div>
    </div>

    <!-- AI Early Warning / At Risk -->
    <div class="bg-white p-5 rounded-2xl border border-rose-200 shadow-sm hover:shadow-md transition bg-gradient-to-br from-white to-rose-50/30">
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider text-rose-600">AI At-Risk Alert</span>
        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
          <i data-lucide="alert-octagon" class="w-5 h-5"></i>
        </div>
      </div>
      <div class="mt-4 flex items-baseline gap-2">
        <span class="text-3xl font-extrabold text-rose-600">{{ $aiSummary['criticalCount'] }}</span>
        <span class="text-xs font-semibold text-rose-600">Students Need Help</span>
      </div>
      <div class="mt-2 text-xs text-rose-700 font-medium hover:underline">
        <a href="{{ route('ai.index') }}">View AI Diagnostic Plan →</a>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Fee Collection Analytics Chart -->
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h3 class="font-bold text-slate-800 text-base">Financial Overview (Term 1)</h3>
          <p class="text-xs text-slate-500">Collected vs Overdue tuition breakdown</p>
        </div>
        <a href="{{ route('reports.export.defaulters') }}" class="text-xs px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition flex items-center gap-1.5">
          <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5 text-emerald-600"></i> Export Defaulters (.csv)
        </a>
      </div>
      <div class="h-64">
        <canvas id="dashboardFinanceChart"></canvas>
      </div>
    </div>

    <!-- Grade Distribution Chart -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
      <div class="mb-4">
        <h3 class="font-bold text-slate-800 text-base">Academic Grade Spread</h3>
        <p class="text-xs text-slate-500">Terminal assessment result curve</p>
      </div>
      <div class="h-64 flex items-center justify-center">
        <canvas id="dashboardGradesChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Recent Activity & Quick Notices -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity Log -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
          <i data-lucide="activity" class="w-4 h-4 text-indigo-600"></i> Live Activity Audit
        </h3>
        <span class="text-xs text-slate-400">Database events</span>
      </div>
      <div class="space-y-3">
        @foreach ($activities as $act)
          <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
            <div class="w-8 h-8 rounded-lg {{ $act->type === 'fee' ? 'bg-emerald-100 text-emerald-700' : ($act->type === 'attendance' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700') }} flex items-center justify-center flex-shrink-0 text-xs font-bold">
              {{ $act->type === 'fee' ? '₨' : ($act->type === 'attendance' ? '⏱' : '★') }}
            </div>
            <div class="flex-1 text-xs">
              <p class="font-medium text-slate-800">{{ $act->message }}</p>
              <span class="text-[10px] text-slate-400">{{ $act->created_at->diffForHumans() }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Active Notices Broadcast -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
          <i data-lucide="bell" class="w-4 h-4 text-amber-500"></i> School Notice Board
        </h3>
        <a href="{{ route('notices.index') }}" class="text-xs text-indigo-600 hover:underline font-semibold">View All Notices →</a>
      </div>
      <div class="space-y-3">
        @foreach ($notices as $not)
          <div class="p-3.5 bg-slate-50 hover:bg-slate-100/80 rounded-xl border border-slate-200/60 transition">
            <div class="flex items-center justify-between gap-2 mb-1">
              <h4 class="font-bold text-xs text-slate-800">{{ $not->title }}</h4>
              <span class="text-[10px] px-2 py-0.5 rounded-full font-bold {{ $not->priority === 'urgent' ? 'bg-rose-100 text-rose-700' : 'bg-indigo-100 text-indigo-700' }} uppercase">{{ $not->priority }}</span>
            </div>
            <p class="text-xs text-slate-600 line-clamp-2">{{ $not->content }}</p>
            <div class="mt-2 text-[10px] text-slate-400 font-medium">Target: {{ $not->audience }} • Date: {{ $not->date ? $not->date->format('d M Y') : 'Today' }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Finance Chart
    const ctx1 = document.getElementById('dashboardFinanceChart');
    if (ctx1) {
      new Chart(ctx1, {
        type: 'bar',
        data: {
          labels: ['Class 6', 'Class 7', 'Class 8', 'Class 9', 'Class 10', 'Class 11'],
          datasets: [
            {
              label: 'Fees Collected (PKR)',
              data: [15000, 16000, 17000, 18000, 28500, 23000],
              backgroundColor: '#4f46e5',
              borderRadius: 6
            },
            {
              label: 'Overdue / Pending (PKR)',
              data: [0, 8000, 8500, 9000, 9500, 11500],
              backgroundColor: '#f43f5e',
              borderRadius: 6
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: { y: { beginAtZero: true } }
        }
      });
    }

    // Grades Chart
    const ctx2 = document.getElementById('dashboardGradesChart');
    if (ctx2) {
      new Chart(ctx2, {
        type: 'doughnut',
        data: {
          labels: ['Grade A+ (90%+)', 'Grade A (80-89%)', 'Grade B (70-79%)', 'At Risk (<60%)'],
          datasets: [{
            data: [4, 5, 2, 3],
            backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { position: 'bottom' } }
        }
      });
    }
  });
</script>
@endpush
