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
$subject = $_POST['subject'];
$class = $_POST['class'];


$query="SELECT teacher.first_name
FROM teacher
WHERE teacher.id = $TEACHER_ID;";
$result = mysqli_query($conn , $query);
$teacher_first_name = mysqli_fetch_array($result);
$teacher_first_name = $teacher_first_name['first_name'];

$query="SELECT subjects.id
FROM subjects
WHERE subjects.name = '$subject';";
$result = mysqli_query($conn , $query);
$subject_id = mysqli_fetch_array($result);
$subject_id = $subject_id['id'];

$query="SELECT class.id
FROM class
WHERE class.name = '$class';";
$result = mysqli_query($conn , $query);
$class_id = mysqli_fetch_array($result);
$class_id = $class_id['id'];


$sql = "SELECT * FROM teacher_subject_class WHERE subject_id = $subject_id AND class_id = $class_id AND deleted=0";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) >= 1) {
    $response=2;
}

else{
$sql = "INSERT INTO teacher_subject_class (teacher_id,teacher_name,subject_id,subject_name,class_id)
 VALUES ($TEACHER_ID,'$teacher_first_name',$subject_id,'$subject',$class_id);";
mysqli_query($conn, $sql);

$response=0;}
echo json_encode(array('response' => $response));
exit;
?>