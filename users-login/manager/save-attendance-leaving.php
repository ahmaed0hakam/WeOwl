<?php
 include('../../config.php');

 session_start();
 if (!isset($_SESSION['id'])) {
     session_unset();
     session_destroy();
     header('Location: manager-login.php');
     exit;
 }
 $idcheck=$_SESSION['id'];
 
 $sql = "SELECT id FROM manager WHERE id = $idcheck";
 $result = mysqli_query($conn, $sql);
 
 if (!$result || mysqli_num_rows($result) == 0) {
     // Session id not found in the database, redirect to login page
     session_unset();
     session_destroy();
     header('Location: manager-login.php');
     exit;
 }
// Get the class ID from the query string
$CLASS_ID = $_GET['id'];


// Get the attendance data from the POST request
for($i=0;$i<count($_POST);$i++){
    $student_ids[] = $_POST[$i][0];
    $leaving_status[] = $_POST[$i][1];
    if($_POST[$i][1]=='yes'){
        $leaving_status[$i]='Left';
    }
    elseif($_POST[$i][1]=='no'){
        $leaving_status[$i]='Still';
    }
    $stmt = "SELECT * FROM attendance WHERE student_id = '$student_ids[$i]' AND class_id = '$CLASS_ID' AND dates = DATE(NOW())";
    $result = mysqli_query($conn, $stmt);


    if (mysqli_num_rows($result) > 0) {
        $temp = mysqli_fetch_assoc($result);
        if($temp['leaving_status'] == 'Still' && $leaving_status[$i]=='Left'){
        // Editing leaving status and time for student who recorded as still but he left
        $stmt = "UPDATE attendance SET leaving_status = '$leaving_status[$i]', leaving = TIME(NOW()) WHERE student_id = '$student_ids[$i]' AND class_id = '$CLASS_ID' AND dates = DATE(NOW())";
        mysqli_query($conn, $stmt);
    }
    if($temp['leaving_status'] == 'Left' && $leaving_status[$i]=='Still'){
        // Editing leaving status and time for mistake putting student as leave while he still
        $stmt = "UPDATE attendance SET leaving_status = '$leaving_status[$i]', leaving = TIME(NOW()) WHERE student_id = '$student_ids[$i]' AND class_id = '$CLASS_ID' AND dates = DATE(NOW())";
        mysqli_query($conn, $stmt);
    }
    if($temp['leaving_status'] == '' && $leaving_status[$i]=='Still'){
        // Adding leaving status and time for  student for first time as still
        $stmt = "UPDATE attendance SET leaving_status = '$leaving_status[$i]', leaving = TIME(NOW()) WHERE student_id = '$student_ids[$i]' AND class_id = '$CLASS_ID' AND dates = DATE(NOW())";
        mysqli_query($conn, $stmt);
    }
    if($temp['leaving_status'] == '' && $leaving_status[$i]=='Left'){
        // Adding leaving status and time for  student for first time as left
        $stmt = "UPDATE attendance SET leaving_status = '$leaving_status[$i]', leaving = TIME(NOW()) WHERE student_id = '$student_ids[$i]' AND class_id = '$CLASS_ID' AND dates = DATE(NOW())";
        mysqli_query($conn, $stmt);
    }
}
}

// Redirect back to the students list page
header('Location: students-list.php?id='.$CLASS_ID);
exit;
?>