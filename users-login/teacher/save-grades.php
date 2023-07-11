<?php
include('../../config.php');

session_start();
if (!isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
    header('Location: teacher-login.php');
    exit;
}
$idcheck=$_SESSION['id'];

$sql = "SELECT id FROM teacher WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Session id not found in the database, redirect to login page
    session_unset();
    session_destroy();
    header('Location: teacher-login.php');
    exit;
}

$teacher_id= mysqli_fetch_assoc($result);
$teacher_id = $teacher_id['id'];


if (isset($teacher_id)) {
  if ($teacher_id != $idcheck) {
      // User is trying to access another user's account, redirect to login page
      $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
      echo "<script>alert('{$_SESSION['error']}');</script>";
      echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
      exit;
  }
}
$class_id = $_POST['class-id'];
$subject_id = $_POST['subject-id'];
$exam = $_POST['exam'];
for($i=0;$i<count($_POST)-3;$i++){
    $student_ids[] = $_POST[$i][0];
    $grades[] = $_POST[$i][1];

    $stmt = "SELECT * FROM grades WHERE student_id = $student_ids[$i] AND class_id = $class_id AND subject_id = $subject_id AND exam = '$exam'";
    $result = mysqli_query($conn, $stmt);


    if (mysqli_num_rows($result) > 0) {
        $stmt = "UPDATE grades SET grade = $grades[$i] WHERE student_id = '$student_ids[$i]' AND class_id = $class_id AND subject_id = $subject_id AND exam = '$exam'";
        mysqli_query($conn, $stmt);
    }
    else{
        $query="SELECT * FROM student WHERE student.id = $student_ids[$i];";
            $t = mysqli_query($conn , $query);
            $student = mysqli_fetch_array($t);
            $student_first_name=$student['first_name'];
            $student_last_name=$student['last_name'];
            $parent_id = $student['parent_id'];
        $query="SELECT * FROM teacher_subject_class WHERE class_id = $class_id AND subject_id = $subject_id ;";
            $t = mysqli_query($conn , $query);
            $tsc = mysqli_fetch_array($t);
            $tsc_id = $tsc['id'];
            $teacher_id = $tsc['teacher_id'];
            $subject_name = $tsc['subject_name'];
            $query="SELECT * FROM teacher WHERE id = $teacher_id;";
            $t = mysqli_query($conn , $query);
            $teacher = mysqli_fetch_array($t);
            $teacher_first_name = $teacher['first_name'];
            $teacher_last_name = $teacher['last_name'];
        $sql = "INSERT INTO grades (grade, exam, student_id,student_first_name,student_last_name,class_id,subject_id,subject_name,teacher_id,teacher_first_name,teacher_last_name,tsc_id) VALUES ($grades[$i], '$exam',$student_ids[$i],'$student_first_name','$student_last_name',$class_id,$subject_id,'$subject_name',$teacher_id,'$teacher_first_name','$teacher_last_name',$tsc_id)";
        mysqli_query($conn, $sql);

        $content = 'Teacher '.$teacher_first_name.' '.$teacher_last_name.' '.'Added '.$exam.' exam grade for '.$subject_name.' subject';

        $sql = "INSERT INTO notifications (user_type,user_id, title, content, viewed)
        VALUES ('parent',$parent_id,'New Grade added' , '$content' , 0);";
        mysqli_query($conn, $sql);
    }
}

?>
