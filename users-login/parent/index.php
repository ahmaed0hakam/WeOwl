<?php
 include('../../config.php');


 session_start();
 if (!isset($_SESSION['id'])) {
     session_unset();
     session_destroy();
     header('Location: parent-login.php');
     exit;
 }
 $idcheck=$_SESSION['id'];
 
 
 $sql = "SELECT id FROM parent WHERE id = $idcheck";
 $result = mysqli_query($conn, $sql);
 
 if (!$result || mysqli_num_rows($result) == 0) {
     // Session id not found in the database, redirect to login page
     session_unset();
     session_destroy();
     header('Location: parent-login.php');
     exit;
 }


 $ID=$_GET['id'];

 if (isset($ID)) {
  if ($ID != $idcheck) {
      // User is trying to access another user's account, redirect to same page with alert
      $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
      echo "<script>alert('{$_SESSION['error']}');</script>";
      echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
      exit;
  
  }
}

 //$query= "SELECT * FROM parent  WHERE id= $ID ";
 $query="SELECT * FROM student
 WHERE student.parent_id = $ID;
 ";
  $t = mysqli_query($conn , $query);
  $student = mysqli_fetch_array($t);
  $student_class_id=$student['class_id'];

$query="SELECT parent.id, parent.first_name, parent.last_name, parent.email, 
student.class_name, student.section, student.first_name as student_first_name, 
student.last_name as student_last_name
FROM parent
JOIN student ON parent.id = student.parent_id
WHERE parent.id = $ID;
";


 $result = mysqli_query($conn , $query);
 $row = mysqli_fetch_array($result);

 $sql = "SELECT * FROM teacher_subject_class 
 WHERE class_id=$student_class_id AND deleted=0 ORDER BY subject_id;
";
$r = mysqli_query($conn, $sql);

// Store the rs in an array
$subjects = array();
if (mysqli_num_rows($r) > 0) {
    while ($subj = mysqli_fetch_assoc($r)) {
        $subjects[] = $subj;
    }
}

$sql = "SELECT * FROM subjects 

";
$resulta = mysqli_query($conn, $sql);

// Store the results in an array
$subjectss = array();
if (mysqli_num_rows($resulta) > 0) {
   while ($subjj = mysqli_fetch_assoc($resulta)) {
       $subjectss[] = $subjj;
   }
}

$sql1 = "SELECT * FROM notifications WHERE user_type ='parent' AND user_id = $idcheck ORDER BY id DESC";
$result10 = mysqli_query($conn, $sql1);
$notifications = array();
if (mysqli_num_rows($result10) > 0) {
    while ($notification = mysqli_fetch_assoc($result10)) {
        $notifications[] = $notification;
    }
}

?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
  <script src="../../app/app.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>parent Home</title>
    <link rel="stylesheet" href="parent-home.css/parent-home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="../../images/logo/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="../../images/logo/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../../images/logo/favicon-16x16.png"
    />
    <link rel="manifest" href="/site.webmanifest" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
      crossorigin="anonymous"
    />
  </head>
  <body ng-controller="myController">
  <div ng-include="'../../views/headers/parent-header.php'"></div>
    <div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3 id="modal-title"></h3>
    <div id="modal-content"></div>
  </div>
  </div>
    <section class="section classes">
      <h1 class="welcome">
        Welcome Mr <?php echo $row['first_name']." "; ?><span class="child-name"><?php echo "(".$row['student_first_name']."'s"; ?> Parent <?php echo ") - SID(".$student['id'].")";?></span>
      </h1>
      <h2 class="title">Subjects</h2>
      <p class="class">Class:  <?php echo $row['class_name']."(".$row['section'].")"; ?></p>
      <div class="buttons-scroll">
        <?php 
        for ($i = 0; $i < count($subjectss); $i++) {
          $subject_id = $subjectss[$i]['id'];
          ?>

          <form action="subject.php?id=<?php echo $ID;?>" method="post">
            <input type="hidden" name="tsc_id" id="tsc_id" value="<?php echo $subjectss[$i]['id'];?>" >
            <button type="submit" name="sub" id="sub" ><?php  echo $subjectss[$i]['name'];?></button>
          </form>
     <?php } ?>

      </div>
    </section>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"
    ></script>
    <div ng-include="'../../views/footer.html'"></div>
  </body>
</html>

<script>

<?php
  $sql1 = "SELECT * FROM notifications WHERE user_type ='parent' AND user_id = $idcheck AND viewed = 0";
  $result10 = mysqli_query($conn, $sql1);
  
  if (mysqli_num_rows($result10) >= 1) {
    $newNotifications = true;} 
  else $newNotifications=false;
?>

// JavaScript code to update the notification bell
document.addEventListener('DOMContentLoaded', function() {
  var notificationBell = document.querySelector('.notification');
  var badge = notificationBell.querySelector('.badge');

  // Update the bell's appearance based on the newNotifications variable
  if (<?php echo $newNotifications ? 'true' : 'false'; ?>) {
    badge.style.display = 'block';
  } else {
    badge.style.display = 'none';
  }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
  var notificationBell = document.querySelector('.notification');
  var badge = notificationBell.querySelector('.badge');
  var notificationPopup = notificationBell.querySelector('.notification-popup');

  // Set initial display state of the notification popup
  notificationPopup.style.display = 'none';

  // Update the badge and show/hide the notification popup when the bell is clicked
  notificationBell.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the link from navigating

    // Toggle the visibility of the notification popup
    if (window.getComputedStyle(notificationPopup).display === 'none') {
      notificationPopup.style.display = 'block';

    } else {
      notificationPopup.style.display = 'none';
      
    }
  });

});
</script>

<script>

function openModal(id, title, content) {
  // Make an AJAX request to the server-side script
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "view_notification.php", true); // Replace "update_database.php" with your server-side script URL
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Send the data to the server-side script
  var data = "id=" + encodeURIComponent(id) + "&title=" + encodeURIComponent(title);
  xhr.send(data);
  // Handle the response from the server-side script if needed
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Handle the response here
      console.log(xhr.responseText);
      var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var closeBtn = document.getElementsByClassName("close")[0];

// Set the title in the modal
var modalTitle = document.getElementById("modal-title");
modalTitle.innerText = title;
var modalContent = document.getElementById("modal-content");
modalContent.innerText = content;
// Display the modal
modal.style.display = "block";

// Close the modal when the user clicks on the close button
closeBtn.onclick = function() {
  modal.style.display = "none";
};

// Close the modal when the user clicks anywhere outside of the modal
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
    } else {
      console.error("Request failed. Status: " + xhr.status);
    }
  };
}

</script>