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


  $ID=$_POST['class_id'];
  $teacher_ID=$_POST['teacher_id'];
  $subjects_id=$_POST['subject_id'];


  if (isset($teacher_ID)) {
    if ($teacher_ID != $idcheck) {
        // User is trying to access another user's account, redirect to same page
        $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
        echo "<script>alert('{$_SESSION['error']}');</script>";
        echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
        exit;
    }
  }
// Check if form is submitted

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Include database connection file
  //include_once 'db_connect.php';
 // Update with your own db connection file

  // Get form data
  $description = $_POST['post'];
  $publish_date = date('Y-m-d'); // Update with appropriate date format
  $class_id = $ID; // Update with appropriate class ID
//   $subjects_id=$row['subjects_id'];
//   $teacher_id=$row['teacher_id'];

  // Insert data into database
  //$query = "INSERT INTO posts (description, publish_date, class_id, subjects_id, teacher_id) VALUES ($description, $publish_date, $class_id, $subjects_id, $teacher_id)";
  //$stmt = $conn->prepare($query);
  //$stmt->bind_param("sssii", $description, $publish_date, $class_id, $subjects_id, $teacher_id);
  //$stmt->execute();
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $query = "INSERT INTO posts (`description`, publish_date, class_id, subjects_id, teacher_id) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssii", $description, $publish_date, $class_id, $subjects_id, $teacher_ID);
  if ($stmt->execute()) {
    echo "Data inserted successfully!";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
  ?>
<form action="students-list.php#posts" method="post" id="dataform" >
  <input hidden type="text" name="class_id" id="class_id" value="<?php echo $class_id ;?>" >
  <input hidden type="text" name="teacher_id" id="teacher_id" value="<?php echo $teacher_ID ;?>" >
  <input hidden type="text" name="subject_id" id="subject_id" value="<?php echo $subjects_id ;?>" >
  <button hidden type="submit" name="submitbtn" id="submitbtn" ></button>
</form>
<script>
    window.onload = function() {
      var button = document.getElementById('submitbtn');
      button.click();
    };
  </script>
  <?php
}
?>
