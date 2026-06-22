<?php include_once 'includes/data.php'; $grades = getGrades(); ?>

<div class="page-header">
    <div>
        <h2 class="page-title">Grades & Performance</h2>
        <p class="page-sub">Track and manage student academic performance and grade reports.</p>
    </div>
    <button class="btn-primary" onclick="openModal('gradeModal')"><i class="fas fa-plus"></i> Add Grade</button>
</div>

<?php
$avgTotal = round(array_sum(array_column($grades,'total'))/count($grades));
$topStudent = $grades[array_search(max(array_column($grades,'total')), array_column($grades,'total'))];
$gradeCount = array_count_values(array_column($grades,'grade'));
arsort($gradeCount);
?>

<div class="kpi-grid four">
    <div class="kpi-card kpi-blue">
        <div class="kpi-icon"><i class="fas fa-star"></i></div>
        <div class="kpi-body"><div class="kpi-val"><?= $avgTotal ?></div><div class="kpi-label">Class Average</div></div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-icon"><i class="fas fa-trophy"></i></div>
        <div class="kpi-body"><div class="kpi-val"><?= $topStudent['total'] ?></div><div class="kpi-label">Highest Score</div><div class="kpi-trend neutral"><?= htmlspecialchars($topStudent['student']) ?></div></div>
    </div>
    <div class="kpi-card kpi-amber">
        <div class="kpi-icon"><i class="fas fa-medal"></i></div>
        <div class="kpi-body"><div class="kpi-val"><?= array_key_first($gradeCount) ?></div><div class="kpi-label">Most Common Grade</div></div>
    </div>
    <div class="kpi-card kpi-purple">
        <div class="kpi-icon"><i class="fas fa-percent"></i></div>
        <div class="kpi-body"><div class="kpi-val"><?= count(array_filter($grades,fn($g)=>$g['total']>=80)) ?></div><div class="kpi-label">Distinction (≥80)</div></div>
    </div>
</div>

<div class="table-card">
    <div class="table-top">
        <h3>Grade Sheet</h3>
        <div class="grade-legend">
            <span class="badge badge-green">A+ ≥ 90</span>
            <span class="badge badge-blue">A ≥ 80</span>
            <span class="badge badge-amber">B ≥ 70</span>
            <span class="badge badge-red">C &lt; 70</span>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr><th>Student</th><th>Roll No.</th><th>Subject</th><th>Mid (30)</th><th>End (50)</th><th>Practical (20)</th><th>Total (100)</th><th>Grade</th></tr>
        </thead>
        <tbody>
        <?php foreach($grades as $g): ?>
        <tr>
            <td><div class="student-cell"><div class="student-av"><?= strtoupper(substr($g['student'],0,1)) ?></div><?= htmlspecialchars($g['student']) ?></div></td>
            <td><code><?= htmlspecialchars($g['roll']) ?></code></td>
            <td><?= htmlspecialchars($g['subject']) ?></td>
            <td><?= $g['mid'] ?></td>
            <td><?= $g['end'] ?></td>
            <td><?= $g['practical'] ?></td>
            <td><strong><?= $g['total'] ?></strong></td>
            <td>
                <?php
                $gc = 'badge-amber';
                if($g['total']>=90) $gc='badge-green';
                elseif($g['total']>=80) $gc='badge-blue';
                elseif($g['total']<60) $gc='badge-red';
                ?>
                <span class="badge <?= $gc ?>"><?= $g['grade'] ?></span>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Grade Modal -->
<div class="modal-overlay" id="gradeModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Add / Update Grade</h3>
            <button class="modal-close" onclick="closeModal('gradeModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-form">
            <div class="form-row">
                <div class="form-group">
                    <label>Student</label>
                    <select><?php foreach(getStudents() as $s): ?><option><?= htmlspecialchars($s['name']) ?></option><?php endforeach; ?></select>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <select><option>DBMS</option><option>Networks</option><option>Circuits</option><option>AI/ML</option></select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Mid-Term (max 30)</label><input type="number" min="0" max="30" placeholder="0"></div>
                <div class="form-group"><label>End-Term (max 50)</label><input type="number" min="0" max="50" placeholder="0"></div>
                <div class="form-group"><label>Practical (max 20)</label><input type="number" min="0" max="20" placeholder="0"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('gradeModal')">Cancel</button>
                <button type="button" class="btn-primary" onclick="closeModal('gradeModal'); showToast('Grade saved successfully!')"><i class="fas fa-save"></i> Save Grade</button>
            </div>
        </div>
    </div>
</div>
