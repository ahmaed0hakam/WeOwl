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

$STUDENT_ID = $_GET['id'];

$first_name=$_POST['first-name'];
$last_name=$_POST['last-name'];
$parent_name=$_POST['parent-name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$class=$_POST['class'];
$section=$_POST['section'];

$stmt = "SELECT id FROM class WHERE name = '$class'";
$result = mysqli_query($conn, $stmt);
$row = mysqli_fetch_array($result);
$new_class_id=$row['id'];

$stmt = "SELECT id FROM sections WHERE name = '$section'";
$result = mysqli_query($conn, $stmt);
$row = mysqli_fetch_array($result);
$new_section_id=$row['id'];



$stmt = "UPDATE student SET first_name = '$first_name', last_name = '$last_name',
 class_id = $new_class_id, class_name = '$class', section_id = $new_section_id,section = '$section', modified =NOW()
WHERE id = $STUDENT_ID;";
mysqli_query($conn, $stmt);

$stmt = "UPDATE parent SET first_name = '$parent_name', last_name = '$last_name',
 email = '$email', phone = '$phone',modified =NOW()
WHERE student_id = $STUDENT_ID;";
mysqli_query($conn, $stmt);


header('Location: students-list.php?id='.$class);
exit;
?>