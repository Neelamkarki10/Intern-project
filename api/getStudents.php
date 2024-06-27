<?php
session_start();
if (!isset($_SESSION['user_name']) || ($_SESSION['user_role'] != 'teacher')) {
  die('ERROR 403: Unauthorized Access');
}

require_once '../src/databaseManager.php';
$conn = establishConnectionToDB();
if ($conn->connect_error) {
  die('Connection to database failed!');
}

$stmt = $conn->prepare("SELECT `roll_no`, `student_name` FROM `students` WHERE `program` = ? AND `semester` = ? AND `section` = ? ;");

$program = $_POST['program'];
$semester = $_POST['semester'];
$section = $_POST['section'];
$stmt->bind_param("sis", $program, $semester, $section);

$stmt->execute();
$result = $stmt->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($students);

$stmt->close();
$conn->close();
?>