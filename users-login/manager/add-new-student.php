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



$student_first_name = $_POST['first_name'];
$student_last_name = $_POST['last_name'];
$parent_first_name = $_POST['parentname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$class = $_POST['class'];
$section = $_POST['section'];
$pass = $_POST['password'];
$pass = password_hash($pass, PASSWORD_DEFAULT);
$addedby = $row['first_name'].$row['last_name'];

$query="SELECT class.id
FROM class
WHERE class.name = '$class';
";

$result = mysqli_query($conn , $query);
$class_id = mysqli_fetch_array($result);
$class_id = $class_id['id'];

$query="SELECT sections.id
FROM sections
WHERE sections.name = '$section';
";

$result = mysqli_query($conn , $query);
$section_id = mysqli_fetch_array($result);
$section_id = $section_id['id'];

$sql="SELECT id FROM student ORDER BY id DESC LIMIT 1;";
$result = mysqli_query($conn , $sql);
$student_id = mysqli_fetch_array($result);
$student_id = $student_id['id']+1;

$sql="SELECT id FROM parent ORDER BY id DESC LIMIT 1;";
$result = mysqli_query($conn , $sql);
$parent_id = mysqli_fetch_array($result);
$parent_id = $parent_id['id']+1;

$temp = "SELECT * FROM student JOIN parent ON student.id = parent.student_id
WHERE parent.email = '$email' AND student.deleted = 0 AND parent.deleted = 0";
 $result = mysqli_query($conn, $temp);
if (mysqli_num_rows($result) >= 1) {  
    $response =1;
 }
else{
$sql = "INSERT INTO add_new_student (added_by, 	class_id, student_id, class_name, section, first_name, last_name, parent_id, parent_name,parent_email,
parent_phone,parent_password,created)
 VALUES ('$addedby', $class_id, $student_id,'$class' , '$section' , '$student_first_name' , '$student_last_name' , $parent_id,  '$parent_first_name' 
 , '$email' , '$phone' , '$pass',NOW());";
mysqli_query($conn, $sql);

$sql = "INSERT INTO student (parent_id, first_name, last_name, class_id, class_name, section,section_id,created,modified)
 VALUES ($parent_id, '$student_first_name','$student_last_name' , $class_id , '$class' , '$section',section_id,NOW(),NOW());";
mysqli_query($conn, $sql);

$sql = "INSERT INTO parent (first_name, last_name, email, phone, parent_password, student_id,created,modified)
 VALUES ('$parent_first_name','$student_last_name' , '$email' , '$phone' , '$pass', $student_id,NOW(),NOW());";
mysqli_query($conn, $sql);

$response=0;}
echo json_encode(array('response' => $response));
exit;
?>