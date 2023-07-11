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


$TEACHER_ID = $_GET['id'];
$SUBJECT_ID = $_GET['sub'];
$CLASS_ID = $_GET['cls'];

$query="SELECT * FROM teacher WHERE teacher.id = $TEACHER_ID;";
$result = mysqli_query($conn , $query);
$teacher = mysqli_fetch_array($result);
$teacher_first_name = $teacher['first_name'];
$teacher_last_name = $teacher['last_name'];
$stmt = "UPDATE teacher_subject_class SET deleted = 1 , modified = NOW()
WHERE teacher_id = $TEACHER_ID AND subject_id = $SUBJECT_ID AND class_id = $CLASS_ID;";
mysqli_query($conn, $stmt);

$content = 'Subject (id = '.$SUBJECT_ID.') deleted for teacher '.$teacher_first_name.' '.$teacher_last_name;

$sql = "INSERT INTO notifications (user_type,user_id, title, content, viewed)
 VALUES ('manager',140842,'ViceManager deleted subject for teacher' , '$content' , 0);";
mysqli_query($conn, $sql);

header('Location: teacher-profile.php?id='.$TEACHER_ID);
exit;
?>