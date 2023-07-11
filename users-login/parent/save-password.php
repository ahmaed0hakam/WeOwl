<?php
 include('../../config.php');

 session_start();
 if (!isset($_SESSION['id'])) {
     header('Location: parent-login.php');
     session_unset();
     session_destroy();
     exit;
 }
 
 $idcheck=$_SESSION['id'];
 
 $sql = "SELECT id FROM parent WHERE id = $idcheck";
 $result = mysqli_query($conn, $sql);
 
 if (!$result || mysqli_num_rows($result) == 0) {
     // Session id not found in the database, redirect to login page
     session_unset();
     session_destroy();
     header('Location: parent-login.php');
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

$PARENT_ID = $_GET['id'];
$parent_pass = $_POST['password'];
$parent_pass = password_hash($parent_pass, PASSWORD_DEFAULT);



$stmt = "UPDATE parent SET parent_password = '$parent_pass'
WHERE id = $PARENT_ID;";
mysqli_query($conn, $stmt);

header('Location: index.php?id='.$PARENT_ID);
exit;
?>