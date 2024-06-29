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

$stmt = $conn->prepare("SELECT `student_name`, `roll_no`, `status` FROM `attendance` WHERE `program` = ? AND `semester` = ? AND `section` = ? AND `subject_code` = ? AND `created_on` = ?;");

$program = $_POST['program'];
$semester = $_POST['semester'];
$section = $_POST['section'];
$subject = $_POST['subject_code'];
$date = $_POST['date'];
$stmt->bind_param("sisss", $program, $semester, $section, $subject, $date);

$stmt->execute();
$result = $stmt->get_result();
$attendance = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($attendance);

$stmt->close();
$conn->close();
?>