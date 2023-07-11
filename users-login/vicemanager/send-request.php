<?php  include('../../config.php');


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
?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../app/app.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ViceManager Add/T-S</title>
    <link rel="stylesheet" href="vicemanager.css/vice-manager-home.css" />
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
  <div ng-include="'../../views/headers/vice-manager-header.php'"></div>
  <div class="sub-topoics-nav">
      <a href="#add-teacher" class="sub-topoics">Add Teacher</a>
      <a href="#add-student" class="sub-topoics">Add Student</a>
  </div>
    <section class="section add-teacher" id="add-teacher">
      <h2 class="title">Add Teacher</h2>
      <article>
        <form id="teacher-form">
          <label for="first-name">
            <span>First Name</span>
            <input type="text" name="first-name" id="first-name" required/>
          </label>
          <label for="last-name">
            <span>Last Name</span>
            <input type="text" name="last-name" id="last-name" required/>
          </label>
          <label for="email">
            <span>Email</span>
            <input type="email" name="email" id="email" required/>
          </label>
          <label for="phone">
            <span>Phone</span>
            <input type="tel" name="phone" id="phone" required/>
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
          <label for="password">
            <span>password</span>
            <input type="password" name="password" minlength="8" id="password" required/>
          </label>
          <input type="submit" id="send" value="Add" />
        </form>
      </article>
    </section>
    <section class="section add-student" id="add-student">
      <h2 class="title">Add Student</h2>
      <article>
        <form id="student-form">
          <label for="first_name">
            <span>First Name</span>
            <input type="text" name="first_name" id="first_name" required/>
          </label>
          <label for="last_name">
            <span>Last Name</span>
            <input type="text" name="last_name" id="last_name" required/>
          </label>
          <label for="parentname">
            <span>Parent Name</span>
            <input type="text" name="parentname" id="parentname" required/>
          </label>
          <label for="email">
            <span>Parent Email</span>
            <input type="email" name="email" id="email" required/>
          </label>
          <label for="phone">
            <span>Parent Phone</span>
            <input type="tel" name="phone" id="phone" required/>
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
          <label for="section">
            <span>Section</span>
            <select id="section" name="section" class="form-select">
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
          </label>
          <label for="password">
            <span>Initial Password for Parent</span>
            <input type="password" name="password" minlength="8" id="password" required/>
          </label>
          <input type="submit" id="send" value="Add" />
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
//   function submitForm() {
//   var form = document.getElementById("student-form");
//   var xhr = new XMLHttpRequest();
//   xhr.open("POST", form.action);
//   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       alert("Student Added successfully");
//       form.reset();
//     }
//   };
//   xhr.send(new FormData(form));
// }

// function submitForm() {
//   var form = document.getElementById("teacher-form");
//   var xhr = new XMLHttpRequest();
//   xhr.open("POST", form.action);
//   xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//   xhr.onreadystatechange = function() {
//     if (xhr.readyState === 4 && xhr.status === 200) {
//       alert("Teacher Added successfully");
//       form.reset();
//     }
//   };
//   xhr.send(new FormData(form));
// }
</script>


<script>
$(document).ready(function() {
  $('#student-form').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();

    var form = this;
    // Send an AJAX request to the server
    $.ajax({
      type: 'POST',
      url: 'save-student-request.php',
      data: formData,
      dataType: 'json',
      success: function(response) {
        console.log(response);
        if (response.response == 1) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This Student already exists in the system.'
          });
        }
        else{
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Student added successfully.'
          }).then(function() {
            // Clear the form fields manually
            $(form)[0].reset();
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
<script>
$(document).ready(function() {
  $('#teacher-form').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();


    var form = this;
    // Send an AJAX request to the server
    $.ajax({
      type: 'POST',
      url: 'save-teacher-request.php',
      data: formData,
      dataType: 'json',
      success: function(response) {
        console.log(response);
        if (response.response == 1) {
          // Teacher exists, show alert
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This Teacher already exists in the system.'
          });
        }
        else if(response.response==2){
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
            text: 'Teacher added successfully.'
          }).then(function() {
            // Clear the form fields manually
            $(form)[0].reset();
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


