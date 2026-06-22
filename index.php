<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduERP — Student Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="brand-text">
            <span class="brand-name">EduERP</span>
            <span class="brand-sub">Management System</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>
        <a href="?page=dashboard" class="nav-item <?= $page=='dashboard'?'active':'' ?>">
            <i class="fas fa-th-large"></i><span>Dashboard</span>
        </a>
        <a href="?page=students" class="nav-item <?= $page=='students'?'active':'' ?>">
            <i class="fas fa-user-graduate"></i><span>Students</span>
        </a>
        <a href="?page=attendance" class="nav-item <?= $page=='attendance'?'active':'' ?>">
            <i class="fas fa-calendar-check"></i><span>Attendance</span>
        </a>
        <a href="?page=grades" class="nav-item <?= $page=='grades'?'active':'' ?>">
            <i class="fas fa-chart-bar"></i><span>Grades</span>
        </a>

        <div class="nav-section-label">Administration</div>
        <a href="?page=schedules" class="nav-item <?= $page=='schedules'?'active':'' ?>">
            <i class="fas fa-clock"></i><span>Schedules</span>
        </a>
        <a href="?page=users" class="nav-item <?= $page=='users'?'active':'' ?>">
            <i class="fas fa-users-cog"></i><span>User Roles</span>
        </a>
        <a href="?page=import" class="nav-item <?= $page=='import'?'active':'' ?>">
            <i class="fas fa-file-import"></i><span>Import / Export</span>
        </a>
        <a href="?page=reports" class="nav-item <?= $page=='reports'?'active':'' ?>">
            <i class="fas fa-file-chart-column"></i><span>Reports</span>
        </a>

        <div class="nav-section-label">Account</div>
        <a href="logout.php" class="nav-item nav-logout">
            <i class="fas fa-right-from-bracket"></i><span>Logout</span>
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar"><?= strtoupper(substr($user['name'],0,1)) ?></div>
        <div class="user-info">
            <span class="user-name"><?= htmlspecialchars($user['name']) ?></span>
            <span class="user-role"><?= htmlspecialchars($user['role']) ?></span>
        </div>
    </div>
</aside>

<!-- Main Content -->
<div class="main-wrapper">
    <header class="topbar">
        <button class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        <div class="topbar-title">
            <?php
            $titles = ['dashboard'=>'Dashboard','students'=>'Students','attendance'=>'Attendance','grades'=>'Grades','schedules'=>'Schedules','users'=>'User Roles','import'=>'Import / Export','reports'=>'Reports'];
            echo $titles[$page] ?? 'Dashboard';
            ?>
        </div>
        <div class="topbar-right">
            <div class="notif-btn"><i class="fas fa-bell"></i><span class="notif-dot"></span></div>
            <div class="topbar-avatar"><?= strtoupper(substr($user['name'],0,1)) ?></div>
        </div>
    </header>

    <main class="content-area">
        <?php
        $allowed = ['dashboard','students','attendance','grades','schedules','users','import','reports'];
        $page = in_array($page, $allowed) ? $page : 'dashboard';
        include "modules/{$page}.php";
        ?>
    </main>
</div>

<script src="assets/js/app.js"></script>
</body>
</html>
