<?php 
  include('../../config.php');
  header("Cache-Control: no cache");
  session_cache_limiter("private_no_expire");
  //$TSC_ID=$_POST['tsc_id'];

//   $query="SELECT *
// FROM teacher_subject_class
// WHERE teacher_subject_class.id = $TSC_ID;
// ";

// $t = mysqli_query($conn,$query);
// $TSC = mysqli_fetch_array($t);
// $subject_id=$TSC['subject_id'];
// $subject_name=$TSC['subject_name'];
// $teacher_name=$TSC['teacher_name'];
// $class_id=$TSC['class_id'];
// $teacher_id=$TSC['teacher_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the message and other details from the form
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $parent_ID=$_POST['parent_id'];
    $teacher_ID=$_POST['teacher_id'];
    $publish_date = date('Y-m-d H:i:s'); // Get the current date and time
  
    // Insert the message into the Messages table
    $query = "INSERT INTO messages (messag, sender_id , receiver_id, publish_date) VALUES ('$message', '$parent_ID', '$teacher_ID', '$publish_date')";
    $result = mysqli_query($conn, $query);
  
    if ($result) {
      echo "Message stored successfully.";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  ?>
<form action="parent-masseges.php" method="post" id="dataform" >
  <!-- <input hidden type="text" name="class_id" id="class_id" value="<?php echo $class_id ;?>" > -->
  <input hidden type="text" name="teacher_id" id="teacher_id" value="<?php echo $teacher_ID ;?>" >
  <!-- <input hidden type="text" name="subject_id" id="subject_id" value="<?php echo $subjects_id ;?>" > -->
  <!-- <input hidden type="text" name="tsc_id" id="tsc_id" value="<?php echo $TSC_ID ;?>" > -->
  <input hidden type="text" name="parent_id" id="parent_id" value="<?php echo $parent_ID ;?>" >
  <button hidden type="submit" name="submitbtn" id="submitbtn" ></button>
</form>
<script>
    window.onload = function() {
      var button = document.getElementById('submitbtn');
      button.click();
    };
  </script>

<?php
    // Close the database connection here
  }

?>