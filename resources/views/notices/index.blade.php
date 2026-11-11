@extends('layouts.app')

@section('title', 'Notice Board')

@section('content')
<div class="space-y-6">
  <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h2 class="text-xl font-bold text-slate-800">Notice Board & Digital Circulars</h2>
      <p class="text-xs text-slate-500">Official circulars dispatched to students, teachers, and parents</p>
    </div>
    <button onclick="document.getElementById('addNoticeModal').classList.remove('hidden'); document.getElementById('addNoticeModal').classList.add('flex')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
      <i data-lucide="plus-circle" class="w-4 h-4"></i> + Post New Circular
    </button>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    @foreach ($notices as $n)
      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between gap-2 mb-2">
            <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full {{ $n->priority === 'urgent' ? 'bg-rose-100 text-rose-700' : 'bg-indigo-100 text-indigo-700' }}">
              {{ $n->priority }}
            </span>
            <span class="text-xs text-slate-400 font-mono">{{ $n->date ? $n->date->format('d M Y') : 'Today' }}</span>
          </div>
          <h3 class="font-bold text-slate-900 text-base mb-2">{{ $n->title }}</h3>
          <p class="text-xs text-slate-600 leading-relaxed">{{ $n->content }}</p>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
          <span>Target: <b class="text-slate-700">{{ $n->audience }}</b></span>
          <span class="text-indigo-600 font-semibold">{{ $n->category }}</span>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- MODAL: ADD NOTICE -->
<div id="addNoticeModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl overflow-hidden border border-slate-100">
    <div class="bg-indigo-900 p-5 text-white flex items-center justify-between">
      <h3 class="font-bold text-base flex items-center gap-2">
        <i data-lucide="bell" class="w-5 h-5 text-amber-400"></i> Broadcast Circular Notice
      </h3>
      <button onclick="document.getElementById('addNoticeModal').classList.add('hidden'); document.getElementById('addNoticeModal').classList.remove('flex')" class="text-white/80 hover:text-white">✕</button>
    </div>

    <form action="{{ route('notices.store') }}" method="POST" class="p-6 space-y-4 text-xs">
      @csrf
      <div>
        <label class="block font-bold text-slate-700 mb-1">Circular Title *</label>
        <input type="text" name="title" required placeholder="e.g. Winter Break Schedule 2026" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl">
      </div>

      <div class="grid grid-cols-3 gap-3">
        <div>
          <label class="block font-bold text-slate-700 mb-1">Category</label>
          <select name="category" class="w-full px-2.5 py-2 bg-slate-50 border border-slate-300 rounded-xl">
            <option value="General">General</option>
            <option value="Academics">Academics</option>
            <option value="Finance">Finance</option>
            <option value="Events">Events</option>
          </select>
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Target Audience</label>
          <select name="audience" class="w-full px-2.5 py-2 bg-slate-50 border border-slate-300 rounded-xl">
            <option value="All">All School</option>
            <option value="Parents">Parents</option>
            <option value="Students">Students</option>
            <option value="Teachers">Teachers</option>
          </select>
        </div>
        <div>
          <label class="block font-bold text-slate-700 mb-1">Priority</label>
          <select name="priority" class="w-full px-2.5 py-2 bg-slate-50 border border-slate-300 rounded-xl">
            <option value="normal">Normal</option>
            <option value="urgent">Urgent</option>
            <option value="high">High</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block font-bold text-slate-700 mb-1">Notice Content *</label>
        <textarea name="content" rows="4" required placeholder="Detailed message text..." class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl leading-relaxed"></textarea>
      </div>

      <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
        <button type="button" onclick="document.getElementById('addNoticeModal').classList.add('hidden'); document.getElementById('addNoticeModal').classList.remove('flex')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">
          Cancel
        </button>
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition">
          Publish Circular
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
