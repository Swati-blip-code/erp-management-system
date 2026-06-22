<?php
$schedule = [
    'Monday'    => [['time'=>'9:00 - 10:00', 'sub'=>'DBMS','room'=>'CS-101','dept'=>'CS'],['time'=>'10:00 - 11:00','sub'=>'AI/ML','room'=>'CS-102','dept'=>'CS'],['time'=>'11:00 - 12:00','sub'=>'Networks','room'=>'IT-201','dept'=>'IT'],['time'=>'2:00 - 3:00','sub'=>'Circuits','room'=>'EC-301','dept'=>'EC']],
    'Tuesday'   => [['time'=>'9:00 - 10:00','sub'=>'AI/ML','room'=>'CS-102','dept'=>'CS'],['time'=>'10:00 - 11:00','sub'=>'DBMS','room'=>'CS-101','dept'=>'CS'],['time'=>'11:00 - 12:00','sub'=>'Circuits','room'=>'EC-301','dept'=>'EC']],
    'Wednesday' => [['time'=>'9:00 - 10:00','sub'=>'Networks','room'=>'IT-201','dept'=>'IT'],['time'=>'10:00 - 11:00','sub'=>'DBMS Lab','room'=>'CS-Lab','dept'=>'CS'],['time'=>'2:00 - 4:00','sub'=>'EC Lab','room'=>'EC-Lab','dept'=>'EC']],
    'Thursday'  => [['time'=>'9:00 - 10:00','sub'=>'AI/ML','room'=>'CS-102','dept'=>'CS'],['time'=>'10:00 - 11:00','sub'=>'Networks','room'=>'IT-201','dept'=>'IT'],['time'=>'11:00 - 12:00','sub'=>'Circuits','room'=>'EC-301','dept'=>'EC']],
    'Friday'    => [['time'=>'9:00 - 11:00','sub'=>'IT Lab','room'=>'IT-Lab','dept'=>'IT'],['time'=>'11:00 - 12:00','sub'=>'DBMS','room'=>'CS-101','dept'=>'CS'],['time'=>'2:00 - 3:00','sub'=>'Seminar','room'=>'Audi','dept'=>'All']],
];
$colors = ['CS'=>'blue','IT'=>'purple','EC'=>'amber','All'=>'green'];
$today = date('l');
?>

<div class="page-header">
    <div>
        <h2 class="page-title">Class Schedules</h2>
        <p class="page-sub">Weekly timetable and room allocations for all departments.</p>
    </div>
    <button class="btn-primary" onclick="openModal('scheduleModal')"><i class="fas fa-plus"></i> Add Schedule</button>
</div>

<div class="schedule-grid">
<?php foreach($schedule as $day => $classes): ?>
<div class="day-card <?= $day===$today?'today':'' ?>">
    <div class="day-header">
        <span class="day-name"><?= $day ?></span>
        <?php if($day===$today): ?><span class="badge badge-green">Today</span><?php endif; ?>
    </div>
    <div class="class-list">
    <?php foreach($classes as $c): ?>
    <div class="class-item <?= $colors[$c['dept']]??'blue' ?>-item">
        <div class="class-time"><i class="fas fa-clock"></i> <?= $c['time'] ?></div>
        <div class="class-sub"><?= htmlspecialchars($c['sub']) ?></div>
        <div class="class-meta">
            <span><i class="fas fa-door-open"></i> <?= $c['room'] ?></span>
            <span class="badge badge-<?= $colors[$c['dept']]??'blue' ?>"><?= $c['dept'] ?></span>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>
</div>

<!-- Add Schedule Modal -->
<div class="modal-overlay" id="scheduleModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Add New Class</h3>
            <button class="modal-close" onclick="closeModal('scheduleModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-form">
            <div class="form-row">
                <div class="form-group"><label>Day</label><select><option>Monday</option><option>Tuesday</option><option>Wednesday</option><option>Thursday</option><option>Friday</option></select></div>
                <div class="form-group"><label>Time Slot</label><input type="text" placeholder="e.g. 9:00 - 10:00"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Subject</label><input type="text" placeholder="Subject name"></div>
                <div class="form-group"><label>Room</label><input type="text" placeholder="Room number"></div>
            </div>
            <div class="form-group"><label>Department</label><select><option>CS</option><option>IT</option><option>EC</option><option>All</option></select></div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('scheduleModal')">Cancel</button>
                <button type="button" class="btn-primary" onclick="closeModal('scheduleModal'); showToast('Schedule added!')"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
