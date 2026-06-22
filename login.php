<?php
session_start();
if (isset($_SESSION['user'])) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Demo credentials
    $users = [
        'admin'   => ['pass'=>'admin123',  'name'=>'Admin User',    'role'=>'Administrator'],
        'teacher' => ['pass'=>'teacher123','name'=>'Prof. Sharma',  'role'=>'Teacher'],
        'student' => ['pass'=>'student123','name'=>'Rahul Verma',   'role'=>'Student'],
    ];

    if (isset($users[$username]) && $users[$username]['pass'] === $password) {
        $_SESSION['user'] = ['name'=>$users[$username]['name'], 'role'=>$users[$username]['role'], 'username'=>$username];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduERP — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="login-body">

<div class="login-page">
    <div class="login-left">
        <div class="login-brand">
            <div class="brand-icon large"><i class="fas fa-graduation-cap"></i></div>
            <h1>EduERP</h1>
            <p>Student Management System</p>
        </div>
        <div class="login-features">
            <div class="feat-item"><i class="fas fa-users"></i> Student & Staff Management</div>
            <div class="feat-item"><i class="fas fa-calendar-check"></i> Attendance Tracking</div>
            <div class="feat-item"><i class="fas fa-chart-bar"></i> Grades & Performance</div>
            <div class="feat-item"><i class="fas fa-shield-halved"></i> Role-Based Access</div>
        </div>
        <div class="login-dots">
            <span></span><span></span><span></span>
        </div>
    </div>

    <div class="login-right">
        <div class="login-card">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your ERP account</p>
            </div>

            <?php if ($error): ?>
            <div class="alert alert-error"><i class="fas fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Enter username" value="<?= htmlspecialchars($_POST['username']??'') ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="pwd" placeholder="Enter password" required>
                        <button type="button" class="eye-btn" onclick="togglePwd()"><i class="fas fa-eye" id="eyeIcon"></i></button>
                    </div>
                </div>
                <button type="submit" class="btn-login">Sign In <i class="fas fa-arrow-right"></i></button>
            </form>

            <div class="demo-creds">
                <p class="demo-title"><i class="fas fa-info-circle"></i> Demo Credentials</p>
                <div class="cred-grid">
                    <div class="cred-item" onclick="fillCred('admin','admin123')">
                        <strong>admin</strong><span>admin123</span><em>Administrator</em>
                    </div>
                    <div class="cred-item" onclick="fillCred('teacher','teacher123')">
                        <strong>teacher</strong><span>teacher123</span><em>Teacher</em>
                    </div>
                    <div class="cred-item" onclick="fillCred('student','student123')">
                        <strong>student</strong><span>student123</span><em>Student</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePwd(){
    const i = document.getElementById('pwd');
    const e = document.getElementById('eyeIcon');
    i.type = i.type==='password'?'text':'password';
    e.className = i.type==='password'?'fas fa-eye':'fas fa-eye-slash';
}
function fillCred(u,p){
    document.querySelector('[name=username]').value=u;
    document.querySelector('[name=password]').value=p;
}
</script>
</body>
</html>
