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

$TEACHER_ID = $_POST['id'];
$SUBJECT_ID = $_POST['sub'];
$CLASS_ID = $_POST['cls'];
$first_name=$_POST['first-name'];
$last_name=$_POST['last-name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$subject=$_POST['subject'];
$class=$_POST['class'];

$stmt = "SELECT id FROM subjects WHERE name = '$subject'";
$result = mysqli_query($conn, $stmt);
$row = mysqli_fetch_array($result);
$new_subject_id=$row['id'];

$stmt = "SELECT id FROM class WHERE name = '$class'";
$result = mysqli_query($conn, $stmt);
$row = mysqli_fetch_array($result);
$new_class_id=$row['id'];


$sql = "SELECT * FROM teacher_subject_class WHERE subject_id = $new_subject_id AND class_id = $new_class_id AND deleted=0";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) >= 1) {
    $response=2;
}

else{
$stmt = "UPDATE teacher SET first_name = '$first_name', last_name = '$last_name',
 email = '$email', phone = '$phone',modified =NOW()
WHERE id = $TEACHER_ID;";
mysqli_query($conn, $stmt);

$stmt = "UPDATE teacher_subject_class SET teacher_name = '$first_name',subject_id =$new_subject_id ,subject_name = '$subject', class_id = $new_class_id
WHERE teacher_id = $TEACHER_ID AND subject_id = $SUBJECT_ID AND class_id = $CLASS_ID;";
mysqli_query($conn, $stmt);

$response=0;}
echo json_encode(array('response' => $response));
exit;
?>