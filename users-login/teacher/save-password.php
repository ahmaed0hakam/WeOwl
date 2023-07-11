<?php
 include('../../config.php');

 session_start();
 if (!isset($_SESSION['id'])) {
     header('Location: teacher-login.php');
     session_unset();
     session_destroy();
     exit;
 }
 
 $idcheck=$_SESSION['id'];
 
 $sql = "SELECT id FROM teacher WHERE id = $idcheck";
 $result = mysqli_query($conn, $sql);
 
 if (!$result || mysqli_num_rows($result) == 0) {
     // Session id not found in the database, redirect to login page
     session_unset();
     session_destroy();
     header('Location: teacher-login.php');
     exit;
 }

 $ID = $_GET['id'];
 if (isset($ID)) {
    if ($ID != $idcheck) {
        // User is trying to access another user's account, redirect to login page
        $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
        echo "<script>alert('{$_SESSION['error']}');</script>";
        echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
        exit;
    }
  }

$TEACHER_ID = $_GET['id'];
$teacher_pass = $_POST['password'];
$teacher_pass = password_hash($teacher_pass, PASSWORD_DEFAULT);



$stmt = "UPDATE teacher SET teacher_password = '$teacher_pass'
WHERE id = $TEACHER_ID;";
mysqli_query($conn, $stmt);

header('Location: index.php?id='.$TEACHER_ID);
exit;
?>