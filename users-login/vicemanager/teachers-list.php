<?php include('../../config.php');

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
$sql = "SELECT * FROM class";
$result = mysqli_query($conn, $sql);
$classes = array();
if (mysqli_num_rows($result) > 0) {
    while ($class = mysqli_fetch_assoc($result)) {
        $classes[] = $class;
    }
}
$sql = "SELECT * FROM teacher_subject_class where deleted=0 ORDER BY teacher_id";
$result = mysqli_query($conn, $sql);
$records = array();
if (mysqli_num_rows($result) > 0) {
    while ($record = mysqli_fetch_assoc($result)) {
        $records[] = $record;
    }
}
$sql = "SELECT * FROM teacher where deleted=0";
$result = mysqli_query($conn, $sql);
$teachers = array();
if (mysqli_num_rows($result) > 0) {
    while ($teacher = mysqli_fetch_assoc($result)) {
        $teachers[] = $teacher;
    }
}

$query="SELECT *FROM subjects;";
$result = mysqli_query($conn, $query);
$subjects = array();
if (mysqli_num_rows($result) > 0) {
    while ($subject = mysqli_fetch_assoc($result)) {
        $subjects[] = $subject;
    }
}
?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../app/app.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manager Home</title>
    <link rel="stylesheet" href="../manager/manager.css/manager-home.css" />
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
  <div ng-include="'../../views/headers/vice-manager-header.php'"></div>
    <section class="section teachers" id="teachers">
      <h1 class="welcome">Welcome Vice Manager!</h1>
      <h2 class="title">Teachers List</h2>
      <div class="table-scroll">
        <table>
        
          <thead>
            <tr>
              <th style="min-width:200px"><input type="text" id="search-name" placeholder="Name" class="form-control"></th>
              <th style="min-width:200px"><input type="text" id="search-email" placeholder="Email" class="form-control"></th>
              <th style="min-width:200px"><input type="tel" id="search-phone" placeholder="Phone" class="form-control"></th>
              <th>Profile</th>
            </tr>
          </thead>
          <tbody id="table-body">
          <?php 
          for ($j = 0; $j < count($teachers); $j++) {
          ?>
            <tr>
              <td><?php echo $teachers[$j]['first_name']; echo ' '; echo $teachers[$j]['last_name']; ?></td>
              <td><a href="mailto:<?php echo $teachers[$j]['email'];?>"><?php echo $teachers[$j]['email'];?></a></td>
              <td><a href="tel:<?php echo $teachers[$j]['phone'];?>"><?php echo $teachers[$j]['phone'];?></a></td>
              <td>
              <form id="teacher-profile" action="teacher-profile.php? id=<?php echo $teachers[$j]['id'];?>" method="POST">
                <input type="submit" id="profile-btn" value="Profile">
              </form> 
              </td>
            </tr>
        <?php } ?>


            
          </tbody>
        </table>
      </div>