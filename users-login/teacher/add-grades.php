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
$ID=$_POST['id'];
$subject_id=$_POST['si'];
$exam=$_POST['exam'];

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
$stmt->bind_param("iii", $subject_id,$idcheck,$ID);
$stmt->execute();
$r = $stmt->get_result();
$subject = mysqli_fetch_assoc($r);
$subject_name = $subject['subject_name'];

$sql = "SELECT first_name FROM teacher WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);
$teacher = mysqli_fetch_assoc($result);
$teacher = $teacher['first_name'];

$stmt = $conn->prepare("SELECT * FROM student WHERE class_id = ? AND deleted = 0 ORDER BY section_id");
$stmt->bind_param("i", $ID);
$stmt->execute();
$result = $stmt->get_result();

$students = array();
if (mysqli_num_rows($result) > 0) {
    while ($student = mysqli_fetch_assoc($result)) {
        $students[] = $student;
    }
}

$stmt = $conn->prepare("SELECT * FROM grades WHERE class_id = ? AND teacher_id = ? AND subject_id = ? AND exam = ?");
$stmt->bind_param("iiis", $ID,$idcheck,$subject_id,$exam);
$stmt->execute();
$result = $stmt->get_result();

$grades = array();
if (mysqli_num_rows($result) > 0) {
    while ($grade = mysqli_fetch_assoc($result)) {
        $grades[] = $grade;
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
    <section class="section students" id="students-list">
      <h5 class="welcome">
        <form id="infoform" action="students-list.php" method="post">
          <input type="text" name="class_id" id="class_id" value="<?php echo $ID ;?>" hidden>
          <input type="text" name="teacher_id" id="teacher_id" value="<?php echo $idcheck ;?>" hidden>
          <input type="text" name="subject_id" id="subject_id" value="<?php echo $subject_id ;?>" hidden>
          <input type="submit" id="submitinfo" value="< back to <?php echo $subject_name .' - '.$ID;?>">
        </form> 
      </h5>
      <h2 class="title"><?php echo $subject_name .' - '.$ID.' - ';?>Students List</h2>
      <div class="menu">
      </div>
      <div class="table-scroll">
      <form id="grades">
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th><?php echo $exam.' exam ' ;?>grade</th>
      </tr>
    </thead>
    <tbody>
      <?php for ($i = 0; $i < count($students); $i++) { ?>
        <tr>
          <input type="text" name="class-id" id="class-id" value="<?php echo $ID ;?>" hidden>
          <input type="text" name="subject-id" id="subject-id" value="<?php echo $subject_id ;?>" hidden>
          <input type="text" name="exam" id="exam" value="<?php echo $exam ;?>" hidden>
          <td><?php echo $students[$i]['first_name'];?> <?php echo $students[$i]['last_name']; ?></td>
          <td>
            <input type="hidden" name="<?php echo $i; ?>[]" value="<?php echo $students[$i]['id']; ?>" />
            <input type="number" required min="0" max="100" name="<?php echo $i; ?>[]" value="<?php echo $grades[$i]['grade'] ;?>" id="<?php echo $i; ?>[]" />
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <button type="submit" id="submitGradeBtn">Submit</button>
</form>


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

<script>

document.getElementById('grades').addEventListener('submit', function(event) {
    var inputs = document.querySelectorAll('#grades input[type="number"]');
    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].value === '') {
        event.preventDefault(); // Prevent form submission
        alert('Please fill in all grade fields.');
        return;
      }
    }
    // All grade fields are filled, allow form submission
  });
</script>


<script>
 // Click event handler for the link
document.getElementById("aid").addEventListener("click", function(event) {
  event.preventDefault(); // Prevent default link behavior
  
  // Trigger the click event of the button
  document.getElementById("submitinfo").click();
});
</script>

<script>
    function submitform() {
  var form = document.getElementById("infoform");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {

    }
  };
  xhr.send(new FormData(form));
}
</script>

<style>
  #submitinfo {
  background: none;
  border: none;
  padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
  font-size: var(--bs-nav-link-font-size);
    font-weight: var(--bs-nav-link-font-weight);
    color: var(--bs-nav-link-color);
  cursor: pointer;
  text-decoration: underline;

}
</style>

