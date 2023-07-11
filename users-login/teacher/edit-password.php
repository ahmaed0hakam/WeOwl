<?php include('../../config.php');

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: teacher-login.php');
    session_unset();
    session_destroy();
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
$ID = $_GET['id'];

if (isset($ID)) {
  if ($ID != $idcheck) {
      // User is trying to access another user's account, redirect to login page
      $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
      echo "<script>alert('{$_SESSION['error']}');</script>";
      echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
      exit;
  }
}


$query="SELECT * FROM teacher
WHERE teacher.id = $idcheck;
";

$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);

$name=$row['first_name'].' '.$row['last_name'];
$email=$row['email'];
$phone=$row['phone'];

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
    <title>Edit Password</title>
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

    <section class="section add-sc" id="editpass">
      <article class="pass-article">
      <h2 class="form-title" style="color: white;">Profile</h2>
        <form action="save-password.php?id=<?php echo $idcheck?>" method="POST" id="edit-password">
        <label for="name">
            <span>Name</span>
            <input type="text" name="name"  id="name" value="<?php echo $name ;?>" readonly>
          </label>
          <label for="email">
            <span>Email</span>
            <input type="email" name="email"  id="email" value="<?php echo $email ;?>" readonly >
          </label>
          <label for="phone">
            <span>Phone</span>
            <input type="tel" name="phone"  id="phone" value="<?php echo $phone ;?>" readonly >
          </label>
        <label for="password">
            <span>New Password</span>
            <input type="password" name="password" id="password" minlength="8" required>
          </label>
          <input type="submit" id="save" value="Save" />
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
    function editPass() {
  var form = document.getElementById("edit-password");
  var xhr = new XMLHttpRequest();
  xhr.open("POST", form.action);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      alert("Attendance submitted successfully");
      form.reset();
    }
  };
  xhr.send(new FormData(form));
}
</script>

