<?php include('../../config.php');
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
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
$subject_id=$_POST['subject_id'];

if (isset($teacher_ID)) {
  if ($teacher_ID != $idcheck) {
      // User is trying to access another user's account, redirect to same page
      $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
      echo "<script>alert('{$_SESSION['error']}');</script>";
      echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
      exit;
  }
}



$stmt = $conn->prepare("SELECT * FROM teacher_subject_class WHERE subject_id = ? AND teacher_id = ? AND class_id = ? ");
$stmt->bind_param("iii", $subject_id,$teacher_ID,$ID);
$stmt->execute();
$r = $stmt->get_result();
$subject = mysqli_fetch_assoc($r);
$subject_name = $subject['subject_name'];
$teacher = $subject['teacher_name'];

//$qury="SELECT * FROM parent ";
// $query="SELECT parent.id, parent.first_name, parent.last_name, parent.email, 
// student.class_name, student.section, student.first_name as student_first_name, 
// student.last_name as student_last_name
// FROM parent
// JOIN student ON parent.id = student.parent_id
// WHERE parent.id = $ID;
// ";

// $query = "SELECT parent.id, parent.first_name, parent.last_name, parent.email as parent_email, 
//          student.class_name, student.section, student.first_name as student_first_name, 
//          student.last_name as student_last_name
//          FROM parent
//          JOIN student ON parent.id = student.parent_id
//          WHERE parent.id = $ID";

$query = "SELECT parent.id, parent.email AS parent_email, parent.first_name, parent.last_name, student.first_name AS student_first_name, student.last_name AS student_last_name
          FROM parent
          JOIN student ON parent.student_id = student.id
          JOIN class ON student.class_id = class.id
          WHERE class.id = $ID AND student.deleted = 0";


$result = mysqli_query($conn , $query);

if (!$result) {
  die('Error executing query: ' . mysqli_error($conn));
}

$query2 = "SELECT description,id FROM posts WHERE class_id = $ID AND teacher_id = $teacher_ID AND subjects_id=$subject_id";
$result2 = mysqli_query($conn , $query2);





$result3 = mysqli_query($conn , $query);
  $emails = array();
  while ($row = mysqli_fetch_assoc($result3)) {
    $emails[] = $row['parent_email'];
    $emails_str = implode(',', $emails);
  }
 // $emails_str = implode(',', $emails);



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
    <title>Class Page</title>
    <link rel="stylesheet" href="teacher.css/teacher-home.css" />
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
  <div ng-include="'../../views/headers/teacher-header.php'"></div>
    <div class="sub-topoics-nav">
      <a href="#students-list" class="sub-topoics">Students List</a>
      <a href="#posts" class="sub-topoics">Post</a>
  </div>
    <section class="section students" id="students-list">
      <h1 class="welcome">Welcome Teacher <?php echo $teacher;?> !</h1>
      <h2 class="title"><?php echo $subject_name .' - '.$ID.' - ';?>Students List</h2>
      <div class="menu">

        <div class="dropstart">
  <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Add grades
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#"></a></li>
    <li><a class="dropdown-item" href="#" onclick="submitGrade('first')">1st Exam</a></li>
    <li><a class="dropdown-item" href="#" onclick="submitGrade('second')">2nd Exam</a></li>
    <li><hr class="dropdown-divider" /></li>
    <li><a class="dropdown-item" href="#" onclick="submitGrade('final')">Final Exam</a></li>
  </ul>
</div>
        <div class="dropstart">
          <button
            class="dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            Notify parents
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"></a></li>
            <!--<li><a class="dropdown-item" href="#">1st Exam</a></li>-->
            <li><a class="dropdown-item" href="#" onclick="sendMessage('<?php echo $emails_str;?>','Dear parents\n\n this is to inform you that the first exam marks for <?php echo $subject_name ;?> have been handed over to the students. Please check your child\'s progress and take necessary actions if needed.\n\n Thank you.')">1st Exam</a></li>
            <li><a class="dropdown-item" href="#" onclick="sendMessage('<?php echo $emails_str;?>','Dear parents\n\n this is to inform you that the second exam marks for <?php echo $subject_name ;?> have been handed over to the students. Please check your child\'s progress and take necessary actions if needed.\n\n Thank you.')">2nd Exam</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="#"  onclick="sendMessage('<?php echo $emails_str;?>','Dear parents\n\n this is to inform you that the final exam marks for <?php echo $subject_name ;?> have been handed over to the students. Please check your child\'s progress and take necessary actions if needed.\n\n Thank you.')">Final Exam</a></li>
          </ul>
        </div>
      </div>
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Message Parent</th>
            </tr>
          </thead>
          <tbody>

          <?php
          while(($row = mysqli_fetch_assoc($result))>0) {
            $parent_email = $row['parent_email'];
            $parent_id= $row['id'];

            $student_first_name = $row['student_first_name'];
            $student_last_name = $row['student_last_name'];
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          echo " <tr>
          <td>$student_first_name $student_last_name  </td>
          <td>
          <form action='teacher-masseges.php' method='post' id='messageform'>
          <input type='text' name='parent_id' id='parent_id' value=$parent_id hidden >
          <input type='text' name='teacher_id' id='teacher_id' value=$teacher_ID hidden >
          <input type='text' name='subject_id' id='teacher_id' value=$subject_id hidden >
          <input type='text' name='class_id' id='teacher_id' value=$ID hidden >
          <button>Message</button>
          </form>
          </td>
        </tr>";
          }
        ?>
          </tbody>
        </table>
      </div>
    </section>
    <div style="background-color: #0d121b; width: 100%; height: 2px"></div>
    <section class="section posts" id="posts">
      <div class="add-post">
        <article>
          <form id="handleform" action="handle_form.php" method="POST" >
            <label for="post" >
              <span>Add Event-Announcement...</span>
              <textarea name="post" id="post" cols="30" rows="10" placeholder= "Dear parents" required ></textarea>
            </label>
            <input type="hidden" name="class_id" value="<?php echo $ID; ?>">
            <input type="hidden" name="teacher_id" value="<?php echo $teacher_ID; ?>">
            <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
            <input type="submit" id="send" value="Post" />
          </form>
        </article>
      </div>
      <div style="background-color: #0d121b; width: 2px; height: 100%"></div>
      <div class="view-posts">
        <h2 class="posts-title">Posts</h2>
        <div class="posts-scroll">
          <?php

if ($result2) {

  while (($row = mysqli_fetch_assoc($result2))) {
    $description = $row['description'];
    $postID = $row['id'];
    echo "<div class='post post1'>
          <div class='content no-wrap-textarea'>$description</div>
          <button class='delete-post' data-post-id='$postID'>Delete</button>
        </div>";
  }
} else {

  echo "Error: " . mysqli_error($conn);
}
?>



        </div>
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
        // window.open('mailto:<?php echo $parent_email; ?>', '_blank');
      // }
      function openEmail(email) {
    window.open('mailto:' + email, '_blank');
 
}
function sendMessage(email,message) {
  //var message = 'Dear parents, this is to inform you that the first exam will be held on 1st May. Please ensure that your child is prepared for it.';
  window.open('mailto:' + email + '?subject=exam marks have been handed over &body=' + encodeURIComponent(message), '_blank'); 
}
  </script>



<script>
  // Get all delete buttons
  const deleteButtons = document.querySelectorAll('.delete-post');
  
  // Loop through delete buttons and add click event listener
  deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Get post ID from data attribute
      const postID = button.getAttribute('data-post-id');
      
      // Send AJAX request to delete post
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Reload page to show updated posts list
          location.reload();
        }
      };
      xhr.open('POST', 'delete-post.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send(`post_id=${postID}`);
    });
  });

  
  function handleform() {
  var form = document.getElementById("handleform");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Grades added successfully.'
          });
    }
  };
  xhr.send(new FormData(form));}


  function handlegrade() {
  var form = document.getElementById("first");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      alert("Attendance submitted successfully");
      form.reset();
    }
  };
  xhr.send(new FormData(form));}

  function handlegrade() {
  var form = document.getElementById("second");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      alert("Attendance submitted successfully");
      form.reset();
    }
  };
  xhr.send(new FormData(form));}
  function handlegrade() {
  var form = document.getElementById("final");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      alert("Attendance submitted successfully");
      form.reset();
    }
  };
  xhr.send(new FormData(form));}

  function submitGrade(exam) {
    var id = "<?php echo $ID ;?>";
    var si = "<?php echo $subject_id ;?>";
    
    // Perform any additional validation or data manipulation if needed
    
    // Create a form dynamically
    var form = document.createElement('form');
    form.action = 'add-grades.php';
    form.method = 'post';
    
    // Create hidden input fields
    var idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id';
    idInput.value = id;
    form.appendChild(idInput);
    
    var siInput = document.createElement('input');
    siInput.type = 'hidden';
    siInput.name = 'si';
    siInput.value = si;
    form.appendChild(siInput);
    
    var examInput = document.createElement('input');
    examInput.type = 'hidden';
    examInput.name = 'exam';
    examInput.value = exam;
    form.appendChild(examInput);
    
    // Append the form to the body and submit it
    document.body.appendChild(form);
    form.submit();
  }

</script>

<script>
$(document).ready(function() {
  $('#grades').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();


    var form = this;
    // Send an AJAX request to the server
    $.ajax({
      type: 'POST',
      url: 'save-grades.php',
      data: formData,
      success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Grades added successfully.'
          });
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
});

</script>

<style>
    .no-wrap-textarea {
        overflow-wrap: break-word;
        word-break: break-word;
    }
</style>




