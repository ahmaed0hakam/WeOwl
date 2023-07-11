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

$TEACHER_ID= $_GET['id'];

$sql1 = "SELECT * FROM notifications WHERE user_type ='manager' AND user_id = $idcheck ORDER BY id DESC";
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
    <title>Add Subject/Class</title>
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
    <section class="section add-sc" id="add-sc">
      <h2 class="title">New Class & Subject</h2>
      <article>
        <form id="add-new-sc">
          <label for="subject">
            <span>Subject</span>
            <select id="subject" name="subject">
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
            <select id="class" name="class">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </label>
          <input type="hidden" name="id" id="id" value="<?php echo $TEACHER_ID ;?>">
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
//     function addSc() {
//   var form = document.getElementById("add-new-sc");
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
  $('#add-new-sc').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();


    var form = this;
    // Send an AJAX request to the server
    $.ajax({
      type: 'POST',
      url: 'save-new-sc.php',
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

