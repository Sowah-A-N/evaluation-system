<?php
include '../datacon.inc.php';

// Fetch the current semester and academic year
$semesterQuery = $conn->query("SELECT semester_name, semester_value FROM active_semester LIMIT 1");
$semester = $semesterQuery->fetch_assoc();

// Fetch the number of students in the secretary's department (assuming department_id is known)
$department_id = 1;  // replace with actual department ID
$studentsQuery = $conn->prepare("SELECT COUNT(*) as student_count FROM users WHERE department_id = ?");
$studentsQuery->bind_param("i", $department_id);
$studentsQuery->execute();
$studentsQuery->bind_result($studentCount);
$studentsQuery->fetch();
$studentsQuery->close();

// Fetch the number of advisors
$advisorRoleId = 2;  // assuming role_id 2 is for advisors, replace with actual value
$advisorsQuery = $conn->prepare("SELECT COUNT(*) as advisor_count FROM users WHERE role_id = ?");
$advisorsQuery->bind_param("i", $advisorRoleId);
$advisorsQuery->execute();
$advisorsQuery->bind_result($advisorCount);
$advisorsQuery->fetch();
$advisorsQuery->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secretary Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Secretary Dashboard</h1>
    
    <!-- Navigation Menu -->
    <nav class="nav-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="add_class.php">Add Class</a>
        <a href="add_programme.php">Add Programme</a>
        <a href="add_courses.php">Add Courses</a>
        <a href="assign_advisor.php">Assign Advisor</a>
        <a href="reports.php">Reports</a>
        <a href="account_settings.php">Account Settings</a>
        <a href="response_summary.php">Response Summary</a>
        <a href="student_list.php">Student List</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="dashboard-section">
        <h2>Current Semester</h2>
        <p>Semester: <?php echo $semester['semester_name']; ?></p>
        <p>Academic Year: <?php echo $semester['semester_value']; ?></p>
    </div>
    <div class="dashboard-section">
        <h2>Students in Department</h2>
        <p>Total Students: <?php echo $studentCount; ?></p>
    </div>
    <div class="dashboard-section">
        <h2>Advisors</h2>
        <p>Total Advisors: <?php echo $advisorCount; ?></p>
    </div>
</body>
</html>

