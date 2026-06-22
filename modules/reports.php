<?php include_once 'includes/data.php';
$students = getStudents(); $att = getAttendance(); $grades = getGrades();
$depts = array_count_values(array_column($students,'dept'));
?>

<div class="page-header">
    <div>
        <h2 class="page-title">Reports & Analytics</h2>
        <p class="page-sub">Comprehensive insights and reports across all ERP modules.</p>
    </div>
    <button class="btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Print Report</button>
</div>

<!-- Charts Row -->
<div class="dash-row">
    <div class="dash-card flex-1">
        <div class="card-header"><h3>Students by Department</h3></div>
        <div class="chart-container"><canvas id="deptChart"></canvas></div>
    </div>
    <div class="dash-card flex-1">
        <div class="card-header"><h3>Grade Performance</h3></div>
        <div class="chart-container"><canvas id="perfChart"></canvas></div>
    </div>
    <div class="dash-card flex-1">
        <div class="card-header"><h3>Attendance by Subject</h3></div>
        <div class="chart-container"><canvas id="subChart"></canvas></div>
    </div>
</div>

<!-- Summary Table -->
<div class="table-card">
    <div class="table-top"><h3>Department-wise Summary</h3><span class="badge badge-blue">Academic Year 2024–25</span></div>
    <table class="data-table">
        <thead><tr><th>Department</th><th>Students</th><th>Avg Attendance</th><th>Avg Score</th><th>Pass Rate</th><th>Performance</th></tr></thead>
        <tbody>
        <?php foreach($depts as $dept=>$count):
            $dAtt = array_filter($att, fn($a)=>in_array($a['roll'], array_column(array_filter($students,fn($s)=>$s['dept']===$dept),'roll')));
            $dGrd = array_filter($grades, fn($g)=>in_array($g['roll'], array_column(array_filter($students,fn($s)=>$s['dept']===$dept),'roll')));
            $avgAtt = $dAtt ? round(array_sum(array_column(array_values($dAtt),'pct'))/count($dAtt)) : 0;
            $avgScore = $dGrd ? round(array_sum(array_column(array_values($dGrd),'total'))/count($dGrd)) : 0;
            $passRate = $dGrd ? round(count(array_filter(array_values($dGrd),fn($g)=>$g['total']>=40))/count($dGrd)*100) : 0;
        ?>
        <tr>
            <td><strong><?= htmlspecialchars($dept) ?></strong></td>
            <td><?= $count ?></td>
            <td>
                <div class="progress-cell">
                    <div class="progress-bar"><div class="progress-fill <?= $avgAtt>=75?'green':'red' ?>" style="width:<?= $avgAtt ?>%"></div></div>
                    <span><?= $avgAtt ?>%</span>
                </div>
            </td>
            <td><?= $avgScore ?>/100</td>
            <td><?= $passRate ?>%</td>
            <td>
                <?php $perf = $avgScore>=80?['Excellent','badge-green']:($avgScore>=60?['Good','badge-blue']:['Needs Improvement','badge-red']); ?>
                <span class="badge <?= $perf[1] ?>"><?= $perf[0] ?></span>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const deptLabels = <?= json_encode(array_keys($depts)) ?>;
const deptData   = <?= json_encode(array_values($depts)) ?>;
new Chart(document.getElementById('deptChart'),{type:'polarArea',data:{labels:deptLabels,datasets:[{data:deptData,backgroundColor:['rgba(99,102,241,.7)','rgba(16,185,129,.7)','rgba(245,158,11,.7)','rgba(239,68,68,.7)'],borderWidth:0}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}});

const gradeLabels = <?= json_encode(array_keys(array_count_values(array_column($grades,'grade')))) ?>;
const gradeData   = <?= json_encode(array_values(array_count_values(array_column($grades,'grade')))) ?>;
new Chart(document.getElementById('perfChart'),{type:'bar',data:{labels:gradeLabels,datasets:[{label:'Students',data:gradeData,backgroundColor:'rgba(99,102,241,.8)',borderRadius:6}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'rgba(0,0,0,.05)'}},x:{grid:{display:false}}}}});

const subjects = [...new Set(<?= json_encode(array_column($att,'subject')) ?>)];
const subAvg = subjects.map(s=>{const filtered=<?= json_encode($att) ?>.filter(a=>a.subject===s);return Math.round(filtered.reduce((a,b)=>a+b.pct,0)/filtered.length);});
new Chart(document.getElementById('subChart'),{type:'line',data:{labels:subjects,datasets:[{label:'Avg Attendance%',data:subAvg,borderColor:'#10b981',backgroundColor:'rgba(16,185,129,.1)',fill:true,tension:.4,pointBackgroundColor:'#10b981'}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,max:100},x:{grid:{display:false}}}}});
</script>
