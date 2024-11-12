<?php
class ClassManagement
{
    private $conn;
    private $error;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getError()
    {
        return $this->error;
    }

    public function addClass($className, $classYear, $departmentId)
    {
        $stmt = $this->conn->prepare("INSERT INTO classes (class_name, class_year, department_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $className, $classYear, $departmentId);

        if ($stmt->execute()) {
            return true;
        } else {
            $this->error = $stmt->error;
            return false;
        }
    }

    public function assignStudentsToClass($classId, $studentIds)
    {
        $this->conn->begin_transaction();

        try {
            foreach ($studentIds as $studentId) {
                $stmt = $this->conn->prepare("INSERT INTO class_student (class_id, student_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $classId, $studentId);
                $stmt->execute();
                $stmt->close();
            }
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function getAllStudents()
    {
        $result = $this->conn->query("SELECT student_id, first_name, last_name FROM students");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllDepartments()
    {
        $result = $this->conn->query("SELECT department_id, department_name FROM departments");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}