<?php include('../../config.php');
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
session_start();
if (!isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
    header('Location: vicemanager-login.php');
    exit;
}
$idcheck=$_SESSION['id'];

$sql = "SELECT id FROM vice WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Session id not found in the database, redirect to login page
    session_unset();
    session_destroy();
    header('Location: vicemanager-login.php');
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
$query="SELECT * FROM teacher WHERE teacher.id = $TEACHER_ID;";
$result = mysqli_query($conn , $query);
$teacher = mysqli_fetch_array($result);
$teacher_first_name = $teacher['first_name'];
$teacher_last_name = $teacher['last_name'];

$sql = "SELECT * FROM teacher_subject_class WHERE subject_id = $subject_id AND class_id = $class_id AND deleted=0";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) >= 1) {
    $response=2;
}

else{
$sql = "INSERT INTO teacher_subject_class (teacher_id,teacher_name,subject_id,subject_name,class_id)
 VALUES ($TEACHER_ID,'$teacher_first_name',$subject_id,'$subject',$class_id);";
mysqli_query($conn, $sql);

$content = 'New subject has been added to teacher '.$teacher_first_name.' '.$teacher_last_name;

$sql = "INSERT INTO notifications (user_type,user_id, title, content, viewed)
 VALUES ('manager',140842,'ViceManager added a new subject to teacher' , '$content' , 0);";
mysqli_query($conn, $sql);

$response=0;}
echo json_encode(array('response' => $response));
exit;
?>