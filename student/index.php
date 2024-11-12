<?php
    $pageTitle = "Student Dashboard";
    include '../assets/partials/head.inc.php';
    include 'datacon.inc.php';

    $_SESSION['user_role'] = "student";
    $student_id = $_SESSION['user_id'] ?? 1;

    $studentInfoQuery = "  SELECT users.*, departments.department_name 
                            FROM users 
                            LEFT JOIN departments ON users.department_id = departments.department_id 
                            WHERE users.user_id = {$student_id}";
    // Assuming you have a connection to the database in $conn
    $studentInfoResult = $conn->query($studentInfoQuery);

   
?>

<body>
<!--Styles and theme to be added later -->

    <!-- Card showing student info -->
     <div class="card">
        <div class="card-body">
            <?php
                if ($studentInfoResult->num_rows > 0) {
                // Fetch the data
                while ($row = $studentInfoResult->fetch_assoc()) {
                    // Process each row
                    echo "User  ID: " . $row['user_id'] . "<br>"; 
                    //echo "Name: " . $row['full_name'] . "<br>";
                    echo "Email: " . $row['email'] . "<br>";
                    echo "Unique ID: " . ($row['UNIQUE_ID'] ?? "N/A") . "<br>";
                    echo "Department: " . $row['department_name'] . "<br>";

                    var_dump($_SESSION);
                }
            } else {
                echo "No results found.";
            }   
            ?>
        </div>
     </div>

    <button onclick = "openAvailableEvaluationsModal()">Take Evaluation</button>

    <!--Available Evaluations Modal -->
    <div class="modal fade" id="availableEvaluationsModal" tabindex="-1" aria-labelledby="availableEvaluationsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="availableEvaluationsModalLabel">Available Evaluations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select id="courseSelect" class="form-select">
                        <option value="">Select a course</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Evaluate</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    

    async function openAvailableEvaluationsModal() {
        const modal = new bootstrap.Modal(document.getElementById('availableEvaluationsModal'));
        modal.show();

        try {
            const response = await fetch('showAvailableEvaluations.inc.php'); // Ensure correct path
            const courses = await response.json();

            const selectElement = document.getElementById('courseSelect');
            selectElement.innerHTML = '<option value="">Select a course</option>'; // Reset options

            courses.forEach(course => {
                const option = document.createElement('option');
                option.value = course.id;
                option.textContent = course.name;
                selectElement.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching courses:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.btn-success').addEventListener('click', () => {
            const selectedCourseId = document.getElementById('courseSelect').value;

            if (!selectedCourseId) {
                alert('Please select a course to evaluate.');
                return;
            }

            const studentId = <?php echo json_encode($student_id); ?>;
            console.log("Student ID : ", studentId);
            console.log("Course ID : ", selectedCourseId);
            recordEvaluation(studentId, selectedCourseId);
        });
    });

    //var studentId = <?php echo $student_id ?>;
    //var courseId = selectedCourseId;

    async function recordEvaluation(studentId, courseId) {
        try {
            const response = await fetch('recordEvaluation.inc.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ student_id: studentId, course_id: courseId })
            });
            console.log(this.body);

            const result = await response.text();
            console.log("Evaluation recorded successfully:", result);
            window.location.href = `courseEvaluationPage.php?courseId=${courseId}`; 
        } catch (error) {
            console.error("Error recording evaluation:", error);
        }
    }
</script>


</html>