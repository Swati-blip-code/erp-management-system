<?php include_once 'includes/data.php'; $att = getAttendance(); ?>

<div class="page-header">
    <div>
        <h2 class="page-title">Attendance Tracking</h2>
        <p class="page-sub">Monitor and manage student attendance records across all subjects.</p>
    </div>
    <button class="btn-primary" onclick="openModal('markModal')"><i class="fas fa-plus"></i> Mark Attendance</button>
</div>

<!-- Summary Cards -->
<div class="kpi-grid four">
    <?php
    $above = count(array_filter($att, fn($a)=>$a['pct']>=75));
    $below = count($att) - $above;
    $avg   = round(array_sum(array_column($att,'pct'))/count($att));
    $perf  = max(array_column($att,'pct'));
    ?>
    <div class="kpi-card kpi-blue">
        <div class="kpi-icon"><i class="fas fa-users"></i></div>
        <div class="kpi-body"><div class="kpi-val"><?= count($att) ?></div><div class="kpi-label">Total Records</div></div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-icon"><i class="fas fa-circle-check"></i></div>
        <div class="kpi-body"><div class="kpi-val"><?= $above ?></div><div class="kpi-label">Above 75%</div></div>
    </div>
    <div class="kpi-card kpi-red">
        <div class="kpi-icon"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="kpi-body"><div class="kpi-val"><?= $below ?></div><div class="kpi-label">Below 75%</div></div>
    </div>
    <div class="kpi-card kpi-purple">
        <div class="kpi-icon"><i class="fas fa-chart-line"></i></div>
        <div class="kpi-body"><div class="kpi-val"><?= $avg ?>%</div><div class="kpi-label">Class Average</div></div>
    </div>
</div>

<!-- Attendance Table -->
<div class="table-card">
    <div class="table-top">
        <h3>Attendance Records</h3>
        <div class="legend">
            <span class="leg-item"><span class="dot green"></span>≥75% (Safe)</span>
            <span class="leg-item"><span class="dot red"></span>&lt;75% (Short)</span>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr><th>Student</th><th>Roll No.</th><th>Subject</th><th>Present</th><th>Total</th><th>Percentage</th><th>Status</th></tr>
        </thead>
        <tbody>
        <?php foreach($att as $a): ?>
        <tr>
            <td><div class="student-cell"><div class="student-av"><?= strtoupper(substr($a['student'],0,1)) ?></div><?= htmlspecialchars($a['student']) ?></div></td>
            <td><code><?= htmlspecialchars($a['roll']) ?></code></td>
            <td><?= htmlspecialchars($a['subject']) ?></td>
            <td><?= $a['present'] ?></td>
            <td><?= $a['total'] ?></td>
            <td>
                <div class="progress-cell">
                    <div class="progress-bar">
                        <div class="progress-fill <?= $a['pct']>=75?'green':'red' ?>" style="width:<?= $a['pct'] ?>%"></div>
                    </div>
                    <span><?= $a['pct'] ?>%</span>
                </div>
            </td>
            <td>
                <?php if($a['pct']>=75): ?>
                <span class="badge badge-green"><i class="fas fa-check"></i> Regular</span>
                <?php else: ?>
                <span class="badge badge-red"><i class="fas fa-exclamation"></i> Short</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Mark Attendance Modal -->
<div class="modal-overlay" id="markModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Mark Today's Attendance</h3>
            <button class="modal-close" onclick="closeModal('markModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-form">
            <div class="form-row">
                <div class="form-group">
                    <label>Subject</label>
                    <select><option>DBMS</option><option>Networks</option><option>Circuits</option><option>AI/ML</option></select>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            <div class="att-mark-list">
                <?php foreach(getStudents() as $s): ?>
                <div class="att-row">
                    <div class="student-cell"><div class="student-av"><?= strtoupper(substr($s['name'],0,1)) ?></div><?= htmlspecialchars($s['name']) ?></div>
                    <div class="att-toggle">
                        <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                        <span class="toggle-label">Present</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('markModal')">Cancel</button>
                <button type="button" class="btn-primary" onclick="closeModal('markModal'); showToast('Attendance saved successfully!')"><i class="fas fa-save"></i> Save Attendance</button>
            </div>
        </div>
    </div>
</div>
