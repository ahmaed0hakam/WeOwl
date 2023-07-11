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
$addedby=$_SESSION['id'];
$query="SELECT manager.first_name, manager.last_name
FROM manager
WHERE manager.id = $addedby;
";

$result = mysqli_query($conn , $query);
$row = mysqli_fetch_array($result);

$teacher_first_name = $_POST['first-name'];
$teacher_last_name = $_POST['last-name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$subject = $_POST['subject'];
$class = $_POST['class'];
$pass = $_POST['password'];
$pass = password_hash($pass, PASSWORD_DEFAULT);
$addedby = $row['first_name'].' '.$row['last_name'];

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

$sql="SELECT id FROM teacher ORDER BY id DESC LIMIT 1;";
$result = mysqli_query($conn , $sql);
$teacher_id = mysqli_fetch_array($result);
$teacher_id = $teacher_id['id']+1;


$temp = "SELECT * FROM teacher WHERE email = '$email'";
$result = mysqli_query($conn, $temp);

$temp1 = "SELECT * FROM teacher_subject_class WHERE subject_id = $subject_id AND class_id = $class_id AND deleted = 0";
$result1 = mysqli_query($conn, $temp1);

if (mysqli_num_rows($result) >= 1) {
    $response =1;
}

elseif(mysqli_num_rows($result1) >= 1) {
    $response=2;
}

else{
$sql = "INSERT INTO add_new_teacher (added_by, 	teacher_id, subject_id, subject_name, class_id, class_name, first_name, last_name, email,
phone,teacher_password,created)
 VALUES ('$addedby', $teacher_id, $subject_id,'$subject', $class_id, '$class', '$teacher_first_name' , '$teacher_last_name' ,
 '$email' , '$phone' , '$pass',NOW());";
mysqli_query($conn, $sql);

$sql = "INSERT INTO teacher (first_name, last_name, email, phone, teacher_password,created,modified)
 VALUES ('$teacher_first_name','$teacher_last_name' , '$email' , '$phone' , '$pass', NOW(), NOW());";
mysqli_query($conn, $sql);

$sql = "INSERT INTO teacher_subject_class (teacher_id,teacher_name,subject_id,subject_name,class_id)
 VALUES ($teacher_id,'$teacher_first_name',$subject_id,'$subject',$class_id);";
mysqli_query($conn, $sql);

$response=0;}
echo json_encode(array('response' => $response));
exit;
?>