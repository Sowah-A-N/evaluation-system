<?php
    echo '<script>alert("Responses have been submitted.")</script>';

    // Assuming a MySQL connection is already established
    $data = json_decode(file_get_contents('php://input'), true);

    foreach ($data['responses'] as $response) {
        $question_id = intval($response['question_id']);
        $answer = mysqli_real_escape_string($conn, $response['answer']);
        
        $query = "INSERT INTO evaluation_answers (question_id, answer) VALUES ($question_id, '$answer')";
        mysqli_query($conn, $query);
    }

    echo json_encode(['success' => true]);
