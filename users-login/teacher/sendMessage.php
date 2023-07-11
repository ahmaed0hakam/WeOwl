<?php 
  include('../../config.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the message and other details from the form
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $parent_ID=$_POST['parent_id'];
    $teacher_ID=$_POST['teacher_id'];
    $publish_date = date('Y-m-d H:i:s'); // Get the current date and time
  
    // Insert the message into the Messages table
    $query = "INSERT INTO messages (messag, sender_id , receiver_id, publish_date) VALUES ('$message', '$teacher_ID', '$parent_ID', '$publish_date')";
    $result = mysqli_query($conn, $query);
  
    if ($result) {
      echo "Message stored successfully.";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  
    // Close the database connection here

  }?>
<form action="teacher-masseges.php" method="post" id="dataform" >
  <input hidden type="text" name="parent_id" id="parent_id" value="<?php echo $parent_ID ;?>" >
  <input hidden type="text" name="teacher_id" id="teacher_id" value="<?php echo $teacher_ID ;?>" >
  <button hidden type="submit" name="submitbtn" id="submitbtn" ></button>
</form>
<script>
    window.onload = function() {
      var button = document.getElementById('submitbtn');
      button.click();
    };
    </script>