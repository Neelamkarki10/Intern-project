<?php
function getClasses() {
    require_once 'databaseManager.php';
    $conn = establishConnectionToDB();
    if ($conn->connect_error) {
    die('Connection to database failed!');
    }

    $stmt = $conn->prepare("SELECT `program`, `semester`, `section`, `subject_code`, `subject_title` FROM `subject-teacher` WHERE `teacher_name` = ?;");
    $stmt->bind_param("s", $_SESSION['user_name']);
    $stmt->execute();
    $result = $stmt->get_result();
    $classes = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    return $classes;
}

?>