/**
 * Apex International Academy - AI Student Success & Early Warning Analytics
 * Researched Feature for Modern School ERPs (2026/2027)
 */

class AIInsightsEngine {
  constructor(db) {
    this.db = db;
  }

  // Calculate composite risk index (0 to 100)
  analyzeStudent(student) {
    const marksObj = student.marks || {};
    const subjects = Object.keys(marksObj);
    let avgMarks = 0;
    if (subjects.length > 0) {
      const sum = subjects.reduce((acc, sub) => acc + (marksObj[sub] || 0), 0);
      avgMarks = Math.round(sum / subjects.length);
    }

    const attendance = student.attendanceRate || 85;
    const isFeeOverdue = student.feeStatus === "Overdue";

    // Weighting: 45% marks, 40% attendance, 15% financial flags
    let riskScore = 0;

    // Academic risk component
    if (avgMarks < 50) {
      riskScore += 45;
    } else if (avgMarks < 65) {
      riskScore += 25;
    } else if (avgMarks < 75) {
      riskScore += 10;
    }

    // Attendance risk component
    if (attendance < 70) {
      riskScore += 40;
    } else if (attendance < 80) {
      riskScore += 25;
    } else if (attendance < 90) {
      riskScore += 10;
    }

    // Fee overdue factor
    if (isFeeOverdue) {
      riskScore += 15;
    }

    // Determine category & diagnosis
    let status = "On Track";
    let badgeColor = "emerald";
    let recommendations = [];
    let weakSubjects = [];
    let strongSubjects = [];

    subjects.forEach(sub => {
      const score = marksObj[sub];
      if (score < 50) weakSubjects.push(`${sub} (${score}%)`);
      else if (score >= 85) strongSubjects.push(`${sub} (${score}%)`);
    });

    if (riskScore >= 60) {
      status = "Critical Risk";
      badgeColor = "rose";
      recommendations.push("🚨 Schedule emergency parent-counselor meeting immediately.");
      if (weakSubjects.length > 0) {
        recommendations.push(`📚 Urgent remedial coaching required in: ${weakSubjects.join(', ')}.`);
      }
      if (attendance < 75) {
        recommendations.push(`⚠️ Chronic absenteeism detected (${attendance}%). Issue attendance show-cause notice.`);
      }
    } else if (riskScore >= 35) {
      status = "Needs Attention";
      badgeColor = "amber";
      recommendations.push("💡 Teacher to conduct 1-on-1 progress check-in this week.");
      if (weakSubjects.length > 0) {
        recommendations.push(`📝 Provide structured practice problem sets for ${weakSubjects.join(', ')}.`);
      }
      if (attendance < 85) {
        recommendations.push(`⏰ Monitor morning punctuality and send automated attendance alert to guardian.`);
      }
    } else {
      status = "Excelling / Safe";
      badgeColor = "emerald";
      if (avgMarks >= 85) {
        recommendations.push("🌟 Nominate for Inter-School Academic Olympiad and Leadership Council.");
        recommendations.push("🚀 Provide advanced honor roll curriculum materials.");
      } else {
        recommendations.push("✅ Consistent performance across disciplines. Maintain current study routine.");
      }
    }

    return {
      studentId: student.id,
      name: student.name,
      class: student.class,
      rollNo: student.rollNo,
      admissionNo: student.admissionNo,
      avgMarks,
      attendanceRate: attendance,
      feeStatus: student.feeStatus,
      riskScore,
      status,
      badgeColor,
      weakSubjects,
      strongSubjects,
      recommendations,
      parentAlertDraft: `Dear Parent/Guardian of ${student.name},\nThis is an automated performance update from Apex Academy. Your ward currently maintains an attendance rate of ${attendance}% and a current academic average of ${avgMarks}%. ${status === 'Critical Risk' ? 'We urge you to schedule a meeting with the principal and class teacher to discuss academic support intervention.' : 'Please continue encouraging your child.'}\nRegards,\nAcademic Coordination Office`
    };
  }

  // Get all analytics summary
  getSchoolAnalytics() {
    const students = this.db.getStudents();
    const analyses = students.map(s => this.analyzeStudent(s));

    const critical = analyses.filter(a => a.status === "Critical Risk");
    const attention = analyses.filter(a => a.status === "Needs Attention");
    const safe = analyses.filter(a => a.status === "Excelling / Safe");

    const avgSchoolMarks = Math.round(analyses.reduce((sum, a) => sum + a.avgMarks, 0) / (analyses.length || 1));
    const avgAttendance = Math.round(analyses.reduce((sum, a) => sum + a.attendanceRate, 0) / (analyses.length || 1));

    return {
      totalAnalyzed: students.length,
      criticalCount: critical.length,
      attentionCount: attention.length,
      safeCount: safe.length,
      criticalList: critical,
      attentionList: attention,
      safeList: safe,
      avgSchoolMarks,
      avgAttendance,
      allAnalyses: analyses
    };
  }
}

window.aiEngine = new AIInsightsEngine(window.db);
