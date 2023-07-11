<?php include('../../config.php');
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
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
$TEACHER_ID=$_GET['id'];
$SUBJECT_ID=$_GET['sub'];
$CLASS_ID=$_GET['cls'];

$stmt = $conn->prepare("SELECT * FROM teacher_subject_class WHERE teacher_id = ? AND subject_id = ? AND class_id = ?");
$stmt->bind_param("iii", $TEACHER_ID,$SUBJECT_ID,$CLASS_ID);
$stmt->execute();
$result = $stmt->get_result();
$record = mysqli_fetch_assoc($result);

$stmt = $conn->prepare("SELECT * FROM teacher WHERE id = ?");
$stmt->bind_param("i", $record['teacher_id']);
$stmt->execute();
$result = $stmt->get_result();
$teacher = mysqli_fetch_assoc($result);

$stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
$stmt->bind_param("i", $record['subject_id']);
$stmt->execute();
$result = $stmt->get_result();
$subject = mysqli_fetch_assoc($result);

$stmt = $conn->prepare("SELECT * FROM class WHERE id = ?");
$stmt->bind_param("i", $record['class_id']);
$stmt->execute();
$result = $stmt->get_result();
$class = mysqli_fetch_assoc($result);

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
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="../manager/manager.css/manager-home.css" />
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
  <div ng-include="'../../views/headers/vice-manager-header.php'"></div>

    <section class="section edit-teacher">
      <h2 class="title">Edit Teacher</h2>
      <article>
        <form id="edit-teacher-form">
          <input type="hidden" name="id" id="id" value="<?php echo $TEACHER_ID ;?>" >
          <input type="hidden" name="sub" id="sub" value="<?php echo $SUBJECT_ID ;?>" >
          <input type="hidden" name="cls" id="cls" value="<?php echo $CLASS_ID ;?>" >
          <label for="first-name">
            <span>First Name</span>
            <input type="text" name="first-name" id="first-name" value="<?php echo $teacher['first_name']; ?>" required/>
          </label>
          <label for="last-name">
            <span>Last Name</span>
            <input type="text" name="last-name" id="last-name" value="<?php echo $teacher['last_name']; ?>" required/>
          </label>
          <label for="email">
            <span>Email</span>
            <input type="email" name="email" id="email" value="<?php echo $teacher['email']; ?>" required/>
          </label>
          <label for="phone">
            <span>Phone</span>
            <input type="tel" name="phone" id="phone" value="<?php echo $teacher['phone']; ?>" required/>
          </label>
          <label for="subject">
            <span>Subject</span>
            <select id="subject" name="subject" class="form-select">
              <option value="Arabic">Arabic</option>
              <option value="English">English</option>
              <option value="Islamic">Islamic</option>
              <option value="Math">Math</option>
              <option value="Science">Science</option>
              <option value="Social Studies">Social Studies</option>
            </select>
          </label>
          <label for="class">
            <span>Class</span>
            <select id="class" name="class" class="form-select">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </label>

          <input type="submit" id="send" value="Save" />
        </form>
      </article>
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

window.addEventListener("load", function() {
    document.getElementById("class").value = "<?php echo $class['name']; ?>";
    document.getElementById("subject").value = "<?php echo $subject['name']; ?>";
  });

//   function editTeacher() {
//   var form = document.getElementById("edit-teacher-form");
//   var xhr = new XMLHttpRequest();
//   xhr.open("POST", form.action);
//   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       alert("Attendance submitted successfully");
//       form.reset();
//     }
//   };
//   xhr.send(new FormData(form));
// }
</script>

<script>
$(document).ready(function() {
  $('#edit-teacher-form').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();


    var form = this;
    // Send an AJAX request to the server
    $.ajax({
      type: 'POST',
      url: 'save-teacher-edit.php',
      data: formData,
      dataType: 'json',
      success: function(response) {
        console.log(response);
        if(response.response==2){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'There is a teacher who teach this subject to this class. '
          });
        }
        else{
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Subject and Class added successfully.'
          });
        }
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });
});

</script>

<style>
  select{
  width: 150%;
  border-color: #ab2a19;
  background-color: #eed86e;
  color: #ab2a19;
  border-radius: 3px;
}
</style>
