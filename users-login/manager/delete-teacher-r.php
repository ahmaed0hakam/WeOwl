<?php
 include('../../config.php');

 session_start();
 if (!isset($_SESSION['id'])) {
     header('Location: manager-login.php');
     session_unset();
     session_destroy();
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

$TEACHER_ID = $_GET['id'];


$stmt = "UPDATE teacher_subject_class SET deleted = 1 , modified = NOW()
WHERE teacher_id = $TEACHER_ID";
mysqli_query($conn, $stmt);

$stmt = "UPDATE teacher SET deleted = 1 , modified = NOW()
WHERE id = $TEACHER_ID";
mysqli_query($conn, $stmt);

header('Location: index.php?id='.$TEACHER_ID);
exit;
?>