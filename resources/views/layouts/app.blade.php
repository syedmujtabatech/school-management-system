<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Crescent Model School') - Laravel School ERP</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#eef2ff',
              100: '#e0e7ff',
              500: '#6366f1',
              600: '#4f46e5',
              700: '#4338ca',
              800: '#3730a3',
              900: '#312e81',
              950: '#1e1b4b',
            }
          }
        }
      }
    }
  </script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Libre+Barcode+39+Text&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #f8fafc;
      color: #0f172a;
    }
    .barcode { font-family: 'Libre Barcode 39 Text', cursive; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }
  </style>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Canvas Confetti -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex antialiased">

  <!-- Left Sidebar Navigation -->
  <aside id="mainSidebar" class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex min-h-screen border-r border-slate-800 transition-all duration-300 fixed md:sticky top-0 z-40">
    <div>
      <!-- School Logo Header -->
      <div class="p-6 border-b border-slate-800 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-400 to-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-emerald-500/20">
          C
        </div>
        <div>
          <h1 class="font-extrabold text-sm text-white tracking-wide uppercase">Crescent School</h1>
          <span class="text-[10px] text-emerald-400 font-semibold tracking-wider uppercase block">Model ERP v12</span>
        </div>
      </div>

      <!-- Navigation Links -->
      <nav class="p-4 space-y-1 text-xs font-semibold">
        <div class="px-3 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">Core Management</div>
        
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('dashboard*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('students*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <i data-lucide="users" class="w-4 h-4"></i>
          <span>Student Directory</span>
        </a>

        <a href="{{ route('teachers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('teachers*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <i data-lucide="graduation-cap" class="w-4 h-4"></i>
          <span>Faculty & Staff</span>
        </a>

        <a href="{{ route('fees.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('fees*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <i data-lucide="credit-card" class="w-4 h-4"></i>
          <span>Fee Accounts & Challans</span>
        </a>

        <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('attendance*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <i data-lucide="calendar-check" class="w-4 h-4"></i>
          <span>Smart Attendance & RFID</span>
        </a>

        <a href="{{ route('academics.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('academics*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <i data-lucide="award" class="w-4 h-4"></i>
          <span>Examinations & Marks</span>
        </a>

        <div class="px-3 pt-4 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">2026 Researched Modules</div>

        <a href="{{ route('ai.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('ai*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <div class="flex items-center gap-3">
            <i data-lucide="sparkles" class="w-4 h-4 text-purple-400"></i>
            <span>AI Student Success</span>
          </div>
          <span class="text-[9px] bg-purple-500/20 text-purple-300 px-1.5 py-0.5 rounded font-bold uppercase">AI</span>
        </a>

        <a href="{{ route('timetable.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('timetable*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <i data-lucide="clock" class="w-4 h-4"></i>
          <span>Weekly Timetable</span>
        </a>

        <a href="{{ route('notices.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('notices*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <i data-lucide="bell" class="w-4 h-4"></i>
          <span>Notice Board</span>
        </a>

        <a href="{{ route('downloads.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition border border-indigo-500/30 bg-indigo-950/20 {{ request()->routeIs('downloads*') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
          <div class="flex items-center gap-3">
            <i data-lucide="download" class="w-4 h-4 text-amber-400"></i>
            <span class="text-white font-bold">Admin Download Hub</span>
          </div>
          <span class="text-[9px] bg-amber-400 text-slate-950 px-1.5 py-0.5 rounded font-black">EXPORT</span>
        </a>
      </nav>
    </div>

    <!-- Principal Profile Footer -->
    <div class="p-4 border-t border-slate-800/80">
      <div class="bg-slate-800/50 p-3 rounded-2xl border border-slate-700/50 flex items-center gap-3">
        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=80&h=80&q=80" alt="Admin" class="w-9 h-9 rounded-xl object-cover border border-slate-600">
        <div class="min-w-0 flex-1">
          <p class="text-xs font-bold text-white truncate">Dr. Farhan Qureshi</p>
          <span class="text-[10px] text-emerald-400 font-semibold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Principal / SuperAdmin
          </span>
        </div>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="flex-1 flex flex-col min-w-0">
    <!-- Top Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 md:px-8 py-3.5 flex items-center justify-between gap-4">
      <div class="flex items-center gap-3 flex-1 max-w-md">
        <button onclick="document.getElementById('mainSidebar').classList.toggle('hidden')" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
          <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <!-- Search Bar Form -->
        <form action="{{ route('students.index') }}" method="GET" class="relative w-full">
          <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Quick search students, roll number, admission..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
        </form>
      </div>

      <div class="flex items-center gap-3">
        <!-- Role Simulation Selector -->
        <div class="flex items-center gap-2">
          <span class="hidden sm:inline-block px-2.5 py-1 text-xs font-bold rounded-full bg-indigo-100 text-indigo-700 border border-indigo-200">
            Admin / Principal
          </span>
        </div>

        <!-- RFID Quick Punch Button -->
        <button onclick="openBiometricModal()" title="Launch RFID Card Simulator" class="p-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl border border-emerald-200 transition flex items-center gap-1.5 text-xs font-bold">
          <i data-lucide="scan" class="w-4 h-4"></i>
          <span class="hidden lg:inline">RFID Scan</span>
        </button>

        <!-- Admin Download Hub Button -->
        <a href="{{ route('downloads.index') }}" class="p-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-xl border border-indigo-200 transition flex items-center gap-1.5 text-xs font-bold" title="Open Download Center">
          <i data-lucide="download" class="w-4 h-4"></i>
          <span class="hidden lg:inline">Downloads</span>
        </a>
      </div>
    </header>

    <!-- Success & Error Alert Flash Messages -->
    <div class="px-4 md:px-8 pt-4">
      @if (session('success'))
        <div class="p-4 bg-emerald-500 text-white rounded-2xl shadow-lg flex items-center justify-between text-xs font-semibold">
          <div class="flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span>{{ session('success') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white">✕</button>
        </div>
      @endif

      @if ($errors->any())
        <div class="p-4 bg-rose-500 text-white rounded-2xl shadow-lg text-xs font-semibold space-y-1">
          @foreach ($errors->all() as $error)
            <div>• {{ $error }}</div>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-1 p-4 md:p-8 max-w-7xl mx-auto w-full">
      @yield('content')
    </main>
  </div>

  <!-- MODAL: BIOMETRIC / RFID CARD SCANNER SIMULATOR -->
  <div id="biometricModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-100">
      <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-6 text-white text-center relative">
        <button onclick="closeBiometricModal()" class="absolute right-4 top-4 text-white/80 hover:text-white p-1">✕</button>
        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
          <i data-lucide="scan" class="w-8 h-8 text-white"></i>
        </div>
        <h3 class="font-extrabold text-lg">Smart RFID / Biometric Terminal</h3>
        <p class="text-emerald-100 text-xs mt-1">Live Student Entry Card Punch Simulator</p>
      </div>

      <div class="p-6 space-y-4">
        <div>
          <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Swipe Card or Enter ID:</label>
          <div class="flex gap-2">
            <input type="text" id="bioCardInput" placeholder="e.g. RFID-994821 or ADM-2026-101" class="flex-1 px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono focus:ring-2 focus:ring-emerald-500">
            <button onclick="submitBiometricSwipe()" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition">
              Punch
            </button>
          </div>
        </div>

        <div id="bioFeedback"></div>

        <div class="pt-2 border-t border-slate-100 text-xs text-slate-500">
          <p class="font-bold text-slate-700 mb-1.5">Quick Test Badges (Click to tap):</p>
          <div class="flex flex-wrap gap-2">
            <button onclick="triggerTestSwipe('RFID-994821')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 rounded-lg font-mono text-[11px] text-slate-700">
              M. Hamza (RFID-994821)
            </button>
            <button onclick="triggerTestSwipe('RFID-994822')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 rounded-lg font-mono text-[11px] text-slate-700">
              Zainab Fatima (RFID-994822)
            </button>
            <button onclick="triggerTestSwipe('ADM-2026-103')" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 rounded-lg font-mono text-[11px] text-slate-700">
              Abdullah (ADM-2026-103)
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    lucide.createIcons();

    function openBiometricModal() {
      const modal = document.getElementById('biometricModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      const input = document.getElementById('bioCardInput');
      input.value = '';
      setTimeout(() => input.focus(), 100);
    }

    function closeBiometricModal() {
      const modal = document.getElementById('biometricModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }

    function triggerTestSwipe(code) {
      document.getElementById('bioCardInput').value = code;
      submitBiometricSwipe();
    }

    function submitBiometricSwipe() {
      const code = document.getElementById('bioCardInput').value.trim();
      const feedback = document.getElementById('bioFeedback');
      if (!code) return;

      feedback.innerHTML = '<div class="text-xs text-slate-500 animate-pulse">Verifying card reader...</div>';

      fetch("{{ route('attendance.punch') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ code: code })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          feedback.innerHTML = `
            <div class="p-3 bg-emerald-100 border border-emerald-300 rounded-xl text-emerald-900 text-xs font-medium">
              ✓ Verified: <b>${data.student.name}</b> (${data.student.class_name})<br>
              Punch Time: <b>${data.time}</b> • Marked PRESENT!
            </div>
          `;
          document.getElementById('bioCardInput').value = '';
          if (typeof confetti === 'function') {
            confetti({ particleCount: 50, spread: 60, origin: { y: 0.6 } });
          }
          setTimeout(() => closeBiometricModal(), 2000);
        } else {
          feedback.innerHTML = `
            <div class="p-3 bg-rose-100 border border-rose-300 rounded-xl text-rose-900 text-xs font-medium">
              ✕ ${data.message}
            </div>
          `;
        }
      })
      .catch(err => {
        feedback.innerHTML = '<div class="text-xs text-rose-600 font-bold">Server connection error.</div>';
      });
    }
  </script>

  @stack('scripts')
</body>
</html>
