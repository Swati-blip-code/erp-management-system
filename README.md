# 🎓 EduERP — Student Management System

A multi-module ERP system for academic institutions featuring a professional dark-sidebar admin dashboard, real-time data visualizations, and comprehensive student lifecycle management.

## Screenshots

> Dashboard with live KPI cards, attendance bar chart, and grade distribution doughnut chart.

## Features

- **Dashboard Overview** — Live KPI cards showing total students, active count, average attendance, and department breakdown with Chart.js visualizations
- **Student Management** — Full CRUD operations with search, department filter, and enrollment status tracking
- **Attendance Tracking** — Per-subject attendance with automatic alerts for students below the 75% threshold
- **Grade Management** — Mid-term, end-term, and practical marks with automatic grade calculation
- **Schedule Management** — Class timetable and schedule organization
- **Role-Based User Access** — Admin and staff roles with different permission levels
- **Import / Export** — Bulk data management via CSV import and export
- **Reports** — Academic performance and attendance reports

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP |
| Frontend | HTML, CSS, Vanilla JavaScript |
| Charts | Chart.js |
| UI Fonts | Syne, DM Sans |
| Auth | PHP Sessions |
| Database | MySQL *(migration in progress)* |

## Project Structure

```
erp_system/
├── includes/
│   └── data.php          # Data layer (migrating to MySQL)
├── modules/
│   ├── dashboard.php     # KPI overview + Chart.js visualizations
│   ├── students.php      # Student CRUD with search and filters
│   ├── attendance.php    # Attendance tracking + 75% alert system
│   ├── grades.php        # Marks entry and grade calculation
│   ├── schedules.php     # Timetable management
│   ├── users.php         # Role-based user management
│   ├── import.php        # CSV bulk import/export
│   └── reports.php       # Academic reports
├── assets/
│   ├── css/style.css     # Professional dark-sidebar UI
│   └── js/app.js         # Client-side interactions
├── index.php             # Main layout with sidebar navigation
├── login.php             # Authentication
└── logout.php
```

## Getting Started

### Prerequisites
- XAMPP (or any PHP + Apache setup)
- PHP 7.4+

### Installation

```bash
# 1. Clone the repo
git clone https://github.com/Swati-blip-code/erp-management-system.git

# 2. Copy the folder to XAMPP's htdocs directory
# Windows: C:\xampp\htdocs\
# Mac/Linux: /opt/lampp/htdocs/

# 3. Start Apache in XAMPP Control Panel

# 4. Open in browser
http://localhost/erp_system
```

### Login Credentials

| Role | Username | Password |
|---|---|---|
| Admin | admin | admin123 |

*(Check login.php for credentials)*

## Modules Overview

### Dashboard
Real-time overview with 4 KPI cards and 2 Chart.js charts:
- Attendance bar chart with color-coded pass/fail (green ≥75%, red <75%)
- Grade distribution doughnut chart across all departments

### Student Management
- Add/delete students with department, year, email, phone, and enrollment status
- Search by name or roll number
- Filter by department
- Active/Inactive status badges

### Attendance
- Subject-wise attendance tracking
- Automatic low-attendance alert panel for students below 75%

### Grades
- Mid-term, end-term, and practical marks
- Automatic grade assignment (A+, A, B+, B, C...)

## Roadmap

- [x] Multi-module dashboard with data visualizations
- [x] Student CRUD with search and filter
- [x] Attendance tracking with threshold alerts
- [x] Role-based access control
- [ ] MySQL database integration *(in progress)*
- [ ] REST API layer
- [ ] Email notifications for low attendance
- [ ] PDF report generation
