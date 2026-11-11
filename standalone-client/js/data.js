/**
 * Apex International Academy - School Management System
 * Core Data Store & LocalStorage Manager
 */

const STORAGE_KEY = 'APEX_SMS_DATABASE_V1';

const defaultSchoolProfile = {
  name: "Apex International Academy",
  tagline: "Excellence in Education, Leadership & Innovation",
  regNo: "REG-EDU-2026-9812",
  phone: "+92 300 1234567 / +92 51 9876543",
  email: "admissions@apexacademy.edu",
  website: "www.apexacademy.edu",
  address: "Sector F-10/4, Academic Avenue, Islamabad, Pakistan",
  principal: "Dr. Farhan Qureshi (Ph.D. Education)",
  bankName: "Meezan Bank Ltd",
  bankAccountTitle: "Apex International Academy Collection",
  bankAccountNumber: "0102-0104928472910",
  currentTerm: "Academic Session 2026-2027 (Term 1)",
  logo: "https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&w=120&h=120&q=80"
};

const defaultClasses = [
  { id: "C6A", name: "Class 6", section: "A", classTeacher: "Ms. Fatima Zahra", room: "Room 101", studentCapacity: 30 },
  { id: "C7A", name: "Class 7", section: "A", classTeacher: "Sir Kamran Tariq", room: "Room 102", studentCapacity: 30 },
  { id: "C8A", name: "Class 8", section: "A", classTeacher: "Ms. Ayesha Siddiqui", room: "Room 103", studentCapacity: 30 },
  { id: "C9A", name: "Class 9", section: "Science", classTeacher: "Sir Bilal Ahmed", room: "Room 201", studentCapacity: 35 },
  { id: "C10A", name: "Class 10", section: "Science", classTeacher: "Dr. Tariq Mahmood", room: "Room 202", studentCapacity: 35 },
  { id: "C11A", name: "Class 11", section: "Pre-Engineering", classTeacher: "Prof. Nida Parveen", room: "Room 301", studentCapacity: 40 }
];

const defaultTeachers = [
  { id: "T-01", name: "Dr. Tariq Mahmood", designation: "Head of Sciences & Physics Lead", email: "tariq.m@apexacademy.edu", phone: "+92 301 5551010", subject: "Physics", qualification: "Ph.D. Applied Physics", joinDate: "2021-08-15", salary: 125000, status: "Active", avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&h=150&q=80" },
  { id: "T-02", name: "Ms. Fatima Zahra", designation: "Senior Mathematics Lecturer", email: "fatima.z@apexacademy.edu", phone: "+92 302 5551020", subject: "Mathematics", qualification: "M.Sc. Pure Mathematics", joinDate: "2022-01-10", salary: 95000, status: "Active", avatar: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&h=150&q=80" },
  { id: "T-03", name: "Sir Bilal Ahmed", designation: "Computer Science & Robotics Instructor", email: "bilal.a@apexacademy.edu", phone: "+92 303 5551030", subject: "Computer Science", qualification: "MS Computer Science", joinDate: "2023-04-01", salary: 110000, status: "Active", avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80" },
  { id: "T-04", name: "Ms. Ayesha Siddiqui", designation: "English Literature & Communication Lead", email: "ayesha.s@apexacademy.edu", phone: "+92 304 5551040", subject: "English", qualification: "M.Phil English Literature", joinDate: "2020-09-01", salary: 98000, status: "Active", avatar: "https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=150&h=150&q=80" },
  { id: "T-05", name: "Sir Kamran Tariq", designation: "Chemistry Faculty", email: "kamran.t@apexacademy.edu", phone: "+92 305 5551050", subject: "Chemistry", qualification: "M.Sc. Organic Chemistry", joinDate: "2022-06-15", salary: 88000, status: "Active", avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&h=150&q=80" },
  { id: "T-06", name: "Prof. Nida Parveen", designation: "Biology & Life Sciences Chair", email: "nida.p@apexacademy.edu", phone: "+92 306 5551060", subject: "Biology", qualification: "M.Phil Biotechnology", joinDate: "2021-02-10", salary: 105000, status: "Active", avatar: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80" },
  { id: "T-07", name: "Qari Usman Khalid", designation: "Islamic Studies & Ethics Teacher", email: "usman.k@apexacademy.edu", phone: "+92 307 5551070", subject: "Islamic Studies", qualification: "M.A Islamic Studies, Wifaq-ul-Madaris", joinDate: "2019-10-15", salary: 75000, status: "Active", avatar: "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=150&h=150&q=80" },
  { id: "T-08", name: "Mr. Zain Haider", designation: "Director of Physical Education & Sports", email: "zain.h@apexacademy.edu", phone: "+92 308 5551080", subject: "Physical Education", qualification: "BS Sports Sciences", joinDate: "2023-08-01", salary: 70000, status: "Active", avatar: "https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=150&h=150&q=80" }
];

const defaultStudents = [
  {
    id: "STU-001",
    admissionNo: "ADM-2026-101",
    name: "Muhammad Hamza Khan",
    fatherName: "Tariq Jamil Khan",
    class: "Class 10",
    section: "Science",
    rollNo: 1,
    gender: "Male",
    dob: "2010-04-12",
    bloodGroup: "B+",
    phone: "+92 321 4455661",
    guardianEmail: "tariq.khan77@gmail.com",
    address: "House 14-B, Street 9, Sector G-9/2, Islamabad",
    avatar: "https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 96,
    feeStatus: "Paid",
    feeAmount: 9500,
    feeDueDate: "2026-11-15",
    paidDate: "2026-11-03",
    marks: { Mathematics: 94, Physics: 91, Chemistry: 88, English: 89, "Computer Science": 96 },
    rfidTag: "RFID-994821"
  },
  {
    id: "STU-002",
    admissionNo: "ADM-2026-102",
    name: "Zainab Fatima",
    fatherName: "Rashid Minhas",
    class: "Class 10",
    section: "Science",
    rollNo: 2,
    gender: "Female",
    dob: "2010-09-21",
    bloodGroup: "O+",
    phone: "+92 333 7788992",
    guardianEmail: "rashid.minhas@corporate.pk",
    address: "Apartment 402, Executive Heights, F-11, Islamabad",
    avatar: "https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 98,
    feeStatus: "Paid",
    feeAmount: 9500,
    feeDueDate: "2026-11-15",
    paidDate: "2026-11-02",
    marks: { Mathematics: 98, Physics: 95, Chemistry: 96, English: 92, "Computer Science": 99 },
    rfidTag: "RFID-994822"
  },
  {
    id: "STU-003",
    admissionNo: "ADM-2026-103",
    name: "Abdullah Sheikh",
    fatherName: "Sheikh Salman",
    class: "Class 10",
    section: "Science",
    rollNo: 3,
    gender: "Male",
    dob: "2010-01-15",
    bloodGroup: "A+",
    phone: "+92 312 9988771",
    guardianEmail: "sheikh.salman@tradegroup.com",
    address: "Villa 8, Blue Area, Islamabad",
    avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 64, // Flagged for AI At-Risk alert!
    feeStatus: "Overdue",
    feeAmount: 9500,
    feeDueDate: "2026-10-25",
    paidDate: null,
    marks: { Mathematics: 42, Physics: 48, Chemistry: 39, English: 58, "Computer Science": 45 },
    rfidTag: "RFID-994823"
  },
  {
    id: "STU-004",
    admissionNo: "ADM-2026-104",
    name: "Aiman Noor",
    fatherName: "Noor ul Hassan",
    class: "Class 9",
    section: "Science",
    rollNo: 1,
    gender: "Female",
    dob: "2011-06-30",
    bloodGroup: "AB+",
    phone: "+92 345 1122334",
    guardianEmail: "noorulhassan@outlook.com",
    address: "Street 22, Sector I-8/3, Islamabad",
    avatar: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 91,
    feeStatus: "Pending",
    feeAmount: 9000,
    feeDueDate: "2026-11-20",
    paidDate: null,
    marks: { Mathematics: 85, Physics: 82, Chemistry: 80, English: 88, "Computer Science": 90 },
    rfidTag: "RFID-994824"
  },
  {
    id: "STU-005",
    admissionNo: "ADM-2026-105",
    name: "Syed Daniyal Ali",
    fatherName: "Syed Mansoor Ali",
    class: "Class 9",
    section: "Science",
    rollNo: 2,
    gender: "Male",
    dob: "2011-11-05",
    bloodGroup: "O-",
    phone: "+92 300 8877665",
    guardianEmail: "smansoor.ali@gov.pk",
    address: "House 301, Sector G-10/2, Islamabad",
    avatar: "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 88,
    feeStatus: "Paid",
    feeAmount: 9000,
    feeDueDate: "2026-11-15",
    paidDate: "2026-11-05",
    marks: { Mathematics: 79, Physics: 75, Chemistry: 72, English: 84, "Computer Science": 82 },
    rfidTag: "RFID-994825"
  },
  {
    id: "STU-006",
    admissionNo: "ADM-2026-106",
    name: "Eman Raza",
    fatherName: "Raza Muhammad",
    class: "Class 8",
    section: "A",
    rollNo: 1,
    gender: "Female",
    dob: "2012-03-14",
    bloodGroup: "B-",
    phone: "+92 313 4433221",
    guardianEmail: "raza.m@gmail.com",
    address: "Lane 5, Gulberg Greens, Islamabad",
    avatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 95,
    feeStatus: "Paid",
    feeAmount: 8500,
    feeDueDate: "2026-11-15",
    paidDate: "2026-11-01",
    marks: { Mathematics: 91, English: 90, "General Science": 93, "Computer Science": 95, Urdu: 87 },
    rfidTag: "RFID-994826"
  },
  {
    id: "STU-007",
    admissionNo: "ADM-2026-107",
    name: "Bilal Haider",
    fatherName: "Zulqarnain Haider",
    class: "Class 8",
    section: "A",
    rollNo: 2,
    gender: "Male",
    dob: "2012-08-25",
    bloodGroup: "A+",
    phone: "+92 322 6655443",
    guardianEmail: "z.haider@engro.com",
    address: "Sector F-7/1, Street 18, House 7, Islamabad",
    avatar: "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 71, // Flagged for AI Alert!
    feeStatus: "Overdue",
    feeAmount: 8500,
    feeDueDate: "2026-10-20",
    paidDate: null,
    marks: { Mathematics: 45, English: 52, "General Science": 49, "Computer Science": 61, Urdu: 55 },
    rfidTag: "RFID-994827"
  },
  {
    id: "STU-008",
    admissionNo: "ADM-2026-108",
    name: "Maryam Jahangir",
    fatherName: "Jahangir Badar",
    class: "Class 7",
    section: "A",
    rollNo: 1,
    gender: "Female",
    dob: "2013-05-18",
    bloodGroup: "O+",
    phone: "+92 334 8899001",
    guardianEmail: "jahangir.b@techsoft.pk",
    address: "Phase 4, Bahria Town, Islamabad",
    avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 97,
    feeStatus: "Paid",
    feeAmount: 8000,
    feeDueDate: "2026-11-15",
    paidDate: "2026-11-04",
    marks: { Mathematics: 96, English: 94, "General Science": 92, "Computer Science": 98, Urdu: 90 },
    rfidTag: "RFID-994828"
  },
  {
    id: "STU-009",
    admissionNo: "ADM-2026-109",
    name: "Rayyan Mustafa",
    fatherName: "Mustafa Kamal",
    class: "Class 7",
    section: "A",
    rollNo: 2,
    gender: "Male",
    dob: "2013-10-10",
    bloodGroup: "B+",
    phone: "+92 301 9988112",
    guardianEmail: "mkamal.arch@gmail.com",
    address: "Sector E-11/3, Multi Residencia, Islamabad",
    avatar: "https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 85,
    feeStatus: "Pending",
    feeAmount: 8000,
    feeDueDate: "2026-11-20",
    paidDate: null,
    marks: { Mathematics: 78, English: 81, "General Science": 75, "Computer Science": 80, Urdu: 73 },
    rfidTag: "RFID-994829"
  },
  {
    id: "STU-010",
    admissionNo: "ADM-2026-110",
    name: "Khadija Asif",
    fatherName: "Asif Mehmood",
    class: "Class 6",
    section: "A",
    rollNo: 1,
    gender: "Female",
    dob: "2014-02-28",
    bloodGroup: "A-",
    phone: "+92 346 5544332",
    guardianEmail: "asif.m@consultancy.com",
    address: "Block C, DHA Phase 2, Islamabad",
    avatar: "https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 93,
    feeStatus: "Paid",
    feeAmount: 7500,
    feeDueDate: "2026-11-15",
    paidDate: "2026-11-06",
    marks: { Mathematics: 88, English: 92, "General Science": 86, "Computer Science": 91, Urdu: 85 },
    rfidTag: "RFID-994830"
  },
  {
    id: "STU-011",
    admissionNo: "ADM-2026-111",
    name: "Ahmed Hassan",
    fatherName: "Dr. Hassan Baig",
    class: "Class 11",
    section: "Pre-Engineering",
    rollNo: 1,
    gender: "Male",
    dob: "2009-07-19",
    bloodGroup: "O+",
    phone: "+92 300 2345678",
    guardianEmail: "hassan.baig@hospital.pk",
    address: "House 29, Street 15, F-8/2, Islamabad",
    avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 94,
    feeStatus: "Paid",
    feeAmount: 11500,
    feeDueDate: "2026-11-15",
    paidDate: "2026-11-02",
    marks: { Mathematics: 92, Physics: 89, Chemistry: 91, English: 85, "Computer Science": 97 },
    rfidTag: "RFID-994831"
  },
  {
    id: "STU-012",
    admissionNo: "ADM-2026-112",
    name: "Mahnoor Shah",
    fatherName: "Shahid Ali Shah",
    class: "Class 11",
    section: "Pre-Engineering",
    rollNo: 2,
    gender: "Female",
    dob: "2009-12-04",
    bloodGroup: "B+",
    phone: "+92 333 5544778",
    guardianEmail: "shahid.ali@energycorp.com",
    address: "Villa 41, Park View City, Islamabad",
    avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&h=150&q=80",
    attendanceRate: 68, // Flagged for AI Alert!
    feeStatus: "Overdue",
    feeAmount: 11500,
    feeDueDate: "2026-10-20",
    paidDate: null,
    marks: { Mathematics: 48, Physics: 51, Chemistry: 42, English: 60, "Computer Science": 55 },
    rfidTag: "RFID-994832"
  }
];

const defaultNotices = [
  {
    id: "NOT-01",
    title: "Annual Sports Gala & Track Competitions 2026",
    category: "Events",
    audience: "All",
    priority: "high",
    date: "2026-11-10",
    content: "The Annual Sports Gala will commence on Friday, November 28, 2026. All students are invited to register for track & field, basketball, and table tennis through their class teachers by Nov 20."
  },
  {
    id: "NOT-02",
    title: "Mid-Term Examination Result & Parent-Teacher Conference",
    category: "Academics",
    audience: "Parents",
    priority: "urgent",
    date: "2026-11-08",
    content: "Parent-Teacher Meeting (PTM) for Term 1 will be held on Saturday, November 22 from 9:00 AM to 2:00 PM. Detailed progress reports and teacher feedback will be handed over to parents."
  },
  {
    id: "NOT-03",
    title: "November Tuition Fee Submission Deadline",
    category: "Finance",
    audience: "Parents",
    priority: "urgent",
    date: "2026-11-05",
    content: "Parents are gently reminded that the deadline for November 2026 tuition fees is November 15, 2026. Avoid late fee surcharges by paying via Meezan Bank online or at the school accounts desk."
  },
  {
    id: "NOT-04",
    title: "Robotics & AI Innovation Club Registration Open",
    category: "Club",
    audience: "Students",
    priority: "normal",
    date: "2026-11-02",
    content: "Our newly equipped STEM lab is launching hands-on Arduino, Python, and AI workshops every Wednesday afternoon. Contact Sir Bilal Ahmed for registration."
  }
];

const defaultTimetable = {
  "Class 10": [
    { period: 1, time: "08:00 - 08:50", monday: "Mathematics (Ms. Fatima)", tuesday: "Physics (Dr. Tariq)", wednesday: "Chemistry (Sir Kamran)", thursday: "Mathematics (Ms. Fatima)", friday: "Computer Science (Sir Bilal)" },
    { period: 2, time: "08:50 - 09:40", monday: "Physics (Dr. Tariq)", tuesday: "Mathematics (Ms. Fatima)", wednesday: "English (Ms. Ayesha)", thursday: "Chemistry (Sir Kamran)", friday: "Physics Lab (Dr. Tariq)" },
    { period: 3, time: "09:40 - 10:30", monday: "Chemistry (Sir Kamran)", tuesday: "English (Ms. Ayesha)", wednesday: "Mathematics (Ms. Fatima)", thursday: "Computer Science (Sir Bilal)", friday: "Islamic Studies (Qari Usman)" },
    { period: "Break", time: "10:30 - 11:00", monday: "Recess / Snack", tuesday: "Recess / Snack", wednesday: "Recess / Snack", thursday: "Recess / Snack", friday: "Recess / Snack" },
    { period: 4, time: "11:00 - 11:50", monday: "Computer Science (Sir Bilal)", tuesday: "Islamic Studies (Qari Usman)", wednesday: "Physics (Dr. Tariq)", thursday: "English (Ms. Ayesha)", friday: "Mathematics (Ms. Fatima)" },
    { period: 5, time: "11:50 - 12:40", monday: "English (Ms. Ayesha)", tuesday: "Chemistry Lab (Sir Kamran)", wednesday: "Physical Edu (Mr. Zain)", thursday: "Physics (Dr. Tariq)", friday: "Library / Mentoring" }
  ]
};

// Initialize or Load Database from LocalStorage
class DataManager {
  constructor() {
    this.data = this.load();
  }

  load() {
    try {
      const stored = localStorage.getItem(STORAGE_KEY);
      if (stored) {
        return JSON.parse(stored);
      }
    } catch (e) {
      console.warn("Could not load from localStorage, falling back to defaults.", e);
    }
    const initial = {
      profile: defaultSchoolProfile,
      classes: defaultClasses,
      teachers: defaultTeachers,
      students: defaultStudents,
      notices: defaultNotices,
      timetable: defaultTimetable,
      recentActivity: [
        { id: 1, type: "fee", message: "Fee payment of PKR 9,500 received for Muhammad Hamza (Class 10)", time: "10 mins ago" },
        { id: 2, type: "attendance", message: "Biometric morning attendance logged: 94.2% present", time: "1 hour ago" },
        { id: 3, type: "academic", message: "Midterm grades finalized for Class 10 Physics", time: "3 hours ago" },
        { id: 4, type: "notice", message: "New circular published: Annual Sports Gala 2026", time: "1 day ago" }
      ]
    };
    this.save(initial);
    return initial;
  }

  save(dataToSave = null) {
    if (dataToSave) this.data = dataToSave;
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(this.data));
    } catch (e) {
      console.error("Failed to save to localStorage", e);
    }
  }

  resetToDefaults() {
    localStorage.removeItem(STORAGE_KEY);
    this.data = this.load();
    return this.data;
  }

  // Student Methods
  getStudents() {
    return this.data.students || [];
  }

  getStudentById(id) {
    return this.data.students.find(s => s.id === id || s.admissionNo === id);
  }

  addStudent(student) {
    student.id = "STU-" + String(this.data.students.length + 1).padStart(3, '0');
    student.admissionNo = "ADM-2026-" + (100 + this.data.students.length + 1);
    if (!student.avatar) {
      student.avatar = student.gender === "Female" 
        ? "https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80"
        : "https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150&q=80";
    }
    this.data.students.unshift(student);
    this.logActivity("student", `New student enrolled: ${student.name} in ${student.class}`);
    this.save();
    return student;
  }

  updateStudent(id, updatedFields) {
    const idx = this.data.students.findIndex(s => s.id === id);
    if (idx !== -1) {
      this.data.students[idx] = { ...this.data.students[idx], ...updatedFields };
      this.save();
      return this.data.students[idx];
    }
    return null;
  }

  deleteStudent(id) {
    const student = this.getStudentById(id);
    this.data.students = this.data.students.filter(s => s.id !== id);
    if (student) {
      this.logActivity("student", `Student record removed: ${student.name}`);
    }
    this.save();
  }

  // Teacher Methods
  getTeachers() {
    return this.data.teachers || [];
  }

  addTeacher(teacher) {
    teacher.id = "T-" + String(this.data.teachers.length + 1).padStart(2, '0');
    if (!teacher.avatar) {
      teacher.avatar = "https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=150&h=150&q=80";
    }
    this.data.teachers.push(teacher);
    this.logActivity("teacher", `New faculty member joined: ${teacher.name} (${teacher.subject})`);
    this.save();
    return teacher;
  }

  // Fee Methods
  markFeePaid(studentId, paymentMethod = "Bank Deposit / Online") {
    const student = this.getStudentById(studentId);
    if (student) {
      student.feeStatus = "Paid";
      student.paidDate = new Date().toISOString().split('T')[0];
      student.paymentMethod = paymentMethod;
      this.logActivity("fee", `Payment of PKR ${student.feeAmount.toLocaleString()} recorded for ${student.name}`);
      this.save();
      return true;
    }
    return false;
  }

  // Attendance Simulation
  recordBiometricPunch(tagOrAdmissionNo) {
    const student = this.data.students.find(s => s.rfidTag === tagOrAdmissionNo || s.admissionNo === tagOrAdmissionNo || s.id === tagOrAdmissionNo);
    if (student) {
      const now = new Date();
      const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
      this.logActivity("attendance", `Biometric Punch-In verified: ${student.name} (${student.class}) at ${timeStr}`);
      return { success: true, student, time: timeStr };
    }
    return { success: false, message: "Tag/Card not found in student database!" };
  }

  // Notice Methods
  addNotice(notice) {
    notice.id = "NOT-" + String(this.data.notices.length + 1).padStart(2, '0');
    notice.date = new Date().toISOString().split('T')[0];
    this.data.notices.unshift(notice);
    this.logActivity("notice", `Notice published: "${notice.title}"`);
    this.save();
    return notice;
  }

  // Activity Log
  logActivity(type, message) {
    if (!this.data.recentActivity) this.data.recentActivity = [];
    this.data.recentActivity.unshift({
      id: Date.now(),
      type,
      message,
      time: "Just now"
    });
    if (this.data.recentActivity.length > 20) {
      this.data.recentActivity.pop();
    }
    this.save();
  }

  // Export full JSON Backup
  exportJSON() {
    return JSON.stringify(this.data, null, 2);
  }

  // Import JSON Backup
  importJSON(jsonString) {
    try {
      const parsed = JSON.parse(jsonString);
      if (parsed.students && parsed.teachers) {
        this.data = parsed;
        this.save();
        return true;
      }
      return false;
    } catch (e) {
      console.error("Invalid JSON format", e);
      return false;
    }
  }
}

// Global data manager instance
window.db = new DataManager();
