<?php
session_start();
include_once 'datacon.inc.php';

$courseId = intval($_GET['courseId']); // Ensure the course ID is an integer

// Prepare the SQL statement to prevent SQL injection
$courseDetailsQuery = $conn->prepare("SELECT course_code, name FROM courses WHERE id = ?");
$courseDetailsQuery->bind_param("i", $courseId); // "i" denotes the type is integer

// Execute the statement
$courseDetailsQuery->execute();

// Get the result
$courseDetailsResult = $courseDetailsQuery->get_result();

// Retrieve questions specific to a course, if applicable, otherwise get all questions
$evaluationQuestionsQuery = "SELECT question_id, question_text, question_type, is_required, category 
                             FROM evaluation_questions"; // Adjust if needed based on table structure

$evaluationQuestionsResult = mysqli_query($conn, $evaluationQuestionsQuery);

$questions = [];
if ($evaluationQuestionsResult) {
    while ($row = mysqli_fetch_assoc($evaluationQuestionsResult)) {
        $questions[] = $row;
    }
} else {
    echo "Error: " . mysqli_error($conn); // Debugging statement
}

//json_encode($questions, JSON_INVALID_UTF8_IGNORE); // Output the questions in JSON format
//echo json_encode(array_map(utf8_encode, $questions));
//echo json_last_error_msg(); // Print out the error if any
//die();
// Output as JSON
echo "<script>const questions = " . json_encode($questions, JSON_INVALID_UTF8_IGNORE) . ";</script>";

// Close the database connection
$conn->close();
?>

<body>
    <div class="container">
        <?php
            if ($courseDetailsResult->num_rows > 0) {
                // Fetch the course details
                $courseDetails = $courseDetailsResult->fetch_assoc();
                
                // Display the course details (example)
                echo "Course Code: " . $courseDetails['course_code'] . "<br /><br />";
                echo "Course Name: " . $courseDetails['name'] . "<br>";
                echo "<hr />";
                // Add more fields as necessary
            } else {
                echo "No course found with the given ID.";
            }
        ?>
        <div id="questions-container"></div>

        <script>
        document.addEventListener("DOMContentLoaded", () => {
            const container = document.getElementById("questions-container");

            questions.forEach(question => {
                const questionDiv = document.createElement("div");
                questionDiv.classList.add("question");

                // Question text
                const questionLabel = document.createElement("label");
                questionLabel.innerText = question.question_text;
                questionLabel.setAttribute("for", `question-${question.question_id}`);
                questionDiv.appendChild(questionLabel);

                // Input field based on question type
                let input;
                switch (question.question_type) {
                    case 'text':
                        input = document.createElement("textarea");
                        input.id = `question-${question.question_id}`;
                        input.required = question.is_required ? true : false; // Set as Boolean
                        break;
                    case 'rating':
                        input = document.createElement("input");
                        input.type = "range";
                        input.min = 1;
                        input.max = 5;
                        input.id = `question-${question.question_id}`;
                        input.required = question.is_required ? true : false;
                        break;
                    case 'yes_no':
                        input = document.createElement("select");
                        input.id = `question-${question.question_id}`;
                        input.required = question.is_required ? true : false;
                        ["Yes", "No"].forEach(optionText => {
                            const option = document.createElement("option");
                            option.value = optionText.toLowerCase();
                            option.innerText = optionText;
                            input.appendChild(option);
                        });
                        break;
                    case 'dropdown':
                        input = document.createElement("select");
                        input.id = `question-${question.question_id}`;
                        input.required = question.is_required ? true : false;
                        ["Very Easy", "Easy", "Moderate", "Hard", "Very Hard"].forEach(optionText => {
                            const option = document.createElement("option");
                            option.value = optionText.toLowerCase();
                            option.innerText = optionText;
                            input.appendChild(option);
                        });
                        break;
                    // Additional cases if needed
                }

                questionDiv.appendChild(input);
                container.appendChild(questionDiv);
            });
        });
        </script>
       
       <button id="submit-btn">Submit</button>
      
        <script>
            document.getElementById("submit-btn").addEventListener("click", () => {
                const responses = questions.map(question => {
                    const input = document.getElementById(`question-${question.question_id}`);
                    return {
                        question_id: question.question_id,
                        answer: input ? input.value : ""
                    };
                });

                // Send responses to the server (e.g., via AJAX)
                fetch('submitEvaluationResponses.inc.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ responses })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Thank you for your responses!");
                    } else {
                        alert("There was an error. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error));
            });
            </script>
    </div>
</body>
