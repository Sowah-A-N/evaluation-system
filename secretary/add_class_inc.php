<?php
include '../datacon.inc.php';

if (isset($_POST['add'])) {
    $class_name = mysqli_real_escape_string($conn, $_POST['name']);
    $department_id = mysqli_real_escape_string($conn, $_POST['department']);
    $programme = mysqli_real_escape_string($conn, $_POST['programme']);
    $class_start = mysqli_real_escape_string($conn, $_POST['date_start']);
    $class_end = mysqli_real_escape_string($conn, $_POST['date_end']);

    // Check for empty fields
    if (empty($class_name) || empty($department_id) || empty($programme) || empty($class_start) || empty($class_end)) {
        echo "<script>alert('Please check your details.'); window.location='add_class.php';</script>";
        exit();
    } else {
        // Check if Class Name already exists
        $checkClassQuery = "SELECT * FROM classes WHERE class_name = '$class_name'";
        $result = $conn->query($checkClassQuery);

        if ($result->num_rows > 0) {
            // Class Name already exists
            echo "<script>alert('Class Name already exists. Please enter a different one.'); window.location='add_class.php';</script>";
            exit();
        } else {
            // Insert new class record into the `classes` table
            $insert_query = "INSERT INTO classes (department_id, programme, class_year_start, class_year_end, class_name) 
                            VALUES ('$department_id', '$programme', '$class_start', '$class_end', '$class_name')";

            if ($conn->query($insert_query) === TRUE) {
                echo "<script>alert('New class added successfully.'); window.location='add_class.php';</script>";
            } else {
                echo "Error adding class: " . $conn->error;
            }
        }
    }
}
?>
