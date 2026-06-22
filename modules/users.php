<?php
$roles = [
    ['name'=>'Administrator','users'=>2,'color'=>'red','icon'=>'fa-shield-halved','perms'=>['Manage Students','Manage Staff','View Reports','Data Import/Export','User Management','System Settings']],
    ['name'=>'Teacher',      'users'=>8,'color'=>'blue','icon'=>'fa-chalkboard-teacher','perms'=>['View Students','Mark Attendance','Add Grades','View Reports']],
    ['name'=>'Student',      'users'=>count(isset($_SESSION['students'])?$_SESSION['students']:getStudents()),'color'=>'green','icon'=>'fa-user-graduate','perms'=>['View Own Profile','View Attendance','View Grades','View Schedule']],
];
$allUsers = [
    ['name'=>'Admin User',    'username'=>'admin',  'role'=>'Administrator','email'=>'admin@edu.in',  'status'=>'Active','last'=>'Today'],
    ['name'=>'Prof. Sharma',  'username'=>'teacher','role'=>'Teacher',      'email'=>'sharma@edu.in', 'status'=>'Active','last'=>'Yesterday'],
    ['name'=>'Rahul Verma',   'username'=>'student','role'=>'Student',      'email'=>'rahul@edu.in',  'status'=>'Active','last'=>'Today'],
    ['name'=>'Prof. Kapoor',  'username'=>'kapoor', 'role'=>'Teacher',      'email'=>'kapoor@edu.in', 'status'=>'Active','last'=>'2 days ago'],
    ['name'=>'Priya Singh',   'username'=>'priya',  'role'=>'Student',      'email'=>'priya@edu.in',  'status'=>'Inactive','last'=>'5 days ago'],
];
?>

<div class="page-header">
    <div>
        <h2 class="page-title">User Roles & Permissions</h2>
        <p class="page-sub">Manage system users, roles, and access permissions.</p>
    </div>
    <button class="btn-primary" onclick="openModal('userModal')"><i class="fas fa-plus"></i> Add User</button>
</div>

<!-- Role Cards -->
<div class="role-cards">
<?php foreach($roles as $r): ?>
<div class="role-card">
    <div class="role-icon <?= $r['color'] ?>"><i class="fas <?= $r['icon'] ?>"></i></div>
    <div class="role-info">
        <h3><?= $r['name'] ?></h3>
        <p><?= $r['users'] ?> user(s)</p>
    </div>
    <div class="role-perms">
        <?php foreach($r['perms'] as $p): ?>
        <div class="perm-item"><i class="fas fa-check-circle"></i> <?= $p ?></div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>
</div>

<!-- Users Table -->
<div class="table-card" style="margin-top:2rem">
    <div class="table-top"><h3>System Users</h3></div>
    <table class="data-table">
        <thead><tr><th>Name</th><th>Username</th><th>Role</th><th>Email</th><th>Last Login</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($allUsers as $u): ?>
        <tr>
            <td><div class="student-cell"><div class="student-av"><?= strtoupper(substr($u['name'],0,1)) ?></div><?= htmlspecialchars($u['name']) ?></div></td>
            <td><code><?= htmlspecialchars($u['username']) ?></code></td>
            <td>
                <?php $rc=['Administrator'=>'badge-red','Teacher'=>'badge-blue','Student'=>'badge-green']; ?>
                <span class="badge <?= $rc[$u['role']] ?>"><?= $u['role'] ?></span>
            </td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['last'] ?></td>
            <td><span class="badge <?= $u['status']==='Active'?'badge-green':'badge-red' ?>"><?= $u['status'] ?></span></td>
            <td><div class="action-btns"><button class="icon-btn blue" title="Edit"><i class="fas fa-pen"></i></button><button class="icon-btn red" title="Delete"><i class="fas fa-trash"></i></button></div></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add User Modal -->
<div class="modal-overlay" id="userModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Add New User</h3>
            <button class="modal-close" onclick="closeModal('userModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-form">
            <div class="form-row">
                <div class="form-group"><label>Full Name</label><input type="text" placeholder="Full name"></div>
                <div class="form-group"><label>Username</label><input type="text" placeholder="Username"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Email</label><input type="email" placeholder="Email address"></div>
                <div class="form-group"><label>Role</label><select><option>Administrator</option><option>Teacher</option><option>Student</option></select></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Password</label><input type="password" placeholder="Set password"></div>
                <div class="form-group"><label>Status</label><select><option>Active</option><option>Inactive</option></select></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('userModal')">Cancel</button>
                <button type="button" class="btn-primary" onclick="closeModal('userModal'); showToast('User created successfully!')"><i class="fas fa-save"></i> Create User</button>
            </div>
        </div>
    </div>
</div>
