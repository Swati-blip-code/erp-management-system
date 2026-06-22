<?php
include_once 'includes/data.php';
$students = getStudents();
$attendance = getAttendance();
$grades = getGrades();
$active = count(array_filter($students, fn($s)=>$s['status']==='Active'));
$avgPct = round(array_sum(array_column($attendance,'pct')) / count($attendance));
?>

<div class="page-header">
    <div>
        <h2 class="page-title">Dashboard Overview</h2>
        <p class="page-sub">Welcome back, <?= htmlspecialchars($_SESSION['user']['name']) ?>! Here's what's happening today.</p>
    </div>
    <div class="header-date"><i class="fas fa-calendar"></i> <?= date('D, d M Y') ?></div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card kpi-blue">
        <div class="kpi-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="kpi-body">
            <div class="kpi-val"><?= count($students) ?></div>
            <div class="kpi-label">Total Students</div>
            <div class="kpi-trend up"><i class="fas fa-arrow-trend-up"></i> +3 this month</div>
        </div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-icon"><i class="fas fa-circle-check"></i></div>
        <div class="kpi-body">
            <div class="kpi-val"><?= $active ?></div>
            <div class="kpi-label">Active Students</div>
            <div class="kpi-trend up"><i class="fas fa-arrow-trend-up"></i> 87.5% active rate</div>
        </div>
    </div>
    <div class="kpi-card kpi-amber">
        <div class="kpi-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="kpi-body">
            <div class="kpi-val"><?= $avgPct ?>%</div>
            <div class="kpi-label">Avg Attendance</div>
            <div class="kpi-trend <?= $avgPct>=75?'up':'down' ?>"><i class="fas fa-arrow-trend-<?= $avgPct>=75?'up':'down' ?>"></i> <?= $avgPct>=75?'Above':'Below' ?> threshold</div>
        </div>
    </div>
    <div class="kpi-card kpi-purple">
        <div class="kpi-icon"><i class="fas fa-book-open"></i></div>
        <div class="kpi-body">
            <div class="kpi-val">4</div>
            <div class="kpi-label">Departments</div>
            <div class="kpi-trend neutral"><i class="fas fa-minus"></i> CS, IT, EC, ME</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="dash-row">
    <div class="dash-card flex-2">
        <div class="card-header">
            <h3>Attendance Overview</h3>
            <span class="badge badge-blue">This Month</span>
        </div>
        <div class="chart-container">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>
    <div class="dash-card flex-1">
        <div class="card-header">
            <h3>Grade Distribution</h3>
            <span class="badge badge-green">Current Sem</span>
        </div>
        <div class="chart-container">
            <canvas id="gradeChart"></canvas>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="dash-row">
    <div class="dash-card flex-1">
        <div class="card-header">
            <h3>Recent Students</h3>
            <a href="?page=students" class="card-link">View All →</a>
        </div>
        <table class="mini-table">
            <thead><tr><th>Name</th><th>Dept</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach(array_slice($students,0,5) as $s): ?>
            <tr>
                <td><div class="mini-student"><div class="mini-av"><?= strtoupper(substr($s['name'],0,1)) ?></div><?= htmlspecialchars($s['name']) ?></div></td>
                <td><?= htmlspecialchars($s['dept']) ?></td>
                <td><span class="badge <?= $s['status']==='Active'?'badge-green':'badge-red' ?>"><?= $s['status'] ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="dash-card flex-1">
        <div class="card-header">
            <h3>Low Attendance Alert</h3>
            <span class="badge badge-red">Action Needed</span>
        </div>
        <div class="alert-list">
        <?php foreach($attendance as $a): if($a['pct']<75): ?>
            <div class="alert-item">
                <div class="alert-av"><?= strtoupper(substr($a['student'],0,1)) ?></div>
                <div class="alert-info">
                    <strong><?= htmlspecialchars($a['student']) ?></strong>
                    <span><?= $a['subject'] ?> — <?= $a['pct'] ?>%</span>
                </div>
                <div class="alert-pct" style="color:var(--red)"><?= $a['pct'] ?>%</div>
            </div>
        <?php endif; endforeach; ?>
        <?php
        $low = array_filter($attendance, fn($a)=>$a['pct']<75);
        if(count($low)===0) echo '<div class="empty-state"><i class="fas fa-circle-check"></i> All students above 75%</div>';
        ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Attendance Bar Chart
const attCtx = document.getElementById('attendanceChart').getContext('2d');
new Chart(attCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_map(fn($a)=>explode(' ',$a['student'])[0], $attendance)) ?>,
        datasets: [{
            label: 'Attendance %',
            data: <?= json_encode(array_column($attendance,'pct')) ?>,
            backgroundColor: function(ctx){
                const v = ctx.parsed.y;
                return v>=75?'rgba(16,185,129,0.8)':'rgba(239,68,68,0.8)';
            },
            borderRadius: 6,
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{legend:{display:false}},
        scales:{y:{beginAtZero:true,max:100,grid:{color:'rgba(0,0,0,0.05)'}},x:{grid:{display:false}}}
    }
});

// Grade Doughnut
const gradeCtx = document.getElementById('gradeChart').getContext('2d');
const grades = <?= json_encode(array_count_values(array_column($grades,'grade'))) ?>;
new Chart(gradeCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(grades),
        datasets: [{
            data: Object.values(grades),
            backgroundColor:['#6366f1','#10b981','#f59e0b','#3b82f6','#ef4444','#8b5cf6'],
            borderWidth:0
        }]
    },
    options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom',labels:{padding:10,font:{size:11}}}}}
});
</script>
