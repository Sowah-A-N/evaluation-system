<?php   
    session_start();
    include_once 'datacon.inc.php';
    $departmentId = $_SESSION['department_id']; // Assuming department_id is stored in session


    // Fetch courses for the department
    $sql = "SELECT id, name FROM courses WHERE department_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $departmentId);
    $stmt->execute();
    $result = $stmt->get_result();

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    $stmt->close();
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($courses);