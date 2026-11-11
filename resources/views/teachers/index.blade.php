@extends('layouts.app')

@section('title', 'Faculty & Staff')

@section('content')
<div class="space-y-6">
  <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-bold text-slate-800">Faculty & Academic Staff</h2>
      <p class="text-xs text-slate-500">Department faculty, designations, qualifications, and payroll</p>
    </div>
    <button onclick="document.getElementById('addTeacherModal').classList.remove('hidden'); document.getElementById('addTeacherModal').classList.add('flex')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
      <i data-lucide="user-plus" class="w-4 h-4"></i> + Add Faculty
    </button>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
    @foreach ($teachers as $t)
      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between text-center">
        <div>
          <img src="{{ $t->avatar }}" alt="{{ $t->name }}" class="w-20 h-20 rounded-2xl object-cover mx-auto border-2 border-indigo-100 shadow">
          <h3 class="font-bold text-slate-900 text-sm mt-3">{{ $t->name }}</h3>
          <span class="inline-block text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2.5 py-0.5 rounded-full mt-1">{{ $t->subject }}</span>
          <p class="text-xs text-slate-500 mt-1">{{ $t->designation }}</p>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-600 space-y-1 bg-slate-50 p-2.5 rounded-xl text-left">
          <div class="flex justify-between"><span class="text-slate-400">Degree:</span><b class="truncate">{{ $t->qualification }}</b></div>
          <div class="flex justify-between"><span class="text-slate-400">Phone:</span><b>{{ $t->phone }}</b></div>
          <div class="flex justify-between"><span class="text-slate-400">Salary:</span><b>PKR {{ number_format($t->salary) }}</b></div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- MODAL: ADD FACULTY -->
<div id="addTeacherModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden border border-slate-100">
    <div class="bg-indigo-900 p-5 text-white flex items-center justify-between">
      <h3 class="font-bold text-base flex items-center gap-2">
        <i data-lucide="user-plus" class="w-5 h-5 text-indigo-400"></i> Add Faculty Member
      </h3>
      <button onclick="document.getElementById('addTeacherModal').classList.add('hidden'); document.getElementById('addTeacherModal').classList.remove('flex')" class="text-white/80 hover:text-white">✕</button>
    </div>

    <form action="{{ route('teachers.store') }}" method="POST" class="p-6 space-y-4 text-xs">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block font-bold text-slate-700 mb-1">Full Name *</label>
          <input type="text" name="name" required placeholder="e.g. Prof. Salman Shah" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Designation *</label>
          <input type="text" name="designation" required placeholder="e.g. Senior Lecturer" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Teaching Subject *</label>
          <input type="text" name="subject" required placeholder="e.g. Mathematics" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Highest Qualification</label>
          <input type="text" name="qualification" placeholder="e.g. M.Phil Mathematics" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Email</label>
          <input type="email" name="email" placeholder="faculty@apexacademy.edu" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Contact Phone</label>
          <input type="text" name="phone" placeholder="+92 300 1234567" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl font-mono">
        </div>
        <div class="md:col-span-2">
          <label class="block font-bold text-slate-700 mb-1">Monthly Salary (PKR)</label>
          <input type="number" name="salary" value="95000" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl font-mono">
        </div>
      </div>

      <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
        <button type="button" onclick="document.getElementById('addTeacherModal').classList.add('hidden'); document.getElementById('addTeacherModal').classList.remove('flex')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">
          Cancel
        </button>
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition">
          Add Faculty
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
