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

  $sql = "SELECT * FROM manager WHERE id = $idcheck";
  $result = mysqli_query($conn, $sql);
  $manager = mysqli_fetch_assoc($result);


$MANAGER_ID = $_GET['id'];
$manager_phone = $_POST['phone'];
$manager_email = $_POST['email'];
$manager_pass = $_POST['password'];
if($manager_pass==''){
    if($manager_phone==$manager['phone']){
        if($manager_email==$manager['email']){
        exit;
        }
        else{
            $stmt = "UPDATE manager SET email = '$manager_email'
            WHERE id = $MANAGER_ID;";
        mysqli_query($conn, $stmt);  
        }
    }
    else{
        if($manager_email==$manager['email']){
        $stmt = "UPDATE manager SET phone = '$manager_phone'
            WHERE id = $MANAGER_ID;";
        mysqli_query($conn, $stmt);}
        else{
            $stmt = "UPDATE manager SET phone = '$manager_phone' , email = '$manager_email'
            WHERE id = $MANAGER_ID;";
        mysqli_query($conn, $stmt);
        }
    }
}
else{
    if($manager_phone!=$manager['phone']){
        if($manager_email==$manager['email']){
            $manager_pass = password_hash($manager_pass, PASSWORD_DEFAULT);
            $stmt = "UPDATE manager SET password = '$manager_pass' , phone = '$manager_phone'
            WHERE id = $MANAGER_ID;";
            mysqli_query($conn, $stmt);}
        else{
            $manager_pass = password_hash($manager_pass, PASSWORD_DEFAULT);
            $stmt = "UPDATE manager SET password = '$manager_pass' , phone = '$manager_phone' , email = '$manager_email'
            WHERE id = $MANAGER_ID;";
            mysqli_query($conn, $stmt);
        }
    }
    else{
        if($manager_email==$manager['email']){
            $manager_pass = password_hash($manager_pass, PASSWORD_DEFAULT);
            $stmt = "UPDATE manager SET password = '$manager_pass'
            WHERE id = $MANAGER_ID;";
            mysqli_query($conn, $stmt);
        }
        else{
            $manager_pass = password_hash($manager_pass, PASSWORD_DEFAULT);
            $stmt = "UPDATE manager SET password = '$manager_pass', email = '$manager_email'
            WHERE id = $MANAGER_ID;";
            mysqli_query($conn, $stmt);
        }
    }

}
header('Location: edit-password.php?id='.$MANAGER_ID);
exit;
?>