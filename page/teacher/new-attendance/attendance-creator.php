<?php
require('../../../src/functions.php');
$conn = connect();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $program = $_POST['program'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $subject_code = $_POST['subject_code'];
    // echo $program."<br>".$semester."<br>".$section."<br>".$subject_code;
    $student_names = $_POST['name'];
    $student_status = $_POST['status'];
    $original_date = date("y-m-d");
    // echo $original_date;
    foreach($student_status as $key => $array){
        foreach($array as $value){
            $name = $student_names[$key-1];
            $status = $value;
            $roll_no = $key;
            // echo $name."<br>".$roll_no."<br>".$status."<br>";

            $insert_query = "insert into `attendance` (program, semester, section, subject_code, student_name, roll_no, status, original_date) values (?, ?, ?, ?, ?, ?, ?, ?)";
            $pst = $conn -> prepare($insert_query);
            $pst -> bind_param("sisssiss", $program, $semester, $section, $subject_code, $name, $roll_no, $status,$original_date);
            $pst -> execute();
            if($pst){
                echo "<script>alert('Attendace submitted successfully!');</script>";
                echo "<script>window.open('../../../template/teacher.php','_self');</script>";
            }
            else {
                echo "Error: " . $conn -> error;
            }
        }
    }
}
