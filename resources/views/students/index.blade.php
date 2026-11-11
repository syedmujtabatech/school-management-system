@extends('layouts.app')

@section('title', 'Student Directory')

@section('content')
<div class="space-y-6">
  <!-- Top Toolbar -->
  <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-bold text-slate-800">Student Directory & Profiles</h2>
      <p class="text-xs text-slate-500">Manage enrolled pupils, print badges, and download marksheets</p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
      <!-- Filter by Class -->
      <form action="{{ route('students.index') }}" method="GET" class="flex items-center gap-2">
        <select name="class" onchange="this.form.submit()" class="text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
          <option value="All">All Classes</option>
          @foreach ($classes as $c)
            <option value="{{ $c->name }}" {{ request('class') == $c->name ? 'selected' : '' }}>{{ $c->name }}</option>
          @endforeach
        </select>
      </form>

      <!-- Export CSV/Excel -->
      <a href="{{ route('reports.export.students') }}" class="px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-200 transition flex items-center gap-1.5">
        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Export Excel (.csv)
      </a>

      <!-- Enroll Student Modal Trigger -->
      <button onclick="document.getElementById('enrollStudentModal').classList.remove('hidden'); document.getElementById('enrollStudentModal').classList.add('flex')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
        <i data-lucide="user-plus" class="w-4 h-4"></i> + Enroll Student
      </button>
    </div>
  </div>

  <!-- Student Cards Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse ($students as $s)
      <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition p-5 flex flex-col justify-between">
        <div>
          <div class="flex items-start gap-3.5">
            <img src="{{ $s->avatar }}" alt="{{ $s->name }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-sm">
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between">
                <span class="text-[10px] font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">{{ $s->admission_no }}</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $s->fee_status === 'Paid' ? 'bg-emerald-100 text-emerald-700' : ($s->fee_status === 'Pending' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">{{ $s->fee_status }}</span>
              </div>
              <h3 class="font-bold text-slate-900 text-sm mt-1 truncate">{{ $s->name }}</h3>
              <p class="text-xs text-slate-500">S/O: {{ $s->father_name }}</p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-2 mt-4 text-xs bg-slate-50 p-2.5 rounded-xl border border-slate-100">
            <div><span class="text-slate-400 block text-[10px]">Class / Roll:</span><b class="text-slate-800">{{ $s->class_name }} (#{{ $s->roll_no }})</b></div>
            <div><span class="text-slate-400 block text-[10px]">Attendance:</span><b class="{{ $s->attendance_rate >= 80 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $s->attendance_rate }}%</b></div>
            <div><span class="text-slate-400 block text-[10px]">Blood Group:</span><b class="text-slate-800">{{ $s->blood_group ?? 'O+' }}</b></div>
            <div><span class="text-slate-400 block text-[10px]">Phone:</span><b class="text-slate-700 font-mono text-[11px]">{{ $s->phone }}</b></div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-1.5 text-xs">
          <!-- 1-Click Print ID Card -->
          <a href="{{ route('reports.id_card', $s->id) }}" target="_blank" title="Print/Download Official ID Badge" class="p-2 hover:bg-indigo-50 text-indigo-600 rounded-lg transition font-medium flex items-center gap-1">
            <i data-lucide="badge-check" class="w-4 h-4"></i> ID Card
          </a>

          <!-- 1-Click Print Fee Slip -->
          <a href="{{ route('reports.challan', $s->id) }}" target="_blank" title="Print 3-Ply Fee Voucher" class="p-2 hover:bg-emerald-50 text-emerald-600 rounded-lg transition font-medium flex items-center gap-1">
            <i data-lucide="receipt" class="w-4 h-4"></i> Fee Slip
          </a>

          <!-- 1-Click Print Report Card -->
          <a href="{{ route('reports.marksheet', $s->id) }}" target="_blank" title="Print Academic Progress Marksheet" class="p-2 hover:bg-purple-50 text-purple-600 rounded-lg transition font-medium flex items-center gap-1">
            <i data-lucide="graduation-cap" class="w-4 h-4"></i> Marksheet
          </a>

          <!-- Delete -->
          <form action="{{ route('students.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Remove student record?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" title="Remove Record" class="p-2 hover:bg-rose-50 text-rose-500 rounded-lg transition">
              <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
        <i data-lucide="search-x" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
        <p class="text-slate-500 font-semibold text-sm">No students match your criteria.</p>
      </div>
    @endforelse
  </div>
</div>

<!-- MODAL: ENROLL STUDENT -->
<div id="enrollStudentModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl overflow-hidden border border-slate-100 max-h-[90vh] flex flex-col">
    <div class="bg-indigo-900 p-5 text-white flex items-center justify-between">
      <h3 class="font-bold text-base flex items-center gap-2">
        <i data-lucide="user-plus" class="w-5 h-5 text-indigo-400"></i> Enroll New Student
      </h3>
      <button onclick="document.getElementById('enrollStudentModal').classList.add('hidden'); document.getElementById('enrollStudentModal').classList.remove('flex')" class="text-white/80 hover:text-white">✕</button>
    </div>

    <form action="{{ route('students.store') }}" method="POST" class="p-6 space-y-4 overflow-y-auto text-xs">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block font-bold text-slate-700 mb-1">Student Full Name *</label>
          <input type="text" name="name" required placeholder="e.g. Ali Raza" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Father's Name *</label>
          <input type="text" name="father_name" required placeholder="e.g. Raza Ahmed" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Class *</label>
          <select name="class_name" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl font-medium">
            <option value="Class 6">Class 6</option>
            <option value="Class 7">Class 7</option>
            <option value="Class 8">Class 8</option>
            <option value="Class 9">Class 9</option>
            <option value="Class 10" selected>Class 10</option>
            <option value="Class 11">Class 11</option>
          </select>
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Section</label>
          <input type="text" name="section" value="Science" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Roll Number</label>
          <input type="number" name="roll_no" value="15" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Gender</label>
          <select name="gender" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Blood Group</label>
          <input type="text" name="blood_group" value="B+" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Parent Phone *</label>
          <input type="text" name="phone" required placeholder="+92 300 0000000" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl font-mono">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Guardian Email</label>
          <input type="email" name="guardian_email" placeholder="parent@gmail.com" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Monthly Tuition Fee (PKR)</label>
          <input type="number" name="fee_amount" value="9500" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl font-mono">
        </div>
      </div>

      <div>
        <label class="block font-bold text-slate-700 mb-1">Residential Address</label>
        <textarea name="address" rows="2" placeholder="House number, Street, Sector, City" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl"></textarea>
      </div>

      <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
        <button type="button" onclick="document.getElementById('enrollStudentModal').classList.add('hidden'); document.getElementById('enrollStudentModal').classList.remove('flex')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">
          Cancel
        </button>
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition">
          Complete Enrollment
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
