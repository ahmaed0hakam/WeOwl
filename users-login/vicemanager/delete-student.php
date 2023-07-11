<?php include('../../config.php');


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
$STUDENT_ID = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM student WHERE id = ?");
$stmt->bind_param("i", $STUDENT_ID);
$stmt->execute();
$result = $stmt->get_result();
$student = mysqli_fetch_assoc($result);

$stmt = "UPDATE student SET deleted = 1 , modified = NOW()
WHERE id = $STUDENT_ID;";
mysqli_query($conn, $stmt);
$stmt = "UPDATE parent SET deleted = 1 , modified = NOW()
WHERE student_id = $STUDENT_ID;";
mysqli_query($conn, $stmt);

$content = 'Student '.$student_first_name.' '.$student_last_name.' '.' has been deleted';

$sql = "INSERT INTO notifications (user_type,user_id, title, content, viewed)
 VALUES ('manager',140842,'ViceManager deleted a student' , '$content' , 0);";
mysqli_query($conn, $sql);

header('Location: students-list.php?id='.$student['class_id']);
exit;
?>