<?php
include_once 'includes/data.php';
session_start();

// Handle Add
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action'])) {
    $students = getStudents();
    if ($_POST['action']==='add') {
        $new = [
            'id'=>time(),
            'name'=>trim($_POST['name']),
            'roll'=>trim($_POST['roll']),
            'dept'=>trim($_POST['dept']),
            'year'=>(int)$_POST['year'],
            'email'=>trim($_POST['email']),
            'phone'=>trim($_POST['phone']),
            'status'=>$_POST['status']
        ];
        $_SESSION['students'][] = $new;
        $_SESSION['flash'] = ['type'=>'success','msg'=>'Student added successfully!'];
    } elseif($_POST['action']==='delete') {
        $id = (int)$_POST['id'];
        $_SESSION['students'] = array_values(array_filter($students, fn($s)=>$s['id']!==$id));
        $_SESSION['flash'] = ['type'=>'success','msg'=>'Student removed.'];
    }
    header('Location: ?page=students');
    exit;
}

$students = getStudents();
$search = trim($_GET['q']??'');
$deptFilter = $_GET['dept']??'';
if($search) $students = array_filter($students, fn($s)=>stripos($s['name'],$search)!==false||stripos($s['roll'],$search)!==false);
if($deptFilter) $students = array_filter($students, fn($s)=>$s['dept']===$deptFilter);
$depts = array_unique(array_column(getStudents(),'dept'));
$flash = $_SESSION['flash']??null; unset($_SESSION['flash']);
?>

<div class="page-header">
    <div>
        <h2 class="page-title">Student Management</h2>
        <p class="page-sub">Manage all student records, information, and enrollment status.</p>
    </div>
    <button class="btn-primary" onclick="openModal('addModal')"><i class="fas fa-plus"></i> Add Student</button>
</div>

<?php if($flash): ?>
<div class="alert alert-<?= $flash['type'] ?> fade-in"><i class="fas fa-circle-check"></i> <?= htmlspecialchars($flash['msg']) ?></div>
<?php endif; ?>

<!-- Filters -->
<div class="filter-bar">
    <form method="GET" class="filter-form">
        <input type="hidden" name="page" value="students">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="q" placeholder="Search by name or roll no..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <select name="dept" class="filter-select">
            <option value="">All Departments</option>
            <?php foreach($depts as $d): ?>
            <option value="<?= htmlspecialchars($d) ?>" <?= $deptFilter===$d?'selected':'' ?>><?= htmlspecialchars($d) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
        <a href="?page=students" class="btn-ghost">Clear</a>
    </form>
    <div class="filter-count"><?= count($students) ?> student(s)</div>
</div>

<!-- Table -->
<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th><th>Name</th><th>Roll No.</th><th>Department</th><th>Year</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($students as $s): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td>
                <div class="student-cell">
                    <div class="student-av"><?= strtoupper(substr($s['name'],0,1)) ?></div>
                    <strong><?= htmlspecialchars($s['name']) ?></strong>
                </div>
            </td>
            <td><code><?= htmlspecialchars($s['roll']) ?></code></td>
            <td><?= htmlspecialchars($s['dept']) ?></td>
            <td>Year <?= $s['year'] ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= htmlspecialchars($s['phone']) ?></td>
            <td><span class="badge <?= $s['status']==='Active'?'badge-green':'badge-red' ?>"><?= $s['status'] ?></span></td>
            <td>
                <div class="action-btns">
                    <button class="icon-btn blue" title="View"><i class="fas fa-eye"></i></button>
                    <form method="POST" style="display:inline" onsubmit="return confirm('Delete this student?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                        <button type="submit" class="icon-btn red" title="Delete"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($students)): ?>
        <tr><td colspan="9" class="empty-row"><i class="fas fa-inbox"></i> No students found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Add New Student</h3>
            <button class="modal-close" onclick="closeModal('addModal')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" class="modal-form">
            <input type="hidden" name="action" value="add">
            <div class="form-row">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" placeholder="e.g. Rahul Sharma" required>
                </div>
                <div class="form-group">
                    <label>Roll Number *</label>
                    <input type="text" name="roll" placeholder="e.g. CS2024001" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Department *</label>
                    <select name="dept" required>
                        <option value="">Select Department</option>
                        <option>Computer Science</option>
                        <option>Information Tech</option>
                        <option>Electronics</option>
                        <option>Mechanical</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <select name="year">
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
                        <option value="4">Year 4</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="student@edu.in">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" placeholder="9876543210">
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('addModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-plus"></i> Add Student</button>
            </div>
        </form>
    </div>
</div>
