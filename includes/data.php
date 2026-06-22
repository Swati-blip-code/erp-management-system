<?php
// Mock data store (session-based for demo)
function getStudents() {
    if (!isset($_SESSION['students'])) {
        $_SESSION['students'] = [
            ['id'=>1,'name'=>'Aarav Sharma',   'roll'=>'CS2021001','dept'=>'Computer Science','year'=>3,'email'=>'aarav@edu.in',  'phone'=>'9876543210','status'=>'Active'],
            ['id'=>2,'name'=>'Priya Singh',    'roll'=>'CS2021002','dept'=>'Computer Science','year'=>3,'email'=>'priya@edu.in',  'phone'=>'9876543211','status'=>'Active'],
            ['id'=>3,'name'=>'Rohan Gupta',    'roll'=>'IT2022001','dept'=>'Information Tech', 'year'=>2,'email'=>'rohan@edu.in',  'phone'=>'9876543212','status'=>'Active'],
            ['id'=>4,'name'=>'Sneha Patel',    'roll'=>'IT2022002','dept'=>'Information Tech', 'year'=>2,'email'=>'sneha@edu.in',  'phone'=>'9876543213','status'=>'Inactive'],
            ['id'=>5,'name'=>'Vikram Reddy',   'roll'=>'EC2023001','dept'=>'Electronics',      'year'=>1,'email'=>'vikram@edu.in', 'phone'=>'9876543214','status'=>'Active'],
            ['id'=>6,'name'=>'Ananya Joshi',   'roll'=>'EC2023002','dept'=>'Electronics',      'year'=>1,'email'=>'ananya@edu.in', 'phone'=>'9876543215','status'=>'Active'],
            ['id'=>7,'name'=>'Karan Mehta',    'roll'=>'CS2020001','dept'=>'Computer Science','year'=>4,'email'=>'karan@edu.in',  'phone'=>'9876543216','status'=>'Active'],
            ['id'=>8,'name'=>'Divya Nair',     'roll'=>'CS2020002','dept'=>'Computer Science','year'=>4,'email'=>'divya@edu.in',  'phone'=>'9876543217','status'=>'Active'],
        ];
    }
    return $_SESSION['students'];
}

function getAttendance() {
    return [
        ['student'=>'Aarav Sharma',  'roll'=>'CS2021001','subject'=>'DBMS',      'present'=>22,'total'=>25,'pct'=>88],
        ['student'=>'Priya Singh',   'roll'=>'CS2021002','subject'=>'DBMS',      'present'=>24,'total'=>25,'pct'=>96],
        ['student'=>'Rohan Gupta',   'roll'=>'IT2022001','subject'=>'Networks',  'present'=>18,'total'=>25,'pct'=>72],
        ['student'=>'Sneha Patel',   'roll'=>'IT2022002','subject'=>'Networks',  'present'=>15,'total'=>25,'pct'=>60],
        ['student'=>'Vikram Reddy',  'roll'=>'EC2023001','subject'=>'Circuits',  'present'=>23,'total'=>25,'pct'=>92],
        ['student'=>'Ananya Joshi',  'roll'=>'EC2023002','subject'=>'Circuits',  'present'=>20,'total'=>25,'pct'=>80],
        ['student'=>'Karan Mehta',   'roll'=>'CS2020001','subject'=>'AI/ML',     'present'=>21,'total'=>25,'pct'=>84],
        ['student'=>'Divya Nair',    'roll'=>'CS2020002','subject'=>'AI/ML',     'present'=>25,'total'=>25,'pct'=>100],
    ];
}

function getGrades() {
    return [
        ['student'=>'Aarav Sharma', 'roll'=>'CS2021001','subject'=>'DBMS',    'mid'=>72,'end'=>80,'practical'=>88,'total'=>80,'grade'=>'B+'],
        ['student'=>'Priya Singh',  'roll'=>'CS2021002','subject'=>'DBMS',    'mid'=>88,'end'=>91,'practical'=>95,'total'=>91,'grade'=>'A'],
        ['student'=>'Rohan Gupta', 'roll'=>'IT2022001','subject'=>'Networks','mid'=>65,'end'=>70,'practical'=>75,'total'=>70,'grade'=>'B'],
        ['student'=>'Sneha Patel', 'roll'=>'IT2022002','subject'=>'Networks','mid'=>55,'end'=>60,'practical'=>65,'total'=>60,'grade'=>'C'],
        ['student'=>'Vikram Reddy','roll'=>'EC2023001','subject'=>'Circuits','mid'=>82,'end'=>85,'practical'=>90,'total'=>85,'grade'=>'A-'],
        ['student'=>'Ananya Joshi','roll'=>'EC2023002','subject'=>'Circuits','mid'=>78,'end'=>80,'practical'=>85,'total'=>80,'grade'=>'B+'],
        ['student'=>'Karan Mehta', 'roll'=>'CS2020001','subject'=>'AI/ML',  'mid'=>90,'end'=>93,'practical'=>96,'total'=>93,'grade'=>'A+'],
        ['student'=>'Divya Nair',  'roll'=>'CS2020002','subject'=>'AI/ML',  'mid'=>85,'end'=>88,'practical'=>92,'total'=>88,'grade'=>'A'],
    ];
}
