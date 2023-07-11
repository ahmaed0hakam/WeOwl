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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $postID = mysqli_real_escape_string($conn, $_POST['post_id']);

  // Delete post from database
  $query = "DELETE FROM posts WHERE id='$postID'";
  if (mysqli_query($conn, $query)) {
    echo 'Post deleted successfully';
  } else {
    echo 'Error deleting post: ' . mysqli_error($conn);
  }
}
?>