<?php
    // $servername = "localhost";
    // $user = "root";
    // $password = "";
    // $database = "mechi multiple campus";
    define("servername","localhost");
    define("username","root");
    define("password","");
    define("database","mechi multiple campus");
    // define("database","practice");
    
    function connect() {
        $conn = new mysqli(servername,username,password,database);

        if($conn -> connect_error){
            die("Connection Failed: " . $conn -> connect_error);
        }
        // echo "Connection Successful";
        return $conn;
    }

    // function user_login($username, $password) {
    //     $conn =connect();

    //     $sql = "select * from users where username = ? and password = ?";
    //     $pst = $conn->prepare($sql);
    //     $pst->bind_param("ss", $username, $password);
    //     $pst->execute();
    //     $result = $pst->get_result();

    //     if($username == "" || $password == ""){
    //         echo "Please fill both the fields";
    //     }
    //     else if($result -> num_rows == 1){
    //         $data = $result->fetch_assoc();
    //         $role=$data['user_type'];
    //         if($role == "teacher"){
    //             session_start();
    //             $_SESSION['username'] = $data['username'];
    //             header("location: ../template/teacher.php");
    //             exit();
    //         }
    //         else if($role == "student"){
    //             session_start();
    //             $_SESSION['username'] = $data['username'];
    //             header("location: ../template/student.html");
    //             exit();
    //         }
    //     } else {
    //         echo "Invalid credentials";
    //     }
    // }