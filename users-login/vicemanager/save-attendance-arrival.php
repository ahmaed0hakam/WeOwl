<?php
 include('../../config.php');

 session_start();
 if (!isset($_SESSION['id'])) {
     session_unset();
     session_destroy();
     header('Location: vicemanager-login.php');
     exit;
 }
 $idcheck=$_SESSION['id'];
 
 $sql = "SELECT id FROM vice WHERE id = $idcheck";
 $result = mysqli_query($conn, $sql);
 
 if (!$result || mysqli_num_rows($result) == 0) {
     // Session id not found in the database, redirect to login page
     session_unset();
     session_destroy();
     header('Location: vicemanager-login.php');
     exit;
 }

// Get the class ID from the query string
$CLASS_ID = $_GET['id'];


// Get the attendance data from the POST request
for($i=0;$i<count($_POST);$i++){
    $student_ids[] = $_POST[$i][0];
    $arrival_status[] = $_POST[$i][1];
    if($_POST[$i][1]=='yes'){
        $arrival_status[$i]='Arrived';
    }
    elseif($_POST[$i][1]=='no'){
        $arrival_status[$i]='Absent';
    }
    $stmt = "SELECT * FROM attendance WHERE student_id = '$student_ids[$i]' AND class_id = '$CLASS_ID' AND dates = DATE(NOW())";
    $result = mysqli_query($conn, $stmt);


    if (mysqli_num_rows($result) > 0) {
        $temp = mysqli_fetch_assoc($result);
        if(($temp['arrival_status'] == 'Absent'||$temp['arrival_status'] == '') && $arrival_status[$i]=='Arrived'){
        // Editing Attendance for student who came late  
        $stmt = "UPDATE attendance SET arrival_status = '$arrival_status[$i]', arrival = TIME(NOW()) WHERE student_id = '$student_ids[$i]' AND class_id = '$CLASS_ID' AND dates = DATE(NOW())";
        mysqli_query($conn, $stmt);
    }
    if(($temp['arrival_status'] == 'Arrived'||$temp['arrival_status'] == '') && $arrival_status[$i]=='Absent'){
        // Editing Attendance for student who recorded as Arrived while he is not
        $stmt = "UPDATE attendance SET arrival_status = '$arrival_status[$i]', arrival = TIME(NOW()) WHERE student_id = '$student_ids[$i]' AND class_id = '$CLASS_ID' AND dates = DATE(NOW())";
        mysqli_query($conn, $stmt);
    }}
    else{
        $sql = "INSERT INTO attendance (student_id, class_id, arrival_status,dates,arrival,leaving) VALUES ('$student_ids[$i]', '$CLASS_ID','$arrival_status[$i]' ,DATE(NOW()),TIME(NOW()),0)";
        mysqli_query($conn, $sql);
    }
}

// Redirect back to the students list page
header('Location: index.php');
exit;
?>