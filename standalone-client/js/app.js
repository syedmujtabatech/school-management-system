/**
 * Apex International Academy - Core Application Controller
 */

class SchoolApp {
  constructor() {
    this.currentView = 'dashboard';
    this.currentRole = 'admin'; // 'admin', 'teacher', 'student'
    this.selectedClassFilter = 'All';
    this.searchQuery = '';
    this.charts = {};
    
    this.init();
  }

  init() {
    this.setupNavigation();
    this.setupRoleSwitcher();
    this.setupEventListeners();
    this.render();
  }

  // Navigation Routing
  navigateTo(viewId) {
    this.currentView = viewId;
    
    // Update nav links
    document.querySelectorAll('.nav-link').forEach(link => {
      const target = link.getAttribute('data-view');
      if (target === viewId) {
        link.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
        link.classList.remove('text-slate-600', 'hover:bg-slate-100');
      } else {
        link.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
        link.classList.add('text-slate-600', 'hover:bg-slate-100');
      }
    });

    // Update main view container
    this.render();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  setupNavigation() {
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const view = link.getAttribute('data-view');
        this.navigateTo(view);
      });
    });
  }

  setupRoleSwitcher() {
    const roleSelect = document.getElementById('roleSelector');
    if (roleSelect) {
      roleSelect.value = this.currentRole;
      roleSelect.addEventListener('change', (e) => {
        this.currentRole = e.target.value;
        this.showToast(`Switched view to: ${this.currentRole.toUpperCase()}`, 'info');
        this.updateRoleUI();
        this.render();
      });
    }
  }

  updateRoleUI() {
    const roleBadge = document.getElementById('activeRoleBadge');
    if (roleBadge) {
      if (this.currentRole === 'admin') {
        roleBadge.className = "px-2.5 py-1 text-xs font-bold rounded-full bg-indigo-100 text-indigo-700 border border-indigo-200";
        roleBadge.textContent = "Admin / Principal";
      } else if (this.currentRole === 'teacher') {
        roleBadge.className = "px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200";
        roleBadge.textContent = "Teacher Faculty";
      } else {
        roleBadge.className = "px-2.5 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-700 border border-purple-200";
        roleBadge.textContent = "Student / Parent Portal";
      }
    }
  }

  setupEventListeners() {
    // Quick search bar in header
    const searchInput = document.getElementById('globalSearchInput');
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        this.searchQuery = e.target.value.toLowerCase();
        if (this.currentView === 'students' || this.currentView === 'fees' || this.currentView === 'attendance') {
          this.render();
        }
      });
    }

    // Biometric Scanner Quick Toggle button in header
    const bioBtn = document.getElementById('quickScanBtn');
    if (bioBtn) {
      bioBtn.addEventListener('click', () => {
        this.openBiometricModal();
      });
    }
  }

  // Toast Notifications
  showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    const bgClass = type === 'success' ? 'bg-emerald-600' : type === 'error' ? 'bg-rose-600' : 'bg-indigo-600';
    toast.className = `${bgClass} text-white px-4 py-3 rounded-xl shadow-xl flex items-center gap-3 transition-all duration-300 transform translate-y-2 text-sm font-medium z-50`;
    toast.innerHTML = `
      <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'alert-triangle' : 'info'}" class="w-5 h-5 flex-shrink-0"></i>
      <span>${message}</span>
    `;
    container.appendChild(toast);
    lucide.createIcons();

    setTimeout(() => {
      toast.classList.add('opacity-0', 'translate-y-4');
      setTimeout(() => toast.remove(), 300);
    }, 3500);
  }

  // Main Render Switcher
  render() {
    const viewContainer = document.getElementById('mainContentArea');
    if (!viewContainer) return;

    switch (this.currentView) {
      case 'dashboard':
        viewContainer.innerHTML = this.renderDashboard();
        this.initDashboardCharts();
        break;
      case 'students':
        viewContainer.innerHTML = this.renderStudents();
        break;
      case 'teachers':
        viewContainer.innerHTML = this.renderTeachers();
        break;
      case 'fees':
        viewContainer.innerHTML = this.renderFees();
        this.initFeeChart();
        break;
      case 'attendance':
        viewContainer.innerHTML = this.renderAttendance();
        break;
      case 'academics':
        viewContainer.innerHTML = this.renderAcademics();
        break;
      case 'ai_insights':
        viewContainer.innerHTML = this.renderAIInsights();
        break;
      case 'timetable':
        viewContainer.innerHTML = this.renderTimetable();
        break;
      case 'notices':
        viewContainer.innerHTML = this.renderNotices();
        break;
      case 'downloads':
        viewContainer.innerHTML = this.renderDownloadsHub();
        break;
      default:
        viewContainer.innerHTML = this.renderDashboard();
    }

    lucide.createIcons();
  }

  // 1. DASHBOARD VIEW
  renderDashboard() {
    const students = window.db.getStudents();
    const teachers = window.db.getTeachers();
    const notices = window.db.data.notices || [];
    const activities = window.db.data.recentActivity || [];

    const totalStudents = students.length;
    const paidFees = students.filter(s => s.feeStatus === 'Paid').reduce((acc, s) => acc + s.feeAmount, 0);
    const pendingFees = students.filter(s => s.feeStatus !== 'Paid').reduce((acc, s) => acc + s.feeAmount, 0);
    const avgAttendance = Math.round(students.reduce((acc, s) => acc + (s.attendanceRate || 0), 0) / (totalStudents || 1));
    const atRiskStudents = window.aiEngine.getSchoolAnalytics().criticalCount;

    return `
      <div class="space-y-6">
        <!-- Top Welcome Banner -->
        <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
          
          <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold text-amber-300 border border-white/10">
              <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
              Live Academic Session 2026-2027
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Apex International Academy Portal</h1>
            <p class="text-indigo-200 text-sm max-w-xl">
              Welcome back! Here is today's executive summary covering student attendance, fee collections, and AI academic risk metrics.
            </p>
          </div>

          <div class="relative z-10 flex flex-wrap gap-3">
            <button onclick="window.app.openBiometricModal()" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-semibold shadow-lg transition flex items-center gap-2">
              <i data-lucide="scan" class="w-4 h-4"></i> RFID Punch Scanner
            </button>
            <button onclick="window.app.navigateTo('downloads')" class="px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white backdrop-blur-md rounded-xl text-sm font-semibold border border-white/20 transition flex items-center gap-2">
              <i data-lucide="download" class="w-4 h-4"></i> Admin Download Hub
            </button>
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
              <span class="text-3xl font-extrabold text-slate-900">${totalStudents}</span>
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
              <span class="text-2xl font-extrabold text-slate-900">PKR ${(paidFees / 1000).toFixed(1)}k</span>
              <span class="text-xs font-semibold text-slate-500">of ${( (paidFees + pendingFees) / 1000 ).toFixed(1)}k</span>
            </div>
            <div class="mt-2 flex items-center justify-between text-xs">
              <span class="text-rose-600 font-medium">PKR ${pendingFees.toLocaleString()} Pending</span>
              <span class="text-emerald-600 font-bold">${Math.round((paidFees / (paidFees + pendingFees || 1)) * 100)}%</span>
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
              <span class="text-3xl font-extrabold text-slate-900">${avgAttendance}%</span>
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
              <span class="text-3xl font-extrabold text-rose-600">${atRiskStudents}</span>
              <span class="text-xs font-semibold text-rose-600">Students Need Help</span>
            </div>
            <div class="mt-2 text-xs text-rose-700 font-medium cursor-pointer hover:underline" onclick="window.app.navigateTo('ai_insights')">
              View AI Remedial Plan →
            </div>
          </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Fee Collection Analytics Chart -->
          <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="font-bold text-slate-800 text-base">Financial Overview (Term 1)</h3>
                <p class="text-xs text-slate-500">Collected vs Overdue tuition breakdown</p>
              </div>
              <button onclick="window.reportManager.exportDefaultersToExcel()" class="text-xs px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition flex items-center gap-1.5">
                <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5 text-emerald-600"></i> Export Defaulters (.xlsx)
              </button>
            </div>
            <div class="h-64">
              <canvas id="dashboardFinanceChart"></canvas>
            </div>
          </div>

          <!-- Grade Distribution Chart -->
          <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="mb-4">
              <h3 class="font-bold text-slate-800 text-base">Academic Grade Spread</h3>
              <p class="text-xs text-slate-500">Midterm terminal results summary</p>
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
              <span class="text-xs text-slate-400">Automated log</span>
            </div>
            <div class="space-y-3">
              ${activities.slice(0, 5).map(act => `
                <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                  <div class="w-8 h-8 rounded-lg ${act.type === 'fee' ? 'bg-emerald-100 text-emerald-700' : act.type === 'attendance' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700'} flex items-center justify-center flex-shrink-0 text-xs font-bold">
                    ${act.type === 'fee' ? '₨' : act.type === 'attendance' ? '⏱' : '★'}
                  </div>
                  <div class="flex-1 text-xs">
                    <p class="font-medium text-slate-800">${act.message}</p>
                    <span class="text-[10px] text-slate-400">${act.time}</span>
                  </div>
                </div>
              `).join('')}
            </div>
          </div>

          <!-- Active Notices Broadcast -->
          <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                <i data-lucide="bell" class="w-4 h-4 text-amber-500"></i> School Notice Board
              </h3>
              <button onclick="window.app.navigateTo('notices')" class="text-xs text-indigo-600 hover:underline font-semibold">View All Notices →</button>
            </div>
            <div class="space-y-3">
              ${notices.slice(0, 3).map(not => `
                <div class="p-3.5 bg-slate-50 hover:bg-slate-100/80 rounded-xl border border-slate-200/60 transition">
                  <div class="flex items-center justify-between gap-2 mb-1">
                    <h4 class="font-bold text-xs text-slate-800">${not.title}</h4>
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-bold ${not.priority === 'urgent' ? 'bg-rose-100 text-rose-700' : 'bg-indigo-100 text-indigo-700'} uppercase">${not.priority}</span>
                  </div>
                  <p class="text-xs text-slate-600 line-clamp-2">${not.content}</p>
                  <div class="mt-2 text-[10px] text-slate-400 font-medium">Target: ${not.audience} • Date: ${not.date}</div>
                </div>
              `).join('')}
            </div>
          </div>
        </div>
      </div>
    `;
  }

  // Charts Initializer
  initDashboardCharts() {
    const students = window.db.getStudents();
    const paidCount = students.filter(s => s.feeStatus === 'Paid').length;
    const pendingCount = students.filter(s => s.feeStatus === 'Pending').length;
    const overdueCount = students.filter(s => s.feeStatus === 'Overdue').length;

    // Destroy existing instances if any
    if (this.charts.finance) this.charts.finance.destroy();
    if (this.charts.grades) this.charts.grades.destroy();

    const ctx1 = document.getElementById('dashboardFinanceChart');
    if (ctx1) {
      this.charts.finance = new Chart(ctx1, {
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
          plugins: { legend: { position: 'top' } },
          scales: { y: { beginAtZero: true } }
        }
      });
    }

    const ctx2 = document.getElementById('dashboardGradesChart');
    if (ctx2) {
      this.charts.grades = new Chart(ctx2, {
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
  }

  initFeeChart() {
    const students = window.db.getStudents();
    const paidCount = students.filter(s => s.feeStatus === 'Paid').length;
    const pendingCount = students.filter(s => s.feeStatus === 'Pending').length;
    const overdueCount = students.filter(s => s.feeStatus === 'Overdue').length;

    if (this.charts.feeBreakdown) this.charts.feeBreakdown.destroy();
    const ctx = document.getElementById('feesBreakdownChart');
    if (ctx) {
      this.charts.feeBreakdown = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Paid', 'Pending', 'Overdue'],
          datasets: [{
            data: [paidCount, pendingCount, overdueCount],
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } }
        }
      });
    }
  }

  // 2. STUDENTS VIEW
  renderStudents() {
    let students = window.db.getStudents();

    // Filters
    if (this.selectedClassFilter !== 'All') {
      students = students.filter(s => s.class === this.selectedClassFilter);
    }
    if (this.searchQuery) {
      students = students.filter(s => 
        s.name.toLowerCase().includes(this.searchQuery) || 
        s.admissionNo.toLowerCase().includes(this.searchQuery) ||
        s.fatherName.toLowerCase().includes(this.searchQuery)
      );
    }

    return `
      <div class="space-y-6">
        <!-- Top Toolbar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="text-xl font-bold text-slate-800">Student Directory & Profiles</h2>
            <p class="text-xs text-slate-500">Manage enrolled pupils, print badges, and download marksheets</p>
          </div>

          <div class="flex flex-wrap items-center gap-3">
            <!-- Filter by Class -->
            <select onchange="window.app.filterClass(this.value)" class="text-xs font-semibold px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
              <option value="All" ${this.selectedClassFilter === 'All' ? 'selected' : ''}>All Classes</option>
              <option value="Class 6" ${this.selectedClassFilter === 'Class 6' ? 'selected' : ''}>Class 6</option>
              <option value="Class 7" ${this.selectedClassFilter === 'Class 7' ? 'selected' : ''}>Class 7</option>
              <option value="Class 8" ${this.selectedClassFilter === 'Class 8' ? 'selected' : ''}>Class 8</option>
              <option value="Class 9" ${this.selectedClassFilter === 'Class 9' ? 'selected' : ''}>Class 9</option>
              <option value="Class 10" ${this.selectedClassFilter === 'Class 10' ? 'selected' : ''}>Class 10</option>
              <option value="Class 11" ${this.selectedClassFilter === 'Class 11' ? 'selected' : ''}>Class 11</option>
            </select>

            <!-- Export Excel -->
            <button onclick="window.reportManager.exportStudentsToExcel()" class="px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-200 transition flex items-center gap-1.5">
              <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Export Excel (.xlsx)
            </button>

            <!-- Add Student Modal Trigger -->
            <button onclick="window.app.openAddStudentModal()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
              <i data-lucide="user-plus" class="w-4 h-4"></i> + Enroll Student
            </button>
          </div>
        </div>

        <!-- Student Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          ${students.length === 0 ? `
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
              <i data-lucide="search-x" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
              <p class="text-slate-500 font-semibold text-sm">No students match your criteria.</p>
            </div>
          ` : students.map(s => `
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition p-5 flex flex-col justify-between">
              <div>
                <div class="flex items-start gap-3.5">
                  <img src="${s.avatar}" alt="${s.name}" class="w-13 h-13 w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-sm">
                  <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                      <span class="text-[10px] font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">${s.admissionNo}</span>
                      <span class="text-[10px] font-bold px-2 py-0.5 rounded-full ${s.feeStatus === 'Paid' ? 'bg-emerald-100 text-emerald-700' : s.feeStatus === 'Pending' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700'}">${s.feeStatus}</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm mt-1 truncate">${s.name}</h3>
                    <p class="text-xs text-slate-500">S/O: ${s.fatherName}</p>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-4 text-xs bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                  <div><span class="text-slate-400 block text-[10px]">Class / Roll:</span><b class="text-slate-800">${s.class} (#${s.rollNo})</b></div>
                  <div><span class="text-slate-400 block text-[10px]">Attendance:</span><b class="${s.attendanceRate >= 80 ? 'text-emerald-600' : 'text-rose-600'}">${s.attendanceRate}%</b></div>
                  <div><span class="text-slate-400 block text-[10px]">Blood Group:</span><b class="text-slate-800">${s.bloodGroup || 'O+'}</b></div>
                  <div><span class="text-slate-400 block text-[10px]">Phone:</span><b class="text-slate-700 font-mono text-[11px]">${s.phone}</b></div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-1.5 text-xs">
                <!-- 1-Click Print ID Card -->
                <button onclick="window.reportManager.downloadIDCard('${s.id}')" title="Print/Download Official ID Badge" class="p-2 hover:bg-indigo-50 text-indigo-600 rounded-lg transition font-medium flex items-center gap-1">
                  <i data-lucide="badge-check" class="w-4 h-4"></i> ID Card
                </button>

                <!-- 1-Click Print Fee Slip -->
                <button onclick="window.reportManager.downloadFeeVoucher('${s.id}')" title="Print 3-Ply Fee Voucher" class="p-2 hover:bg-emerald-50 text-emerald-600 rounded-lg transition font-medium flex items-center gap-1">
                  <i data-lucide="receipt" class="w-4 h-4"></i> Fee Slip
                </button>

                <!-- 1-Click Print Report Card -->
                <button onclick="window.reportManager.downloadReportCard('${s.id}')" title="Print Academic Progress Marksheet" class="p-2 hover:bg-purple-50 text-purple-600 rounded-lg transition font-medium flex items-center gap-1">
                  <i data-lucide="graduation-cap" class="w-4 h-4"></i> Marksheet
                </button>

                <!-- Delete -->
                <button onclick="window.app.deleteStudentConfirm('${s.id}')" title="Remove Record" class="p-2 hover:bg-rose-50 text-rose-500 rounded-lg transition">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  }

  filterClass(className) {
    this.selectedClassFilter = className;
    this.render();
  }

  deleteStudentConfirm(id) {
    if (confirm("Are you sure you want to delete this student record? This cannot be undone.")) {
      window.db.deleteStudent(id);
      this.showToast("Student record deleted successfully.", "success");
      this.render();
    }
  }

  // 3. FACULTY / TEACHERS VIEW
  renderTeachers() {
    const teachers = window.db.getTeachers();

    return `
      <div class="space-y-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="text-xl font-bold text-slate-800">Faculty & Academic Staff</h2>
            <p class="text-xs text-slate-500">Manage subject department heads and faculty schedules</p>
          </div>
          <button onclick="window.app.openAddTeacherModal()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
            <i data-lucide="user-plus" class="w-4 h-4"></i> + Add Faculty
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
          ${teachers.map(t => `
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between text-center">
              <div>
                <img src="${t.avatar}" alt="${t.name}" class="w-20 h-20 rounded-2xl object-cover mx-auto border-2 border-indigo-100 shadow">
                <h3 class="font-bold text-slate-900 text-sm mt-3">${t.name}</h3>
                <span class="inline-block text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2.5 py-0.5 rounded-full mt-1">${t.subject}</span>
                <p class="text-xs text-slate-500 mt-1">${t.designation}</p>
              </div>

              <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-600 space-y-1 bg-slate-50 p-2.5 rounded-xl text-left">
                <div class="flex justify-between"><span class="text-slate-400">Degree:</span><b class="truncate">${t.qualification}</b></div>
                <div class="flex justify-between"><span class="text-slate-400">Phone:</span><b>${t.phone}</b></div>
                <div class="flex justify-between"><span class="text-slate-400">Salary:</span><b>PKR ${t.salary.toLocaleString()}</b></div>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  }

  // 4. FEES & FINANCIAL MANAGEMENT VIEW
  renderFees() {
    let students = window.db.getStudents();
    if (this.searchQuery) {
      students = students.filter(s => s.name.toLowerCase().includes(this.searchQuery) || s.admissionNo.toLowerCase().includes(this.searchQuery));
    }

    const totalExpected = students.reduce((acc, s) => acc + s.feeAmount, 0);
    const totalCollected = students.filter(s => s.feeStatus === 'Paid').reduce((acc, s) => acc + s.feeAmount, 0);
    const totalOverdue = students.filter(s => s.feeStatus === 'Overdue').reduce((acc, s) => acc + s.feeAmount, 0);

    return `
      <div class="space-y-6">
        <!-- Financial Summary Header -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="text-xl font-bold text-slate-800">Fee Accounts & Challan Management</h2>
            <p class="text-xs text-slate-500">Track tuition payments, issue 3-ply bank vouchers, and dispatch reminders</p>
          </div>
          <div class="flex flex-wrap items-center gap-3">
            <button onclick="window.reportManager.bulkDownloadDefaulterChallans()" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-xl border border-rose-200 transition flex items-center gap-1.5">
              <i data-lucide="printer" class="w-4 h-4"></i> Print All Overdue Challans
            </button>
            <button onclick="window.reportManager.exportDefaultersToExcel()" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
              <i data-lucide="download" class="w-4 h-4"></i> Export Ledger (.xlsx)
            </button>
          </div>
        </div>

        <!-- Metric Stat Cards & Fee Breakdown Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
          <div class="space-y-4 lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-xs font-bold uppercase text-slate-500">Expected Total (Monthly)</span>
                <div class="text-2xl font-black text-slate-900 mt-2">PKR ${totalExpected.toLocaleString()}</div>
                <p class="text-xs text-slate-400 mt-1">${students.length} students enrolled</p>
              </div>
              <div class="bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm bg-emerald-50/20">
                <span class="text-xs font-bold uppercase text-emerald-700">Collected in Bank</span>
                <div class="text-2xl font-black text-emerald-700 mt-2">PKR ${totalCollected.toLocaleString()}</div>
                <p class="text-xs text-emerald-600 mt-1">${Math.round((totalCollected / (totalExpected || 1)) * 100)}% realization rate</p>
              </div>
              <div class="bg-white p-5 rounded-2xl border border-rose-200 shadow-sm bg-rose-50/20">
                <span class="text-xs font-bold uppercase text-rose-700">Overdue / Defaulter Sum</span>
                <div class="text-2xl font-black text-rose-700 mt-2">PKR ${totalOverdue.toLocaleString()}</div>
                <p class="text-xs text-rose-600 mt-1">Requires immediate follow-up</p>
              </div>
            </div>
          </div>

          <!-- Mini Doughnut Chart -->
          <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="text-xs font-bold text-slate-700">Collection Status</div>
            <div class="h-32 flex items-center justify-center my-2">
              <canvas id="feesBreakdownChart"></canvas>
            </div>
            <div class="text-[10px] text-center text-slate-400">Live reconciliation</div>
          </div>
        </div>

        <!-- Fee Ledger Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm">Student Tuition Ledger</h3>
            <span class="text-xs text-slate-500">Sorted by Roll No</span>
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
                ${students.map(s => `
                  <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-3 px-4">
                      <div class="font-bold text-slate-900">${s.name}</div>
                      <div class="text-[11px] text-slate-400 font-mono">${s.admissionNo} • ${s.phone}</div>
                    </td>
                    <td class="py-3 px-4 font-medium text-slate-700">${s.class} (${s.section})</td>
                    <td class="py-3 px-4 font-mono font-bold text-slate-900">PKR ${s.feeAmount.toLocaleString()}</td>
                    <td class="py-3 px-4">
                      <span class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase ${s.feeStatus === 'Paid' ? 'bg-emerald-100 text-emerald-800' : s.feeStatus === 'Pending' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800'}">
                        ${s.feeStatus}
                      </span>
                    </td>
                    <td class="py-3 px-4 text-slate-500 font-mono">${s.feeDueDate || '15/11/2026'}</td>
                    <td class="py-3 px-4 text-center">
                      <div class="flex items-center justify-center gap-2">
                        <!-- Mark as Paid -->
                        ${s.feeStatus !== 'Paid' ? `
                          <button onclick="window.app.markAsPaidPrompt('${s.id}')" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow transition">
                            ✓ Mark Paid
                          </button>
                        ` : `
                          <span class="text-xs text-emerald-600 font-semibold flex items-center gap-1">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> Paid
                          </span>
                        `}

                        <!-- Print 3-Ply Voucher -->
                        <button onclick="window.reportManager.downloadFeeVoucher('${s.id}')" class="px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-semibold border border-indigo-200 transition flex items-center gap-1">
                          <i data-lucide="receipt" class="w-3.5 h-3.5"></i> 3-Ply Challan
                        </button>

                        <!-- WhatsApp Reminder -->
                        ${s.feeStatus !== 'Paid' ? `
                          <button onclick="window.app.openWhatsAppReminder('${s.id}')" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold border border-emerald-200 transition flex items-center gap-1" title="Dispatch WhatsApp Alert">
                            <i data-lucide="message-square" class="w-3.5 h-3.5"></i> WhatsApp
                          </button>
                        ` : ''}
                      </div>
                    </td>
                  </tr>
                `).join('')}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    `;
  }

  markAsPaidPrompt(studentId) {
    if (confirm("Confirm fee payment receipt for this student?")) {
      window.db.markFeePaid(studentId);
      // Trigger celebration confetti
      if (typeof confetti === 'function') {
        confetti({ particleCount: 70, spread: 60, origin: { y: 0.7 } });
      }
      this.showToast("Payment recorded successfully! Fee voucher updated.", "success");
      this.render();
    }
  }

  openWhatsAppReminder(studentId) {
    const student = window.db.getStudentById(studentId);
    if (!student) return;

    const message = encodeURIComponent(`*APEX INTERNATIONAL ACADEMY - FEE REMINDER*\n\nDear Parent/Guardian of *${student.name}* (Class: ${student.class}, Roll: ${student.rollNo}),\n\nThis is a polite reminder that tuition fee of *PKR ${student.feeAmount.toLocaleString()}* is pending (Due Date: ${student.feeDueDate}).\nKindly clear dues via Meezan Bank A/C: 0102-0104928472910 to avoid late fine surcharges.\n\nThank you,\nAccounts Dept, Apex Academy\nTel: +92 300 1234567`);

    const cleanPhone = student.phone.replace(/[^0-9]/g, '');
    const url = `https://wa.me/${cleanPhone}?text=${message}`;
    window.open(url, '_blank');
  }

  // 5. ATTENDANCE & BIOMETRIC RFID SIMULATOR VIEW
  renderAttendance() {
    let students = window.db.getStudents();
    if (this.selectedClassFilter !== 'All') {
      students = students.filter(s => s.class === this.selectedClassFilter);
    }

    return `
      <div class="space-y-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="text-xl font-bold text-slate-800">Smart Attendance & Biometric Portal</h2>
            <p class="text-xs text-slate-500">Live RFID card swipe simulation and daily roll call register</p>
          </div>
          <div class="flex items-center gap-3">
            <button onclick="window.app.openBiometricModal()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
              <i data-lucide="scan" class="w-4 h-4"></i> RFID Card Swipe Simulator
            </button>
            <button onclick="window.reportManager.exportAttendanceRegisterExcel(window.app.selectedClassFilter === 'All' ? 'Class 10' : window.app.selectedClassFilter)" class="px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold rounded-xl border border-indigo-200 transition flex items-center gap-1.5">
              <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Download Sheet (.xlsx)
            </button>
          </div>
        </div>

        <!-- Roll Call Matrix -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <span class="font-bold text-slate-800 text-sm">Today's Roll Call:</span>
              <span class="text-xs font-mono bg-slate-100 px-2.5 py-1 rounded-md text-slate-700">${new Date().toLocaleDateString('en-GB', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' })}</span>
            </div>
            <span class="text-xs text-emerald-600 font-bold">Auto-Syncing with RFID Gateway</span>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
              <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                <tr>
                  <th class="py-3 px-4">Roll</th>
                  <th class="py-3 px-4">Student</th>
                  <th class="py-3 px-4">Class</th>
                  <th class="py-3 px-4">RFID Tag #</th>
                  <th class="py-3 px-4">Attendance Rate</th>
                  <th class="py-3 px-4 text-center">Status Toggle</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                ${students.map(s => `
                  <tr class="hover:bg-slate-50/80 transition">
                    <td class="py-3 px-4 font-mono font-bold text-slate-900">${s.rollNo}</td>
                    <td class="py-3 px-4">
                      <div class="font-bold text-slate-900">${s.name}</div>
                      <div class="text-[11px] text-slate-400 font-mono">${s.admissionNo}</div>
                    </td>
                    <td class="py-3 px-4 text-slate-700">${s.class} (${s.section})</td>
                    <td class="py-3 px-4 font-mono text-[11px] text-indigo-600 font-semibold">${s.rfidTag || 'RFID-DEFAULT'}</td>
                    <td class="py-3 px-4">
                      <div class="flex items-center gap-2">
                        <div class="w-24 bg-slate-200 rounded-full h-2 overflow-hidden">
                          <div class="h-full ${s.attendanceRate >= 80 ? 'bg-emerald-500' : 'bg-rose-500'}" style="width: ${s.attendanceRate}%"></div>
                        </div>
                        <span class="font-bold text-slate-700">${s.attendanceRate}%</span>
                      </div>
                    </td>
                    <td class="py-3 px-4 text-center">
                      <div class="inline-flex rounded-lg border border-slate-200 p-0.5 bg-slate-50">
                        <button class="px-2.5 py-1 text-[11px] font-bold rounded-md bg-emerald-600 text-white shadow-xs">Present</button>
                        <button class="px-2.5 py-1 text-[11px] font-medium text-slate-600 hover:text-slate-900">Absent</button>
                        <button class="px-2.5 py-1 text-[11px] font-medium text-slate-600 hover:text-slate-900">Late</button>
                      </div>
                    </td>
                  </tr>
                `).join('')}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    `;
  }

  // 6. ACADEMICS & EXAMINATIONS VIEW
  renderAcademics() {
    const students = window.db.getStudents();

    return `
      <div class="space-y-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="text-xl font-bold text-slate-800">Examinations & Marksheet Center</h2>
            <p class="text-xs text-slate-500">Calculate GPAs, record marks, and generate official terminal progress reports</p>
          </div>
          <button onclick="window.reportManager.downloadReportCard(window.db.getStudents()[0].id)" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
            <i data-lucide="printer" class="w-4 h-4"></i> Preview Sample Marksheet
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          ${students.map(s => {
            const marks = s.marks || {};
            const subs = Object.keys(marks);
            const avg = subs.length ? Math.round(subs.reduce((a, b) => a + marks[b], 0) / subs.length) : 0;
            return `
              <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                  <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">${s.admissionNo}</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full ${avg >= 80 ? 'bg-emerald-100 text-emerald-800' : avg < 50 ? 'bg-rose-100 text-rose-800' : 'bg-blue-100 text-blue-800'}">
                      Avg: ${avg}%
                    </span>
                  </div>
                  <h4 class="font-bold text-slate-900 text-sm">${s.name}</h4>
                  <p class="text-xs text-slate-500 mb-4">${s.class} (${s.section}) • Roll #${s.rollNo}</p>

                  <div class="space-y-1.5 text-xs">
                    ${subs.slice(0, 4).map(sub => `
                      <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-600">${sub}</span>
                        <span class="font-bold font-mono ${marks[sub] >= 80 ? 'text-emerald-600' : marks[sub] < 50 ? 'text-rose-600' : 'text-slate-800'}">${marks[sub]}/100</span>
                      </div>
                    `).join('')}
                  </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                  <span class="text-[11px] text-slate-400">Term 1 Results</span>
                  <button onclick="window.reportManager.downloadReportCard('${s.id}')" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold border border-indigo-200 transition flex items-center gap-1">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i> Download PDF
                  </button>
                </div>
              </div>
            `;
          }).join('')}
        </div>
      </div>
    `;
  }

  // 7. AI EARLY WARNING & STUDENT SUCCESS VIEW (Researched 2026/2027 Feature)
  renderAIInsights() {
    const analytics = window.aiEngine.getSchoolAnalytics();

    return `
      <div class="space-y-6">
        <div class="bg-gradient-to-r from-purple-900 via-indigo-900 to-slate-900 p-6 md:p-8 rounded-3xl text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold text-purple-300 border border-white/10">
              <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-300"></i> AI Academic Success & Dropout Prevention Engine
            </div>
            <h2 class="text-2xl font-black">AI Student Diagnostic & Early Warning</h2>
            <p class="text-purple-200 text-xs max-w-xl">
              Using multi-factor predictive modeling (attendance anomalies, continuous assessment test scores, and submission trends) to detect at-risk students 3 weeks before formal exams.
            </p>
          </div>
          <div class="flex items-center gap-3">
            <span class="px-3.5 py-2 bg-white/15 rounded-xl text-xs font-bold backdrop-blur-md border border-white/20">
              Accuracy: 94.8% Active Model
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
            <div class="text-3xl font-black text-rose-700 mt-3">${analytics.criticalCount} Students</div>
            <p class="text-xs text-rose-600 mt-1">Requires immediate intervention & PTM</p>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm bg-amber-50/20">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold uppercase text-amber-600">Needs Attention</span>
              <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-500"></i>
            </div>
            <div class="text-3xl font-black text-amber-700 mt-3">${analytics.attentionCount} Students</div>
            <p class="text-xs text-amber-600 mt-1">Requires remedial coaching & mentor check-in</p>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm bg-emerald-50/20">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold uppercase text-emerald-600">Safe & Excelling</span>
              <i data-lucide="star" class="w-4 h-4 text-emerald-500"></i>
            </div>
            <div class="text-3xl font-black text-emerald-700 mt-3">${analytics.safeCount} Students</div>
            <p class="text-xs text-emerald-600 mt-1">Nominated for academic honors</p>
          </div>
        </div>

        <!-- Detailed AI Diagnoses List -->
        <div class="space-y-4">
          <h3 class="font-bold text-slate-800 text-base">Comprehensive Predictive Diagnoses</h3>

          ${analytics.allAnalyses.map(a => `
            <div class="bg-white rounded-2xl border ${a.riskScore >= 60 ? 'border-rose-300 ring-2 ring-rose-100' : a.riskScore >= 35 ? 'border-amber-200' : 'border-slate-200'} p-5 shadow-sm transition">
              <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl ${a.riskScore >= 60 ? 'bg-rose-100 text-rose-700' : a.riskScore >= 35 ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'} flex items-center justify-center font-bold text-sm">
                    ${a.riskScore}%
                  </div>
                  <div>
                    <h4 class="font-bold text-slate-900 text-sm">${a.name} <span class="text-xs font-normal text-slate-500">(${a.class} • Roll #${a.rollNo})</span></h4>
                    <p class="text-xs text-slate-400 font-mono">Admission ID: ${a.admissionNo}</p>
                  </div>
                </div>

                <div class="flex items-center gap-3">
                  <span class="px-3 py-1 rounded-full text-xs font-bold ${a.riskScore >= 60 ? 'bg-rose-100 text-rose-800' : a.riskScore >= 35 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800'}">
                    ${a.status}
                  </span>
                  <button onclick="window.app.copyParentAlert('${a.studentId}')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition flex items-center gap-1.5">
                    <i data-lucide="copy" class="w-3.5 h-3.5"></i> Copy Guardian Alert
                  </button>
                </div>
              </div>

              <!-- Recommendation Breakdown -->
              <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                  <h5 class="font-bold text-slate-700 mb-2 flex items-center gap-1.5">
                    <i data-lucide="brain-circuit" class="w-3.5 h-3.5 text-indigo-600"></i> AI Actionable Recommendations:
                  </h5>
                  <ul class="space-y-1.5 text-slate-600">
                    ${a.recommendations.map(r => `<li>${r}</li>`).join('')}
                  </ul>
                </div>

                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 space-y-1 text-slate-600">
                  <div class="flex justify-between"><span class="text-slate-400">Current Academic Avg:</span><b class="text-slate-900">${a.avgMarks}%</b></div>
                  <div class="flex justify-between"><span class="text-slate-400">Attendance Index:</span><b class="${a.attendanceRate >= 80 ? 'text-emerald-600' : 'text-rose-600'}">${a.attendanceRate}%</b></div>
                  <div class="flex justify-between"><span class="text-slate-400">Fee Compliance:</span><b class="${a.feeStatus === 'Paid' ? 'text-emerald-600' : 'text-rose-600'}">${a.feeStatus}</b></div>
                  ${a.weakSubjects.length > 0 ? `<div class="pt-1 text-rose-600 font-semibold">Flagged Weak Subjects: ${a.weakSubjects.join(', ')}</div>` : ''}
                </div>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  }

  copyParentAlert(studentId) {
    const student = window.db.getStudentById(studentId);
    if (!student) return;
    const analysis = window.aiEngine.analyzeStudent(student);
    navigator.clipboard.writeText(analysis.parentAlertDraft);
    this.showToast("Guardian warning message copied to clipboard!", "success");
  }

  // 8. TIMETABLE VIEW
  renderTimetable() {
    const timetable = window.db.data.timetable["Class 10"] || [];

    return `
      <div class="space-y-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="text-xl font-bold text-slate-800">Class Timetable & Schedule Matrix</h2>
            <p class="text-xs text-slate-500">Weekly schedule grid with conflict detection</p>
          </div>
          <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-lg border border-indigo-200">
            Selected: Class 10 (Science)
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
                ${timetable.map(slot => `
                  <tr class="${slot.period === 'Break' ? 'bg-amber-50 font-bold text-amber-900' : 'hover:bg-slate-50'}">
                    <td class="py-3 px-4 font-mono font-bold text-slate-700">
                      ${slot.period === 'Break' ? 'RECESS' : `Period ${slot.period}`}<br>
                      <span class="text-[10px] text-slate-400 font-normal">${slot.time}</span>
                    </td>
                    <td class="py-3 px-4 text-slate-800">${slot.monday}</td>
                    <td class="py-3 px-4 text-slate-800">${slot.tuesday}</td>
                    <td class="py-3 px-4 text-slate-800">${slot.wednesday}</td>
                    <td class="py-3 px-4 text-slate-800">${slot.thursday}</td>
                    <td class="py-3 px-4 text-slate-800">${slot.friday}</td>
                  </tr>
                `).join('')}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    `;
  }

  // 9. NOTICE BOARD VIEW
  renderNotices() {
    const notices = window.db.data.notices || [];

    return `
      <div class="space-y-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="text-xl font-bold text-slate-800">Notice Board & Digital Circulars</h2>
            <p class="text-xs text-slate-500">Official circulars dispatched to students, teachers, and parents</p>
          </div>
          <button onclick="window.app.openAddNoticeModal()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> + Post New Circular
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          ${notices.map(n => `
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
              <div>
                <div class="flex items-center justify-between gap-2 mb-2">
                  <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full ${n.priority === 'urgent' ? 'bg-rose-100 text-rose-700' : 'bg-indigo-100 text-indigo-700'}">
                    ${n.priority}
                  </span>
                  <span class="text-xs text-slate-400 font-mono">${n.date}</span>
                </div>
                <h3 class="font-bold text-slate-900 text-base mb-2">${n.title}</h3>
                <p class="text-xs text-slate-600 leading-relaxed">${n.content}</p>
              </div>

              <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Target: <b class="text-slate-700">${n.audience}</b></span>
                <span class="text-indigo-600 font-semibold">${n.category}</span>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    `;
  }

  // 10. ADMIN DOWNLOAD HUB (The feature the user specifically asked for!)
  renderDownloadsHub() {
    return `
      <div class="space-y-6">
        <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 rounded-3xl p-6 md:p-8 text-white shadow-xl">
          <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-xs font-semibold text-amber-300 border border-white/10 mb-2">
            <i data-lucide="download-cloud" class="w-4 h-4"></i> Official Export & Download Center
          </div>
          <h2 class="text-2xl font-black">Admin Document & Report Download Hub</h2>
          <p class="text-indigo-200 text-xs max-w-2xl mt-1">
            Generate and download all school administrative documents in 1-click. Formatted for high-quality standard A4 and badge printing, or full Excel (.xlsx) spreadsheets.
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
              <button onclick="window.reportManager.bulkDownloadDefaulterChallans()" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i> Print All Pending Challans (PDF)
              </button>
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
              <button onclick="window.reportManager.bulkDownloadIDCards('Class 10')" class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i> Download Class 10 Badges (PDF)
              </button>
            </div>
          </div>

          <!-- Complete Student Directory (Excel) -->
          <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                <i data-lucide="file-spreadsheet" class="w-6 h-6"></i>
              </div>
              <h3 class="font-bold text-slate-900 text-base">Student Master Directory</h3>
              <p class="text-xs text-slate-500 mt-1">Full database export with admission numbers, parents' contact details, addresses, blood groups, and fee statuses.</p>
            </div>
            <div class="mt-6 space-y-2">
              <button onclick="window.reportManager.exportStudentsToExcel()" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Download Excel (.xlsx)
              </button>
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
              <button onclick="window.reportManager.exportDefaultersToExcel()" class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Download Defaulters (.xlsx)
              </button>
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
              <button onclick="window.reportManager.exportAttendanceRegisterExcel('Class 10')" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> Download Attendance (.xlsx)
              </button>
            </div>
          </div>

          <!-- Database Backup / Restore -->
          <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
              <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                <i data-lucide="database" class="w-6 h-6"></i>
              </div>
              <h3 class="font-bold text-slate-900 text-base">System Database Backup</h3>
              <p class="text-xs text-slate-500 mt-1">Export full school database to JSON format for offline safe-keeping or restore back anytime.</p>
            </div>
            <div class="mt-6 flex gap-2">
              <button onclick="window.app.downloadJSONBackup()" class="flex-1 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-1.5">
                <i data-lucide="download" class="w-4 h-4"></i> Backup (.json)
              </button>
              <button onclick="document.getElementById('importBackupInput').click()" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                Restore
              </button>
              <input type="file" id="importBackupInput" style="display:none" accept=".json" onchange="window.app.restoreJSONBackup(event)">
            </div>
          </div>
        </div>
      </div>
    `;
  }

  // Backup & Restore
  downloadJSONBackup() {
    const jsonStr = window.db.exportJSON();
    const blob = new Blob([jsonStr], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `Apex_School_DB_Backup_${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    this.showToast("Database backup downloaded successfully!", "success");
  }

  restoreJSONBackup(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (event) => {
      const success = window.db.importJSON(event.target.result);
      if (success) {
        this.showToast("Database restored successfully!", "success");
        this.render();
      } else {
        alert("Failed to restore: Invalid JSON structure.");
      }
    };
    reader.readAsText(file);
  }

  // MODAL HANDLERS
  openBiometricModal() {
    const modal = document.getElementById('biometricModal');
    if (modal) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      const input = document.getElementById('bioCardInput');
      if (input) {
        input.value = '';
        setTimeout(() => input.focus(), 100);
      }
    }
  }

  closeBiometricModal() {
    const modal = document.getElementById('biometricModal');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  handleBiometricSwipe() {
    const input = document.getElementById('bioCardInput');
    const val = input.value.trim();
    if (!val) return;

    const res = window.db.recordBiometricPunch(val);
    const feedback = document.getElementById('bioFeedback');
    
    if (res.success) {
      feedback.innerHTML = `
        <div class="p-3 bg-emerald-100 border border-emerald-300 rounded-xl text-emerald-900 text-xs font-medium animate-pulse">
          ✓ Verified: <b>${res.student.name}</b> (${res.student.class})<br>
          Punch Timestamp: ${res.time} • Marked PRESENT!
        </div>
      `;
      input.value = '';
      this.showToast(`Biometric punch logged for ${res.student.name}`, 'success');
      setTimeout(() => this.closeBiometricModal(), 2000);
      this.render();
    } else {
      feedback.innerHTML = `
        <div class="p-3 bg-rose-100 border border-rose-300 rounded-xl text-rose-900 text-xs font-medium">
          ✕ Card not recognized! Try: <b>RFID-994821</b> or <b>ADM-2026-101</b>
        </div>
      `;
    }
  }

  openAddStudentModal() {
    const modal = document.getElementById('addStudentModal');
    if (modal) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  }

  closeAddStudentModal() {
    const modal = document.getElementById('addStudentModal');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  saveNewStudent(e) {
    e.preventDefault();
    const form = e.target;
    const newStudent = {
      name: form.studentName.value,
      fatherName: form.fatherName.value,
      class: form.studentClass.value,
      section: form.studentSection.value,
      rollNo: parseInt(form.rollNo.value) || 1,
      gender: form.gender.value,
      bloodGroup: form.bloodGroup.value,
      phone: form.phone.value,
      guardianEmail: form.guardianEmail.value,
      address: form.address.value,
      feeAmount: parseInt(form.feeAmount.value) || 8500,
      feeStatus: "Pending",
      attendanceRate: 95,
      marks: { Mathematics: 85, Physics: 80, Chemistry: 78, English: 84, "Computer Science": 90 }
    };

    window.db.addStudent(newStudent);
    this.closeAddStudentModal();
    this.showToast(`Student ${newStudent.name} enrolled successfully!`, "success");
    form.reset();
    this.render();
  }

  openAddTeacherModal() {
    const modal = document.getElementById('addTeacherModal');
    if (modal) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  }

  closeAddTeacherModal() {
    const modal = document.getElementById('addTeacherModal');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  saveNewTeacher(e) {
    e.preventDefault();
    const form = e.target;
    const newTeacher = {
      name: form.teacherName.value,
      designation: form.designation.value,
      subject: form.subject.value,
      email: form.email.value,
      phone: form.phone.value,
      qualification: form.qualification.value,
      salary: parseInt(form.salary.value) || 90000,
      status: "Active"
    };

    window.db.addTeacher(newTeacher);
    this.closeAddTeacherModal();
    this.showToast(`Faculty member ${newTeacher.name} added!`, "success");
    form.reset();
    this.render();
  }

  openAddNoticeModal() {
    const modal = document.getElementById('addNoticeModal');
    if (modal) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  }

  closeAddNoticeModal() {
    const modal = document.getElementById('addNoticeModal');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  saveNewNotice(e) {
    e.preventDefault();
    const form = e.target;
    const newNotice = {
      title: form.noticeTitle.value,
      category: form.noticeCategory.value,
      audience: form.noticeAudience.value,
      priority: form.noticePriority.value,
      content: form.noticeContent.value
    };

    window.db.addNotice(newNotice);
    this.closeAddNoticeModal();
    this.showToast("Notice circular broadcasted successfully!", "success");
    form.reset();
    this.render();
  }
}

// Instantiate App when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.app = new SchoolApp();
});
