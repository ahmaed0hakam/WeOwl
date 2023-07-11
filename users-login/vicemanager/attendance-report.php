<?php include('../../config.php');
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: vicemanager-login.php');
    exit;
}

$idcheck=$_SESSION['id'];

$sql = "SELECT id FROM vice WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Session id not found in the database, redirect to login page
    header('Location: vicemanager-login.php');
    exit;
}

$CLASS_ID=$_GET['id'];
$date = $_GET['date'];
 $stmt = $conn->prepare("SELECT * FROM student WHERE class_id = ? AND deleted = 0 ORDER BY section_id");
 $stmt->bind_param("i", $CLASS_ID);
 $stmt->execute();
 $result = $stmt->get_result();
 
 $students = array();
 if (mysqli_num_rows($result) > 0) {
     while ($student = mysqli_fetch_assoc($result)) {
         $students[] = $student;
     }
 }

 $sql = "SELECT * FROM attendance 
WHERE class_id=$CLASS_ID AND dates = '$date';
";
$r = mysqli_query($conn, $sql); 
 $attendances = array();
 if (mysqli_num_rows($r) > 0) {
     while ($attendance = mysqli_fetch_assoc($r)) {
         $attendances[] = $attendance;
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
    <title>Students list</title>
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
  </head>
  <body ng-controller="myController">
  <div ng-include="'../../views/headers/vice-manager-header.php'"></div>
    <section class="section students" id="students">
      <h1 class="welcome">Welcome Vice Manager!</h1>
      <h2 class="title">Class <?php echo $CLASS_ID ;?> - Date :<?php echo $date ;?></h2>
      <div class="table-scroll">
        <table >
          <thead>
            <tr>
            <th>Student</th>
            <th>Arrival Status</th>
              <th>Arrival time</th>
              <th>Leaving Status</th>
              <th>Leaving time</th>
            </tr>
          </thead>
          <tbody id="table-body">
            <?php for($i=0;$i<count($students);$i++){ 
                        for($j=0;$j<count($attendances);$j++){
                            if($attendances[$j]['student_id']==$students[$i]['id']){
              ?>
            <tr>
              <td><?php echo $students[$i]['first_name']; echo ' '; echo $students[$i]['last_name']; ?></td>
              <td><?php echo $attendances[$j]['arrival_status'];?></td>
              <td><?php if($attendances[$j]['arrival_status']=='Arrived'){echo $attendances[$j]['arrival'];}
              else echo '-' ;?></td>
              <td><?php if($attendances[$j]['arrival_status']=='Arrived'){
                if($attendances[$j]['leaving_status']!=''){echo $attendances[$j]['leaving_status'];}else echo '-';}
              else echo '-';?></td>
              <td><?php if($attendances[$j]['arrival_status']=='Arrived'){
                if($attendances[$j]['leaving_status']!=''){echo $attendances[$j]['leaving'];}else echo '-';}
              else echo '-';?></td>
            </tr>
           <?php }}}?>
          </tbody>
        </table>
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