<?php

namespace App\Services;

use App\Models\Student;

class AIStudentSuccessService
{
    /**
     * Analyze a single student's academic and behavioral indicators
     */
    public function analyzeStudent(Student $student): array
    {
        $marks = $student->marks ?? [];
        $subjects = array_keys($marks);
        $avgMarks = 0;
        if (count($subjects) > 0) {
            $avgMarks = round(array_sum($marks) / count($subjects));
        }

        $attendance = $student->attendance_rate ?? 85;
        $isOverdue = $student->fee_status === 'Overdue';

        $riskScore = 0;

        // Marks component (45%)
        if ($avgMarks < 50) {
            $riskScore += 45;
        } elseif ($avgMarks < 65) {
            $riskScore += 25;
        } elseif ($avgMarks < 75) {
            $riskScore += 10;
        }

        // Attendance component (40%)
        if ($attendance < 70) {
            $riskScore += 40;
        } elseif ($attendance < 80) {
            $riskScore += 25;
        } elseif ($attendance < 90) {
            $riskScore += 10;
        }

        // Fee stress component (15%)
        if ($isOverdue) {
            $riskScore += 15;
        }

        $status = 'Safe & Excelling';
        $badgeClass = 'bg-emerald-100 text-emerald-800';
        $recommendations = [];
        $weakSubjects = [];

        foreach ($marks as $sub => $score) {
            if ($score < 50) {
                $weakSubjects[] = "$sub ($score%)";
            }
        }

        if ($riskScore >= 60) {
            $status = 'Critical Risk';
            $badgeClass = 'bg-rose-100 text-rose-800 border border-rose-200';
            $recommendations[] = "🚨 Schedule mandatory Parent-Principal conference immediately.";
            if (!empty($weakSubjects)) {
                $recommendations[] = "📚 Enroll in urgent after-school remedial sessions for: " . implode(', ', $weakSubjects) . ".";
            }
            if ($attendance < 75) {
                $recommendations[] = "⚠️ Chronic absenteeism detected ({$attendance}%). Issue attendance warning circular.";
            }
        } elseif ($riskScore >= 35) {
            $status = 'Needs Attention';
            $badgeClass = 'bg-amber-100 text-amber-800 border border-amber-200';
            $recommendations[] = "💡 Assign mentor teacher for weekly 1-on-1 check-ins.";
            if (!empty($weakSubjects)) {
                $recommendations[] = "📝 Provide curated problem worksheets for: " . implode(', ', $weakSubjects) . ".";
            }
            if ($attendance < 85) {
                $recommendations[] = "⏰ Automated morning SMS dispatch to guardian on late arrival.";
            }
        } else {
            $status = 'Safe & Excelling';
            $badgeClass = 'bg-emerald-100 text-emerald-800 border border-emerald-200';
            if ($avgMarks >= 85) {
                $recommendations[] = "🌟 Nominate for Inter-School Academic Olympiad & Leadership Council.";
                $recommendations[] = "🚀 Provide advanced honors curriculum reading.";
            } else {
                $recommendations[] = "✅ Balanced discipline across subjects. Maintain regular study cycle.";
            }
        }

        return [
            'student' => $student,
            'avgMarks' => $avgMarks,
            'attendanceRate' => $attendance,
            'riskScore' => $riskScore,
            'status' => $status,
            'badgeClass' => $badgeClass,
            'weakSubjects' => $weakSubjects,
            'recommendations' => $recommendations,
            'parentAlertDraft' => "Dear Parent/Guardian of {$student->name},\nThis is an academic performance notification from Crescent Model School. Your ward maintains {$attendance}% attendance and an aggregate test average of {$avgMarks}%. " . ($riskScore >= 60 ? "Immediate meeting requested with principal." : "Please continue supporting your child's progress.") . "\nRegards,\nAcademic Coordination Office"
        ];
    }

    /**
     * Get aggregate school diagnostics
     */
    public function getSchoolDiagnostics(): array
    {
        $students = Student::all();
        $analyses = $students->map(fn($s) => $this->analyzeStudent($s));

        $critical = $analyses->filter(fn($a) => $a['riskScore'] >= 60);
        $attention = $analyses->filter(fn($a) => $a['riskScore'] >= 35 && $a['riskScore'] < 60);
        $safe = $analyses->filter(fn($a) => $a['riskScore'] < 35);

        return [
            'total' => $students->count(),
            'criticalCount' => $critical->count(),
            'attentionCount' => $attention->count(),
            'safeCount' => $safe->count(),
            'analyses' => $analyses,
            'criticalList' => $critical,
        ];
    }
}
