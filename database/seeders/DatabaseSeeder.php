<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Notice;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Classes
        $classes = [
            ['name' => 'Class 6', 'section' => 'A', 'class_teacher' => 'Ms. Fatima Zahra', 'room' => 'Room 101', 'student_capacity' => 30],
            ['name' => 'Class 7', 'section' => 'A', 'class_teacher' => 'Sir Kamran Tariq', 'room' => 'Room 102', 'student_capacity' => 30],
            ['name' => 'Class 8', 'section' => 'A', 'class_teacher' => 'Ms. Ayesha Siddiqui', 'room' => 'Room 103', 'student_capacity' => 30],
            ['name' => 'Class 9', 'section' => 'Science', 'class_teacher' => 'Sir Bilal Ahmed', 'room' => 'Room 201', 'student_capacity' => 35],
            ['name' => 'Class 10', 'section' => 'Science', 'class_teacher' => 'Dr. Tariq Mahmood', 'room' => 'Room 202', 'student_capacity' => 35],
            ['name' => 'Class 11', 'section' => 'Pre-Engineering', 'class_teacher' => 'Prof. Nida Parveen', 'room' => 'Room 301', 'student_capacity' => 40],
        ];
        foreach ($classes as $c) {
            SchoolClass::create($c);
        }

        // 2. Teachers
        $teachers = [
            ['teacher_id' => 'T-01', 'name' => 'Dr. Tariq Mahmood', 'designation' => 'Head of Sciences & Physics Lead', 'email' => 'tariq.m@crescentschool.edu.pk', 'phone' => '+92 301 5551010', 'subject' => 'Physics', 'qualification' => 'Ph.D. Applied Physics', 'join_date' => '2021-08-15', 'salary' => 125000, 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&h=150&q=80'],
            ['teacher_id' => 'T-02', 'name' => 'Ms. Fatima Zahra', 'designation' => 'Senior Mathematics Lecturer', 'email' => 'fatima.z@crescentschool.edu.pk', 'phone' => '+92 302 5551020', 'subject' => 'Mathematics', 'qualification' => 'M.Sc. Pure Mathematics', 'join_date' => '2022-01-10', 'salary' => 95000, 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&h=150&q=80'],
            ['teacher_id' => 'T-03', 'name' => 'Sir Bilal Ahmed', 'designation' => 'Computer Science & Robotics Instructor', 'email' => 'bilal.a@crescentschool.edu.pk', 'phone' => '+92 303 5551030', 'subject' => 'Computer Science', 'qualification' => 'MS Computer Science', 'join_date' => '2023-04-01', 'salary' => 110000, 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80'],
            ['teacher_id' => 'T-04', 'name' => 'Ms. Ayesha Siddiqui', 'designation' => 'English Literature Lead', 'email' => 'ayesha.s@crescentschool.edu.pk', 'phone' => '+92 304 5551040', 'subject' => 'English', 'qualification' => 'M.Phil English Literature', 'join_date' => '2020-09-01', 'salary' => 98000, 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=150&h=150&q=80'],
            ['teacher_id' => 'T-05', 'name' => 'Sir Kamran Tariq', 'designation' => 'Chemistry Faculty', 'email' => 'kamran.t@crescentschool.edu.pk', 'phone' => '+92 305 5551050', 'subject' => 'Chemistry', 'qualification' => 'M.Sc. Organic Chemistry', 'join_date' => '2022-06-15', 'salary' => 88000, 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&h=150&q=80'],
            ['teacher_id' => 'T-06', 'name' => 'Prof. Nida Parveen', 'designation' => 'Biology & Life Sciences Chair', 'email' => 'nida.p@crescentschool.edu.pk', 'phone' => '+92 306 5551060', 'subject' => 'Biology', 'qualification' => 'M.Phil Biotechnology', 'join_date' => '2021-02-10', 'salary' => 105000, 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80'],
            ['teacher_id' => 'T-07', 'name' => 'Qari Usman Khalid', 'designation' => 'Islamic Studies Teacher', 'email' => 'usman.k@crescentschool.edu.pk', 'phone' => '+92 307 5551070', 'subject' => 'Islamic Studies', 'qualification' => 'M.A Islamic Studies', 'join_date' => '2019-10-15', 'salary' => 75000, 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=150&h=150&q=80'],
            ['teacher_id' => 'T-08', 'name' => 'Mr. Zain Haider', 'designation' => 'Sports Director', 'email' => 'zain.h@crescentschool.edu.pk', 'phone' => '+92 308 5551080', 'subject' => 'Physical Education', 'qualification' => 'BS Sports Sciences', 'join_date' => '2023-08-01', 'salary' => 70000, 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=150&h=150&q=80']
        ];
        foreach ($teachers as $t) {
            Teacher::create($t);
        }

        // 3. Students
        $students = [
            [
                'student_code' => 'STU-001',
                'admission_no' => 'ADM-2026-101',
                'name' => 'Muhammad Hamza Khan',
                'father_name' => 'Tariq Jamil Khan',
                'class_name' => 'Class 10',
                'section' => 'Science',
                'roll_no' => 1,
                'gender' => 'Male',
                'dob' => '2010-04-12',
                'blood_group' => 'B+',
                'phone' => '+92 321 4455661',
                'guardian_email' => 'tariq.khan77@gmail.com',
                'address' => 'House 14-B, Street 9, Sector G-9/2, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 96,
                'fee_status' => 'Paid',
                'fee_amount' => 9500,
                'fee_due_date' => '2026-11-15',
                'paid_date' => '2026-11-03',
                'payment_method' => 'Online Bank Transfer',
                'rfid_tag' => 'RFID-994821',
                'marks' => ['Mathematics' => 94, 'Physics' => 91, 'Chemistry' => 88, 'English' => 89, 'Computer Science' => 96],
            ],
            [
                'student_code' => 'STU-002',
                'admission_no' => 'ADM-2026-102',
                'name' => 'Zainab Fatima',
                'father_name' => 'Rashid Minhas',
                'class_name' => 'Class 10',
                'section' => 'Science',
                'roll_no' => 2,
                'gender' => 'Female',
                'dob' => '2010-09-21',
                'blood_group' => 'O+',
                'phone' => '+92 333 7788992',
                'guardian_email' => 'rashid.minhas@corporate.pk',
                'address' => 'Apartment 402, Executive Heights, F-11, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 98,
                'fee_status' => 'Paid',
                'fee_amount' => 9500,
                'fee_due_date' => '2026-11-15',
                'paid_date' => '2026-11-02',
                'payment_method' => 'Meezan Bank Deposit',
                'rfid_tag' => 'RFID-994822',
                'marks' => ['Mathematics' => 98, 'Physics' => 95, 'Chemistry' => 96, 'English' => 92, 'Computer Science' => 99],
            ],
            [
                'student_code' => 'STU-003',
                'admission_no' => 'ADM-2026-103',
                'name' => 'Abdullah Sheikh',
                'father_name' => 'Sheikh Salman',
                'class_name' => 'Class 10',
                'section' => 'Science',
                'roll_no' => 3,
                'gender' => 'Male',
                'dob' => '2010-01-15',
                'blood_group' => 'A+',
                'phone' => '+92 312 9988771',
                'guardian_email' => 'sheikh.salman@tradegroup.com',
                'address' => 'Villa 8, Blue Area, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 64, // Flagged for AI Alert
                'fee_status' => 'Overdue',
                'fee_amount' => 9500,
                'fee_due_date' => '2026-10-25',
                'paid_date' => null,
                'payment_method' => null,
                'rfid_tag' => 'RFID-994823',
                'marks' => ['Mathematics' => 42, 'Physics' => 48, 'Chemistry' => 39, 'English' => 58, 'Computer Science' => 45],
            ],
            [
                'student_code' => 'STU-004',
                'admission_no' => 'ADM-2026-104',
                'name' => 'Aiman Noor',
                'father_name' => 'Noor ul Hassan',
                'class_name' => 'Class 9',
                'section' => 'Science',
                'roll_no' => 1,
                'gender' => 'Female',
                'dob' => '2011-06-30',
                'blood_group' => 'AB+',
                'phone' => '+92 345 1122334',
                'guardian_email' => 'noorulhassan@outlook.com',
                'address' => 'Street 22, Sector I-8/3, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 91,
                'fee_status' => 'Pending',
                'fee_amount' => 9000,
                'fee_due_date' => '2026-11-20',
                'paid_date' => null,
                'payment_method' => null,
                'rfid_tag' => 'RFID-994824',
                'marks' => ['Mathematics' => 85, 'Physics' => 82, 'Chemistry' => 80, 'English' => 88, 'Computer Science' => 90],
            ],
            [
                'student_code' => 'STU-005',
                'admission_no' => 'ADM-2026-105',
                'name' => 'Syed Daniyal Ali',
                'father_name' => 'Syed Mansoor Ali',
                'class_name' => 'Class 9',
                'section' => 'Science',
                'roll_no' => 2,
                'gender' => 'Male',
                'dob' => '2011-11-05',
                'blood_group' => 'O-',
                'phone' => '+92 300 8877665',
                'guardian_email' => 'smansoor.ali@gov.pk',
                'address' => 'House 301, Sector G-10/2, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 88,
                'fee_status' => 'Paid',
                'fee_amount' => 9000,
                'fee_due_date' => '2026-11-15',
                'paid_date' => '2026-11-05',
                'payment_method' => 'Cash Counter',
                'rfid_tag' => 'RFID-994825',
                'marks' => ['Mathematics' => 79, 'Physics' => 75, 'Chemistry' => 72, 'English' => 84, 'Computer Science' => 82],
            ],
            [
                'student_code' => 'STU-006',
                'admission_no' => 'ADM-2026-106',
                'name' => 'Eman Raza',
                'father_name' => 'Raza Muhammad',
                'class_name' => 'Class 8',
                'section' => 'A',
                'roll_no' => 1,
                'gender' => 'Female',
                'dob' => '2012-03-14',
                'blood_group' => 'B-',
                'phone' => '+92 313 4433221',
                'guardian_email' => 'raza.m@gmail.com',
                'address' => 'Lane 5, Gulberg Greens, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 95,
                'fee_status' => 'Paid',
                'fee_amount' => 8500,
                'fee_due_date' => '2026-11-15',
                'paid_date' => '2026-11-01',
                'payment_method' => 'Bank Transfer',
                'rfid_tag' => 'RFID-994826',
                'marks' => ['Mathematics' => 91, 'English' => 90, 'General Science' => 93, 'Computer Science' => 95, 'Urdu' => 87],
            ],
            [
                'student_code' => 'STU-007',
                'admission_no' => 'ADM-2026-107',
                'name' => 'Bilal Haider',
                'father_name' => 'Zulqarnain Haider',
                'class_name' => 'Class 8',
                'section' => 'A',
                'roll_no' => 2,
                'gender' => 'Male',
                'dob' => '2012-08-25',
                'blood_group' => 'A+',
                'phone' => '+92 322 6655443',
                'guardian_email' => 'z.haider@engro.com',
                'address' => 'Sector F-7/1, Street 18, House 7, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 71, // Flagged for AI Alert
                'fee_status' => 'Overdue',
                'fee_amount' => 8500,
                'fee_due_date' => '2026-10-20',
                'paid_date' => null,
                'payment_method' => null,
                'rfid_tag' => 'RFID-994827',
                'marks' => ['Mathematics' => 45, 'English' => 52, 'General Science' => 49, 'Computer Science' => 61, 'Urdu' => 55],
            ],
            [
                'student_code' => 'STU-008',
                'admission_no' => 'ADM-2026-108',
                'name' => 'Maryam Jahangir',
                'father_name' => 'Jahangir Badar',
                'class_name' => 'Class 7',
                'section' => 'A',
                'roll_no' => 1,
                'gender' => 'Female',
                'dob' => '2013-05-18',
                'blood_group' => 'O+',
                'phone' => '+92 334 8899001',
                'guardian_email' => 'jahangir.b@techsoft.pk',
                'address' => 'Phase 4, Bahria Town, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 97,
                'fee_status' => 'Paid',
                'fee_amount' => 8000,
                'fee_due_date' => '2026-11-15',
                'paid_date' => '2026-11-04',
                'payment_method' => 'EasyPaisa',
                'rfid_tag' => 'RFID-994828',
                'marks' => ['Mathematics' => 96, 'English' => 94, 'General Science' => 92, 'Computer Science' => 98, 'Urdu' => 90],
            ],
            [
                'student_code' => 'STU-009',
                'admission_no' => 'ADM-2026-109',
                'name' => 'Rayyan Mustafa',
                'father_name' => 'Mustafa Kamal',
                'class_name' => 'Class 7',
                'section' => 'A',
                'roll_no' => 2,
                'gender' => 'Male',
                'dob' => '2013-10-10',
                'blood_group' => 'B+',
                'phone' => '+92 301 9988112',
                'guardian_email' => 'mkamal.arch@gmail.com',
                'address' => 'Sector E-11/3, Multi Residencia, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 85,
                'fee_status' => 'Pending',
                'fee_amount' => 8000,
                'fee_due_date' => '2026-11-20',
                'paid_date' => null,
                'payment_method' => null,
                'rfid_tag' => 'RFID-994829',
                'marks' => ['Mathematics' => 78, 'English' => 81, 'General Science' => 75, 'Computer Science' => 80, 'Urdu' => 73],
            ],
            [
                'student_code' => 'STU-010',
                'admission_no' => 'ADM-2026-110',
                'name' => 'Khadija Asif',
                'father_name' => 'Asif Mehmood',
                'class_name' => 'Class 6',
                'section' => 'A',
                'roll_no' => 1,
                'gender' => 'Female',
                'dob' => '2014-02-28',
                'blood_group' => 'A-',
                'phone' => '+92 346 5544332',
                'guardian_email' => 'asif.m@consultancy.com',
                'address' => 'Block C, DHA Phase 2, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 93,
                'fee_status' => 'Paid',
                'fee_amount' => 7500,
                'fee_due_date' => '2026-11-15',
                'paid_date' => '2026-11-06',
                'payment_method' => 'JazzCash',
                'rfid_tag' => 'RFID-994830',
                'marks' => ['Mathematics' => 88, 'English' => 92, 'General Science' => 86, 'Computer Science' => 91, 'Urdu' => 85],
            ],
            [
                'student_code' => 'STU-011',
                'admission_no' => 'ADM-2026-111',
                'name' => 'Ahmed Hassan',
                'father_name' => 'Dr. Hassan Baig',
                'class_name' => 'Class 11',
                'section' => 'Pre-Engineering',
                'roll_no' => 1,
                'gender' => 'Male',
                'dob' => '2009-07-19',
                'blood_group' => 'O+',
                'phone' => '+92 300 2345678',
                'guardian_email' => 'hassan.baig@hospital.pk',
                'address' => 'House 29, Street 15, F-8/2, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 94,
                'fee_status' => 'Paid',
                'fee_amount' => 11500,
                'fee_due_date' => '2026-11-15',
                'paid_date' => '2026-11-02',
                'payment_method' => 'Bank Deposit',
                'rfid_tag' => 'RFID-994831',
                'marks' => ['Mathematics' => 92, 'Physics' => 89, 'Chemistry' => 91, 'English' => 85, 'Computer Science' => 97],
            ],
            [
                'student_code' => 'STU-012',
                'admission_no' => 'ADM-2026-112',
                'name' => 'Mahnoor Shah',
                'father_name' => 'Shahid Ali Shah',
                'class_name' => 'Class 11',
                'section' => 'Pre-Engineering',
                'roll_no' => 2,
                'gender' => 'Female',
                'dob' => '2009-12-04',
                'blood_group' => 'B+',
                'phone' => '+92 333 5544778',
                'guardian_email' => 'shahid.ali@energycorp.com',
                'address' => 'Villa 41, Park View City, Islamabad',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&h=150&q=80',
                'attendance_rate' => 68, // Flagged for AI Alert
                'fee_status' => 'Overdue',
                'fee_amount' => 11500,
                'fee_due_date' => '2026-10-20',
                'paid_date' => null,
                'payment_method' => null,
                'rfid_tag' => 'RFID-994832',
                'marks' => ['Mathematics' => 48, 'Physics' => 51, 'Chemistry' => 42, 'English' => 60, 'Computer Science' => 55],
            ],
        ];

        foreach ($students as $s) {
            Student::create($s);
        }

        // 4. Notices
        $notices = [
            [
                'notice_id' => 'NOT-01',
                'title' => 'Annual Sports Gala & Track Competitions 2026',
                'category' => 'Events',
                'audience' => 'All',
                'priority' => 'high',
                'date' => '2026-11-10',
                'content' => 'The Annual Sports Gala will commence on Friday, November 28, 2026. All students are invited to register for track & field, basketball, and table tennis through their class teachers by Nov 20.'
            ],
            [
                'notice_id' => 'NOT-02',
                'title' => 'Mid-Term Examination Result & Parent-Teacher Conference',
                'category' => 'Academics',
                'audience' => 'Parents',
                'priority' => 'urgent',
                'date' => '2026-11-08',
                'content' => 'Parent-Teacher Meeting (PTM) for Term 1 will be held on Saturday, November 22 from 9:00 AM to 2:00 PM. Detailed progress reports and teacher feedback will be handed over to parents.'
            ],
            [
                'notice_id' => 'NOT-03',
                'title' => 'November Tuition Fee Submission Deadline',
                'category' => 'Finance',
                'audience' => 'Parents',
                'priority' => 'urgent',
                'date' => '2026-11-05',
                'content' => 'Parents are gently reminded that the deadline for November 2026 tuition fees is November 15, 2026. Avoid late fee surcharges by paying via Meezan Bank online or at the school accounts desk.'
            ],
            [
                'notice_id' => 'NOT-04',
                'title' => 'Robotics & AI Innovation Club Registration Open',
                'category' => 'Club',
                'audience' => 'Students',
                'priority' => 'normal',
                'date' => '2026-11-02',
                'content' => 'Our newly equipped STEM lab is launching hands-on Arduino, Python, and AI workshops every Wednesday afternoon. Contact Sir Bilal Ahmed for registration.'
            ]
        ];
        foreach ($notices as $n) {
            Notice::create($n);
        }

        // 5. Activity Logs
        $logs = [
            ['type' => 'fee', 'message' => 'Fee payment of PKR 9,500 received for Muhammad Hamza (Class 10)'],
            ['type' => 'attendance', 'message' => 'Biometric morning attendance logged: 94.2% present'],
            ['type' => 'academic', 'message' => 'Midterm grades finalized for Class 10 Physics'],
            ['type' => 'notice', 'message' => 'New circular published: Annual Sports Gala 2026'],
        ];
        foreach ($logs as $l) {
            ActivityLog::create($l);
        }
    }
}
