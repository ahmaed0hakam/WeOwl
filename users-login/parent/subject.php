<?php include('../../config.php');
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
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
      // User is trying to access another user's account, redirect to login page
      $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
      echo "<script>alert('{$_SESSION['error']}');</script>";
      echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
      exit;
  }
}

$subject_id=$_POST['tsc_id'];
//$qury="SELECT * FROM parent ";
$query="SELECT parent.id, parent.first_name, parent.last_name, parent.email, 
student.class_name,student.class_id as sci, student.section, student.first_name as student_first_name, 
student.last_name as student_last_name, student.id as std_id
FROM parent
JOIN student ON parent.id = student.parent_id
WHERE parent.id = $ID;
";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);

$first_name=$row['first_name'];
$student_id=$row['std_id'];
$class_id=$row['sci'];


$query="SELECT *
FROM teacher
JOIN teacher_subject_class ON teacher.id = teacher_subject_class.teacher_id
WHERE teacher_subject_class.subject_id = $subject_id AND teacher_subject_class.class_id=$class_id;
";

$r = mysqli_query($conn,$query);
if (!$r || mysqli_num_rows($r) == 0) {$teacher_email='No teacher';}
else{
$teacher = mysqli_fetch_array($r);
$teacher_email = $teacher['email'];
}
$query="SELECT *
FROM teacher_subject_class
WHERE teacher_subject_class.subject_id = $subject_id AND teacher_subject_class.class_id=$class_id;
";
$t = mysqli_query($conn,$query);
$TSC_ID = mysqli_fetch_array($t);
if (!$t || mysqli_num_rows($t) == 0) {$TSC_ID=404;}
else{
$TSC_ID = $TSC_ID['id'];
}
$query="SELECT *
FROM subjects WHERE subjects.id = $subject_id;
";
$t = mysqli_query($conn,$query);
$subject = mysqli_fetch_array($t);
$subject_name = $subject['name'];


$query="SELECT *
FROM teacher_subject_class
WHERE teacher_subject_class.id = $TSC_ID;
";

$t = mysqli_query($conn,$query);
if (!$t || mysqli_num_rows($t) == 0) {

$teacher_name='No teacher';
$teacher_id=123321;

$query="SELECT *
FROM posts
WHERE class_id = $class_id AND subjects_id = $subject_id;
";

$x = mysqli_query($conn,$query);
$posts = array();
if (mysqli_num_rows($x) > 0) {
    while ($post = mysqli_fetch_assoc($x)) {
        $posts[] = $post;
    }
}

$query="SELECT *
FROM grades where subject_id = $subject_id AND class_id = $class_id AND student_id = $student_id AND exam = 'first';
";
$rr = mysqli_query($conn,$query);
if (!$rr || mysqli_num_rows($rr) == 0) {
  $firstgrade['grade']='';
}else{
$firstgrade = mysqli_fetch_array($rr);
}
$query="SELECT *
FROM grades where subject_id = $subject_id AND class_id = $class_id AND student_id =$student_id AND exam='second';
";
$rr = mysqli_query($conn,$query);
if (!$rr || mysqli_num_rows($rr) == 0) {
  $secondgrade['grade']='';
}else{
$secondgrade = mysqli_fetch_array($rr);
}

$query="SELECT *
FROM grades where subject_id = $subject_id AND class_id = $class_id AND student_id =$student_id AND exam='final';
";
$rr = mysqli_query($conn,$query);
if (!$rr || mysqli_num_rows($rr) == 0) {
  $finalgrade['grade']='';
}else{
$finalgrade = mysqli_fetch_array($rr);
}
}
else{
$TSC = mysqli_fetch_array($t);
$subject_id=$TSC['subject_id'];
$subject_name=$TSC['subject_name'];
$teacher_name=$TSC['teacher_name'];
$class_id=$TSC['class_id'];
$teacher_id=$TSC['teacher_id'];

$query="SELECT *
FROM posts
WHERE class_id = $class_id AND subjects_id = $subject_id;
";

$x = mysqli_query($conn,$query);
$posts = array();
if (mysqli_num_rows($x) > 0) {
    while ($post = mysqli_fetch_assoc($x)) {
        $posts[] = $post;
    }
}

$query="SELECT *
FROM grades where subject_id = $subject_id AND class_id = $class_id AND student_id = $student_id AND exam = 'first';
";
$rr = mysqli_query($conn,$query);
if (!$rr || mysqli_num_rows($rr) == 0) {
  $firstgrade['grade']='';
}else{
$firstgrade = mysqli_fetch_array($rr);
}
$query="SELECT *
FROM grades where subject_id = $subject_id AND class_id = $class_id AND student_id =$student_id AND exam='second';
";
$rr = mysqli_query($conn,$query);
if (!$rr || mysqli_num_rows($rr) == 0) {
  $secondgrade['grade']='';
}else{
$secondgrade = mysqli_fetch_array($rr);
}

$query="SELECT *
FROM grades where subject_id = $subject_id AND class_id = $class_id AND student_id =$student_id AND exam='final';
";
$rr = mysqli_query($conn,$query);
if (!$rr || mysqli_num_rows($rr) == 0) {
  $finalgrade['grade']='';
}else{
$finalgrade = mysqli_fetch_array($rr);
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
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
  <script src="../../app/app.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Class Page</title>
    <link rel="stylesheet" href="parent-home.css/parent-home.css" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  </head>
  <body ng-controller="myController">
  <div ng-include="'../../views/headers/parent-header.php'"></div>
    <div class="sub-topoics-nav">
      <a href="#posts" class="sub-topoics">Posts</a>
      <a href="#grades" class="sub-topoics">Grades</a>
  </div>
    <div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3 id="modal-title"></h3>
    <div id="modal-content"></div>
  </div>
  </div>
    <section class="section posts" id="posts">
    <h1 class="welcome">
    Welcome Mr <?php echo $row['first_name']." "; ?><span class="child-name"><?php echo "(".$row['student_first_name']."'s"; ?> Parent <?php echo ") - SID(".$row['std_id'].")";?></span>
      </h1>

 
      <h2 class="title">Posts</h2>
      <p class="class">Subject: <?php echo $subject_name;?></p>
      <div class="message-teacher">       
        <?php if($teacher_id==123321){echo"<h3 style='display: inline'>Teacher: $teacher_name</h3>"."
        <form action='parent-masseges.php' method='post' id='messageform'>
        <input type='text' name='teacher_id' id='teacher_id' value=$teacher_id hidden>
        <input type='text' name='parent_id' id='parent_id' value=$ID hidden>
        <input type='text' name='tsc_id' id='tsc_id' value=$TSC_ID hidden>
        <button style='display: inline' disabled>Message</button></form>
       " ;}
        else{echo"<h3 style='display: inline'>Teacher: $teacher_name</h3>"."
        <form action='parent-masseges.php' method='post' id='messageform'>
        <input type='text' name='teacher_id' id='teacher_id' value=$teacher_id hidden>
        <input type='text' name='parent_id' id='parent_id' value=$ID hidden>
        <input type='text' name='tsc_id' id='tsc_id' value=$TSC_ID hidden>
        <button style='display: inline'>Message</button></form>
       " ;}?></div>


      <div class="view-posts">
        <div class="left-triangle"></div>
        <div class="posts-scroll">  
        <?php 
            if(count($posts)==0){
              echo '<style>.posts-scroll { justify-content: center; }
              .right-triangle, .left-triangle {
                display:none;
              }</style>';
          ?>
          <p>No Posts Yet</p>
          <?php } ?>
          <?php for($i=0;$i<count($posts);$i++){?>
          <div class="post post1">
            <div class="content"><?php echo $posts[$i]['description'] ;?></div>
            <p>publish date: <?php echo $posts[$i]['publish_date'] ;?></p>
          </div>
         <?php }?>
        </div>
        <div class="right-triangle"></div>
      </div>
    </section>
    <div class="sub-topoics-nav" style="height: 3px;">
  </div>
    <section class="section grades" id="grades">

 
      <h2 class="title">Grades</h2>
      <div class="buttons-scroll">

      <?php 
            if($firstgrade['grade']==NULL && $secondgrade['grade']==NULL && $finalgrade['grade']==NULL){
          ?>
          <a><button disabled >No Grades Yet</button></a>
          <?php } ?>
          
          <?php 
            if($firstgrade['grade']!=NULL){
          ?>
                <a>First Exam Grade:<button disabled ><?php echo $firstgrade['grade'];?></button></a>
          <?php } ?>
          <?php 
            if($secondgrade['grade']!=NULL){
          ?>
                <a>Second Exam Grade:<button disabled ><?php echo $secondgrade['grade'];?></button></a>
          <?php } ?>
          <?php 
            if($finalgrade['grade']!=NULL){
          ?>
                <a>Final Exam Grade:<button disabled ><?php echo $finalgrade['grade'];?></button></a>
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
      // function openEmail() {
        // window.open('mailto:<?php echo $teacher_email; ?>', '_blank');
      // }
      function openEmail(email) {
    window.open('mailto:' + email, '_blank');
 
}
</script>


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