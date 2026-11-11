/**
 * Apex International Academy - Report Generation & Download Hub
 * Generates:
 * 1. 3-Ply Bank Fee Vouchers (PDF / Printable)
 * 2. Official Student ID Cards with Barcode & QR (PDF / Printable)
 * 3. Academic Terminal Report Cards (PDF / Printable)
 * 4. Attendance Registers & Defaulters Lists (Excel .xlsx / CSV / PDF)
 * 5. School Audit & Financial Executive Summaries
 */

class ReportManager {
  constructor(db) {
    this.db = db;
  }

  // Helper to trigger print dialog on generated HTML
  printElement(contentHtml, title = "Apex Academy Document") {
    const printWindow = window.open('', '_blank', 'width=1100,height=800');
    if (!printWindow) {
      alert("Please allow popups to preview and print documents.");
      return;
    }
    printWindow.document.write(`
      <!DOCTYPE html>
      <html>
      <head>
        <title>${title}</title>
        <meta charset="utf-8">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
        <style>
          @page { size: auto; margin: 10mm; }
          body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fff; color: #1e293b; }
          .barcode { font-family: 'Libre Barcode 39 Text', cursive; font-size: 28px; }
          @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
          }
        </style>
      </head>
      <body class="p-6">
        <div class="no-print mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between">
          <div>
            <h4 class="font-bold text-indigo-900">Document Ready for Download / Printing</h4>
            <p class="text-sm text-indigo-700">Click the button on the right to Print or Save as PDF from your browser.</p>
          </div>
          <button onclick="window.print()" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition flex items-center gap-2">
            🖨️ Print / Save as PDF
          </button>
        </div>
        ${contentHtml}
      </body>
      </html>
    `);
    printWindow.document.close();
  }

  // 1. GENERATE 3-PLY FEE CHALLAN / VOUCHER
  generateFeeVoucherHTML(student) {
    const p = this.db.data.profile;
    const challanNo = `CH-${new Date().getFullYear()}-${student.rollNo}${student.id.replace('STU-', '')}`;
    const issueDate = new Date().toLocaleDateString('en-GB');
    const dueDate = student.feeDueDate || "15/11/2026";
    const baseTuition = student.feeAmount - 1500;
    const labFee = 1000;
    const examFund = 500;
    const lateFine = student.feeStatus === 'Overdue' ? 500 : 0;
    const totalAmount = student.feeAmount + lateFine;

    const renderCopy = (copyTitle) => `
      <div class="border-2 border-dashed border-slate-300 p-4 rounded-xl flex flex-col justify-between text-xs bg-white relative">
        <div class="text-center pb-3 border-b border-slate-200">
          <div class="font-bold text-indigo-900 text-sm tracking-wide">${p.name}</div>
          <div class="text-[10px] text-slate-500">${p.address}</div>
          <div class="mt-1 inline-block px-2 py-0.5 bg-indigo-100 text-indigo-800 font-bold rounded uppercase text-[10px]">
            ${copyTitle}
          </div>
        </div>

        <div class="my-3 space-y-1 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
          <div class="flex justify-between"><span class="text-slate-500">Challan No:</span> <span class="font-mono font-bold text-slate-800">${challanNo}</span></div>
          <div class="flex justify-between"><span class="text-slate-500">Issue Date:</span> <span class="font-medium">${issueDate}</span></div>
          <div class="flex justify-between"><span class="text-slate-500">Due Date:</span> <span class="font-bold text-rose-600">${dueDate}</span></div>
          <div class="flex justify-between"><span class="text-slate-500">Bank:</span> <span class="font-semibold text-slate-700">${p.bankName}</span></div>
          <div class="flex justify-between"><span class="text-slate-500">A/C No:</span> <span class="font-mono text-[11px] text-slate-700">${p.bankAccountNumber}</span></div>
        </div>

        <div class="mb-3 border-b border-slate-200 pb-2">
          <div class="font-bold text-slate-900 text-sm">${student.name}</div>
          <div class="text-slate-600">S/D/O: <b>${student.fatherName}</b></div>
          <div class="flex justify-between text-slate-600 mt-0.5">
            <span>Class: <b>${student.class} (${student.section})</b></span>
            <span>Roll No: <b>${student.rollNo}</b></span>
          </div>
          <div class="text-slate-500 text-[11px]">Adm No: <b>${student.admissionNo}</b></div>
        </div>

        <table class="w-full text-left mb-3">
          <thead>
            <tr class="border-b border-slate-300 text-slate-600">
              <th class="py-1">Description</th>
              <th class="py-1 text-right">Amount (PKR)</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr><td class="py-1">Tuition Fee</td><td class="py-1 text-right font-mono">${baseTuition.toLocaleString()}</td></tr>
            <tr><td class="py-1">Science / IT Lab Fund</td><td class="py-1 text-right font-mono">${labFee.toLocaleString()}</td></tr>
            <tr><td class="py-1">Exam & Library Fund</td><td class="py-1 text-right font-mono">${examFund.toLocaleString()}</td></tr>
            ${lateFine > 0 ? `<tr class="text-rose-600"><td class="py-1">Late Payment Surcharge</td><td class="py-1 text-right font-mono">${lateFine.toLocaleString()}</td></tr>` : ''}
            <tr class="border-t-2 border-slate-900 font-bold text-slate-900 bg-indigo-50/50">
              <td class="py-1.5 px-1 font-bold">Total Payable</td>
              <td class="py-1.5 px-1 text-right font-mono text-sm text-indigo-700 font-bold">PKR ${totalAmount.toLocaleString()}</td>
            </tr>
          </tbody>
        </table>

        <div class="text-[10px] text-slate-400 text-center font-mono tracking-widest my-1 barcode">
          *${challanNo}*
        </div>

        <div class="pt-6 border-t border-slate-200 flex justify-between items-end text-[10px] text-slate-500">
          <div class="text-center">
            <div class="w-24 border-b border-slate-400 mb-1"></div>
            <span>Bank Officer</span>
          </div>
          <div class="text-center">
            <div class="w-24 border-b border-slate-400 mb-1"></div>
            <span>Accounts Officer</span>
          </div>
        </div>
      </div>
    `;

    return `
      <div class="max-w-6xl mx-auto">
        <div class="text-center mb-6">
          <h2 class="text-2xl font-black text-indigo-950">${p.name}</h2>
          <p class="text-sm text-slate-600">Official Monthly Fee Voucher & Challan Slip</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          ${renderCopy("1. School Copy")}
          ${renderCopy("2. Bank Copy")}
          ${renderCopy("3. Student / Parent Copy")}
        </div>
      </div>
    `;
  }

  downloadFeeVoucher(studentId) {
    const student = this.db.getStudentById(studentId);
    if (!student) return alert("Student not found!");
    const html = this.generateFeeVoucherHTML(student);
    this.printElement(html, `Fee_Challan_${student.rollNo}_${student.name.replace(/\s+/g, '_')}`);
  }

  // 2. GENERATE STUDENT ID CARD (Front & Back)
  generateIDCardHTML(student) {
    const p = this.db.data.profile;
    return `
      <div class="flex flex-col items-center justify-center p-6 bg-slate-100 min-h-screen">
        <div class="text-center mb-6">
          <h3 class="text-xl font-bold text-slate-800">Apex Official Student Identity Card</h3>
          <p class="text-sm text-slate-500">Standard CR80 Identity Badge Layout</p>
        </div>

        <div class="flex flex-wrap gap-8 justify-center">
          <!-- FRONT SIDE -->
          <div class="w-[340px] h-[520px] bg-gradient-to-br from-indigo-900 via-indigo-800 to-indigo-950 rounded-2xl shadow-2xl p-5 text-white flex flex-col justify-between relative overflow-hidden border border-indigo-700">
            <!-- Background Watermark -->
            <div class="absolute -right-16 -top-16 w-52 h-52 bg-white/5 rounded-full pointer-events-none blur-xl"></div>
            <div class="absolute -left-16 -bottom-16 w-52 h-52 bg-indigo-500/10 rounded-full pointer-events-none blur-xl"></div>

            <!-- Header -->
            <div class="text-center relative z-10">
              <div class="flex items-center justify-center gap-2 mb-1">
                <div class="w-8 h-8 rounded-lg bg-amber-400 flex items-center justify-center text-indigo-950 font-black shadow-md">A</div>
                <span class="font-extrabold text-sm tracking-wide text-white uppercase">${p.name}</span>
              </div>
              <p class="text-[10px] text-indigo-200 tracking-wider uppercase font-semibold">Student Identity Pass</p>
            </div>

            <!-- Student Photo -->
            <div class="flex flex-col items-center relative z-10 my-2">
              <div class="w-28 h-28 rounded-xl p-1 bg-gradient-to-tr from-amber-400 to-indigo-400 shadow-xl">
                <img src="${student.avatar}" alt="${student.name}" class="w-full h-full object-cover rounded-lg">
              </div>
              <h4 class="font-bold text-lg mt-3 text-white text-center leading-tight">${student.name}</h4>
              <span class="text-xs text-amber-300 font-semibold mt-0.5">${student.class} (${student.section})</span>
            </div>

            <!-- Details Grid -->
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 text-xs space-y-1.5 border border-white/10 relative z-10">
              <div class="flex justify-between"><span class="text-indigo-200">Roll No:</span><span class="font-bold text-white">${student.rollNo}</span></div>
              <div class="flex justify-between"><span class="text-indigo-200">Admission No:</span><span class="font-bold text-white font-mono">${student.admissionNo}</span></div>
              <div class="flex justify-between"><span class="text-indigo-200">Blood Group:</span><span class="font-bold text-rose-300">${student.bloodGroup || 'O+'}</span></div>
              <div class="flex justify-between"><span class="text-indigo-200">Valid Upto:</span><span class="font-semibold text-white">Aug 2027</span></div>
            </div>

            <!-- Barcode Footer -->
            <div class="text-center relative z-10 pt-2 border-t border-indigo-700/60">
              <div class="barcode text-2xl text-amber-300 tracking-widest leading-none">*${student.admissionNo}*</div>
              <p class="text-[9px] text-indigo-300 mt-1">Authorized Student Identity Document</p>
            </div>
          </div>

          <!-- BACK SIDE -->
          <div class="w-[340px] h-[520px] bg-white rounded-2xl shadow-2xl p-5 text-slate-800 flex flex-col justify-between border border-slate-200 relative">
            <div>
              <div class="border-b border-slate-200 pb-3 text-center">
                <h5 class="font-extrabold text-sm text-indigo-900 uppercase">Emergency & Instructions</h5>
                <p class="text-[10px] text-slate-500">If found, please return to school address</p>
              </div>

              <div class="my-4 space-y-2 text-xs">
                <div>
                  <span class="text-[11px] font-semibold text-slate-400 block">Father / Guardian:</span>
                  <span class="font-medium text-slate-800">${student.fatherName}</span>
                </div>
                <div>
                  <span class="text-[11px] font-semibold text-slate-400 block">Emergency Helpline:</span>
                  <span class="font-bold text-indigo-600">${student.phone}</span>
                </div>
                <div>
                  <span class="text-[11px] font-semibold text-slate-400 block">Permanent Residence:</span>
                  <span class="text-slate-700 text-[11px] leading-snug">${student.address}</span>
                </div>
              </div>

              <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-[10px] text-slate-600 space-y-1">
                <p>• Cardholder must wear this badge during school hours and examinations.</p>
                <p>• Loss of badge must be reported immediately to Admin desk.</p>
                <p>• Non-transferable property of Apex International Academy.</p>
              </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
              <div class="w-16 h-16 bg-slate-100 rounded-lg border border-slate-300 flex items-center justify-center p-1">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=${student.admissionNo}-${student.name}" alt="QR" class="w-full h-full">
              </div>
              <div class="text-right">
                <div class="text-indigo-900 font-serif italic font-bold text-sm">Dr. Farhan Q.</div>
                <div class="w-24 border-b border-slate-400 my-1 ml-auto"></div>
                <span class="text-[10px] font-semibold text-slate-500 uppercase">Principal Signature</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  downloadIDCard(studentId) {
    const student = this.db.getStudentById(studentId);
    if (!student) return alert("Student not found!");
    const html = this.generateIDCardHTML(student);
    this.printElement(html, `Student_Badge_${student.admissionNo}_${student.name.replace(/\s+/g, '_')}`);
  }

  // 3. GENERATE TERMINAL REPORT CARD / MARKSHEET
  generateReportCardHTML(student) {
    const p = this.db.data.profile;
    const marksObj = student.marks || {};
    const subjects = Object.keys(marksObj);
    let totalMax = subjects.length * 100;
    let totalObtained = 0;

    const rows = subjects.map(sub => {
      const score = marksObj[sub] || 0;
      totalObtained += score;
      let grade = "F";
      let remarks = "Needs Serious Work";
      if (score >= 90) { grade = "A+"; remarks = "Outstanding Excellence"; }
      else if (score >= 80) { grade = "A"; remarks = "Excellent Mastery"; }
      else if (score >= 70) { grade = "B"; remarks = "Good Understanding"; }
      else if (score >= 60) { grade = "C"; remarks = "Satisfactory"; }
      else if (score >= 50) { grade = "D"; remarks = "Barely Passing"; }

      return `
        <tr class="border-b border-slate-200 text-sm">
          <td class="py-2.5 px-3 font-medium text-slate-800">${sub}</td>
          <td class="py-2.5 px-3 text-center text-slate-500">100</td>
          <td class="py-2.5 px-3 text-center font-bold text-slate-900">${score}</td>
          <td class="py-2.5 px-3 text-center font-bold ${score >= 80 ? 'text-emerald-600' : score < 50 ? 'text-rose-600' : 'text-indigo-600'}">${grade}</td>
          <td class="py-2.5 px-3 text-slate-600 text-xs">${remarks}</td>
        </tr>
      `;
    }).join('');

    const percentage = totalMax > 0 ? Math.round((totalObtained / totalMax) * 100) : 0;
    let overallGrade = "F";
    let gpa = "0.0";
    if (percentage >= 90) { overallGrade = "A+"; gpa = "4.0"; }
    else if (percentage >= 80) { overallGrade = "A"; gpa = "3.7"; }
    else if (percentage >= 70) { overallGrade = "B"; gpa = "3.0"; }
    else if (percentage >= 60) { overallGrade = "C"; gpa = "2.3"; }
    else if (percentage >= 50) { overallGrade = "D"; gpa = "1.7"; }

    return `
      <div class="max-w-4xl mx-auto bg-white p-8 border border-slate-300 rounded-2xl shadow-xl my-4">
        <!-- School Header -->
        <div class="text-center pb-6 border-b-2 border-indigo-900">
          <div class="flex items-center justify-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-indigo-900 text-amber-400 flex items-center justify-center font-black text-2xl shadow">A</div>
            <div>
              <h1 class="text-2xl font-black text-indigo-950 uppercase tracking-tight">${p.name}</h1>
              <p class="text-xs text-slate-500">${p.address} | Tel: ${p.phone}</p>
            </div>
          </div>
          <div class="inline-block px-4 py-1 bg-indigo-50 border border-indigo-200 text-indigo-900 font-bold text-xs uppercase rounded-full mt-2">
            Academic Performance & Terminal Progress Report
          </div>
        </div>

        <!-- Student Meta -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200 my-6 text-xs">
          <div><span class="text-slate-400 block font-semibold">Student Name:</span><b class="text-sm text-slate-900">${student.name}</b></div>
          <div><span class="text-slate-400 block font-semibold">Father's Name:</span><b class="text-slate-800">${student.fatherName}</b></div>
          <div><span class="text-slate-400 block font-semibold">Class / Section:</span><b class="text-slate-800">${student.class} (${student.section})</b></div>
          <div><span class="text-slate-400 block font-semibold">Roll Number:</span><b class="text-slate-800">${student.rollNo}</b></div>
          <div><span class="text-slate-400 block font-semibold">Admission No:</span><b class="font-mono text-slate-800">${student.admissionNo}</b></div>
          <div><span class="text-slate-400 block font-semibold">Attendance Rate:</span><b class="${student.attendanceRate >= 80 ? 'text-emerald-700' : 'text-rose-600'} font-bold">${student.attendanceRate}%</b></div>
          <div><span class="text-slate-400 block font-semibold">Academic Term:</span><b class="text-slate-800">${p.currentTerm}</b></div>
          <div><span class="text-slate-400 block font-semibold">Issue Date:</span><b class="text-slate-800">${new Date().toLocaleDateString('en-GB')}</b></div>
        </div>

        <!-- Marks Table -->
        <table class="w-full text-left border border-slate-200 rounded-lg overflow-hidden mb-6">
          <thead class="bg-indigo-950 text-white text-xs uppercase font-semibold">
            <tr>
              <th class="py-3 px-3">Subject</th>
              <th class="py-3 px-3 text-center">Max Marks</th>
              <th class="py-3 px-3 text-center">Marks Obtained</th>
              <th class="py-3 px-3 text-center">Grade</th>
              <th class="py-3 px-3">Faculty Remarks</th>
            </tr>
          </thead>
          <tbody>
            ${rows}
          </tbody>
          <tfoot class="bg-slate-100 font-bold text-slate-900">
            <tr>
              <td class="py-3 px-3">Cumulative Total</td>
              <td class="py-3 px-3 text-center">${totalMax}</td>
              <td class="py-3 px-3 text-center text-indigo-700 text-base">${totalObtained}</td>
              <td class="py-3 px-3 text-center text-indigo-700 text-base">${overallGrade}</td>
              <td class="py-3 px-3 text-xs">Overall GPA: <b>${gpa}</b> | Aggregate: <b>${percentage}%</b></td>
            </tr>
          </tfoot>
        </table>

        <!-- Grading Legend & Signatures -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-slate-200">
          <div class="text-[11px] text-slate-500 bg-slate-50 p-3 rounded-lg border border-slate-200">
            <b class="text-slate-700 block mb-1">Standard Grading Criteria:</b>
            <span>90-100% = A+ (4.0) | 80-89% = A (3.7)<br>70-79% = B (3.0) | 60-69% = C (2.3)<br>50-59% = D (1.7) | Below 50% = F (Fail)</span>
          </div>
          <div class="text-center pt-8">
            <div class="w-36 border-b border-slate-400 mx-auto mb-1"></div>
            <span class="text-xs text-slate-500 font-semibold uppercase">Class Teacher Signature</span>
          </div>
          <div class="text-center pt-8">
            <div class="w-36 border-b border-slate-400 mx-auto mb-1"></div>
            <span class="text-xs text-slate-500 font-semibold uppercase">Principal Stamp & Signature</span>
          </div>
        </div>
      </div>
    `;
  }

  downloadReportCard(studentId) {
    const student = this.db.getStudentById(studentId);
    if (!student) return alert("Student not found!");
    const html = this.generateReportCardHTML(student);
    this.printElement(html, `Progress_Report_${student.admissionNo}_${student.name.replace(/\s+/g, '_')}`);
  }

  // 4. EXCEL & CSV EXPORTS USING SHEETJS
  exportStudentsToExcel() {
    const students = this.db.getStudents();
    const rows = students.map((s, idx) => ({
      "Sr #": idx + 1,
      "Admission No": s.admissionNo,
      "Full Name": s.name,
      "Father's Name": s.fatherName,
      "Class": s.class,
      "Section": s.section,
      "Roll No": s.rollNo,
      "Gender": s.gender,
      "Phone": s.phone,
      "Guardian Email": s.guardianEmail,
      "Fee Status": s.feeStatus,
      "Monthly Fee (PKR)": s.feeAmount,
      "Attendance %": s.attendanceRate + "%",
      "RFID Card #": s.rfidTag || "N/A"
    }));

    const worksheet = XLSX.utils.json_to_sheet(rows);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Students_Directory");
    XLSX.writeFile(workbook, `Apex_Students_Directory_${new Date().toISOString().split('T')[0]}.xlsx`);
  }

  exportDefaultersToExcel() {
    const defaulters = this.db.getStudents().filter(s => s.feeStatus === "Overdue" || s.feeStatus === "Pending");
    const rows = defaulters.map((s, idx) => ({
      "Sr #": idx + 1,
      "Admission No": s.admissionNo,
      "Student Name": s.name,
      "Father's Name": s.fatherName,
      "Class": s.class,
      "Roll No": s.rollNo,
      "Parent Phone": s.phone,
      "Fee Status": s.feeStatus,
      "Pending Amount (PKR)": s.feeAmount,
      "Due Date": s.feeDueDate,
      "Action Required": s.feeStatus === "Overdue" ? "Immediate Call & Reminder" : "Pending Normal"
    }));

    const worksheet = XLSX.utils.json_to_sheet(rows);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Fee_Defaulters");
    XLSX.writeFile(workbook, `Apex_Fee_Defaulters_Report_${new Date().toISOString().split('T')[0]}.xlsx`);
  }

  exportAttendanceRegisterExcel(selectedClass = "Class 10") {
    const students = this.db.getStudents().filter(s => s.class === selectedClass);
    const rows = students.map((s, idx) => ({
      "Roll No": s.rollNo,
      "Admission No": s.admissionNo,
      "Student Name": s.name,
      "Father's Name": s.fatherName,
      "Attendance Rate": s.attendanceRate + "%",
      "Monthly Status": s.attendanceRate >= 80 ? "Regular" : "Irregular"
    }));

    const worksheet = XLSX.utils.json_to_sheet(rows);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, `${selectedClass}_Attendance`);
    XLSX.writeFile(workbook, `Apex_Attendance_${selectedClass.replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.xlsx`);
  }

  // 5. BULK PRINT ID CARDS FOR WHOLE CLASS
  bulkDownloadIDCards(selectedClass = "Class 10") {
    const students = this.db.getStudents().filter(s => s.class === selectedClass);
    if (students.length === 0) return alert("No students found in " + selectedClass);
    
    let html = `
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Apex Academy - Bulk Student ID Cards Batch</h2>
        <p class="text-sm text-slate-500">Target Class: ${selectedClass} (${students.length} cards)</p>
      </div>
      <div class="space-y-12">
    `;
    students.forEach(s => {
      html += this.generateIDCardHTML(s);
      html += `<div style="page-break-after: always;"></div>`;
    });
    html += `</div>`;
    this.printElement(html, `Bulk_ID_Cards_${selectedClass.replace(/\s+/g, '_')}`);
  }

  // 6. BULK PRINT FEE CHALLANS FOR DEFAULTERS
  bulkDownloadDefaulterChallans() {
    const defaulters = this.db.getStudents().filter(s => s.feeStatus === "Overdue" || s.feeStatus === "Pending");
    if (defaulters.length === 0) return alert("All fees are paid! No pending challans.");

    let html = `
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Apex Academy - Pending Fee Challans Batch</h2>
        <p class="text-sm text-slate-500">Total Pending Students: ${defaulters.length}</p>
      </div>
      <div class="space-y-12">
    `;
    defaulters.forEach(s => {
      html += this.generateFeeVoucherHTML(s);
      html += `<div style="page-break-after: always;"></div>`;
    });
    html += `</div>`;
    this.printElement(html, `Bulk_Fee_Challans_${new Date().toISOString().split('T')[0]}`);
  }
}

window.reportManager = new ReportManager(window.db);
