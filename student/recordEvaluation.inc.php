<?php
session_start();
include_once 'datacon.inc.php';

// Set response headers to return JSON
header('Content-Type: application/json');

// Retrieve JSON data from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);

$student_id = $data['student_id'] ?? null;
$course_id = $data['course_id'] ?? null;

// Check if student_id and course_id are provided
if (!$student_id || !$course_id) {
    echo json_encode(["success" => false, "message" => "Student ID and Course ID are required."]);
    exit;
}

try {
    // Prepare the SQL statement
    $sql = "INSERT INTO evaluations (student_id, course_id) VALUES (?, ?)
            ON DUPLICATE KEY UPDATE evaluation_date = CURRENT_TIMESTAMP";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $student_id, $course_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Evaluation recorded successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
} finally {
    $conn->close();
}
