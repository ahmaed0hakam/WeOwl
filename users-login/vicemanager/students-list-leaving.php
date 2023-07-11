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
 $CLASS_ID=$_GET['id'];

 $stmt = $conn->prepare("SELECT * FROM student WHERE class_id = ? AND deleted = 0 ORDER BY section");
 $stmt->bind_param("i", $CLASS_ID);
 $stmt->execute();
 $result = $stmt->get_result();
 
 $students = array();
 if (mysqli_num_rows($result) > 0) {
     while ($student = mysqli_fetch_assoc($result)) {
         $students[] = $student;
     }
 }

 $stmt1 = $conn->prepare("SELECT * FROM attendance WHERE class_id = $CLASS_ID AND dates = DATE(NOW())");
 $stmt1->execute();
 $result1 = $stmt1->get_result();
 
 $attendances = array();
 if (mysqli_num_rows($result1) > 0) {
     while ($attendance = mysqli_fetch_assoc($result1)) {
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
    <title>Leaving List</title>
    <link rel="stylesheet" href="vicemanager.css/students-list.css" />
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
    <section class="section classes">
      <h1 class="welcome">Class <?php echo $CLASS_ID  ;?> Students List</h1>
      <h2 class="title">Leaving - Date :<?php echo date('Y-m-d') ;?></h2>
      <div class="table-scroll">
      <form id="attendanceForm" action="save-attendance-leaving.php?id=<?php echo $CLASS_ID; ?>" method="post">
      <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Left</th>
              <th>Section</th>
            </tr>
          </thead>
          <tbody>
          <?php 
        for ($i = 0; $i < count($students); $i++) {
          if( count($attendances)>0){
            for($j = 0; $j < count($attendances);$j++){
              ?>
              
             <?php if($students[$i]['id']==$attendances[$j]['student_id']){
                      if($attendances[$j]['leaving_status']=='Left'){ ?>
                        <tr>
                        <td><?php echo $students[$i]['first_name'];?> <?php echo $students[$i]['last_name']; ?></td>
                        <td>
                        <input type="hidden" name="<?php echo $i; ?>[] " value="<?php echo $students[$i]['id']; ?>" />     
                        Yes <input checked class="form-check-input" type="radio" name="<?php echo $i; ?>[] " value="yes" id="flexCheckDefault "  />
                          No <input class="form-check-input" type="radio" name="<?php echo $i; ?>[] " value="no" id="flexCheckDefault" />
              <?php }elseif($attendances[$j]['leaving_status']=='Still'){
                ?>
                          <tr>
                          <td><?php echo $students[$i]['first_name'];?> <?php echo $students[$i]['last_name']; ?></td>
                          <td>
                          <input type="hidden" name="<?php echo $i; ?>[] " value="<?php echo $students[$i]['id']; ?>" />               
                          Yes <input  class="form-check-input" type="radio" name="<?php echo $i; ?>[] " value="yes" id="flexCheckDefault "  />
                            No <input checked class="form-check-input" type="radio" name="<?php echo $i; ?>[] " value="no" id="flexCheckDefault" />
             <?php }else{?> 
                          <tr>
                          <td><?php echo $students[$i]['first_name'];?> <?php echo $students[$i]['last_name']; ?></td>
                          <td>
                          <input type="hidden" name="<?php echo $i; ?>[] " value="<?php echo $students[$i]['id']; ?>" />               
                          Yes <input  class="form-check-input" type="radio" name="<?php echo $i; ?>[] " value="yes" id="flexCheckDefault "  />
                            No <input  class="form-check-input" type="radio" name="<?php echo $i; ?>[] " value="no" id="flexCheckDefault" />
                            <?php }?>
              </td>
              <td><?php echo $students[$i]['section'];?></td>
            </tr>
            <?php 
            } }
          }else{
          ?>
            <tr>
              <td><?php echo $students[$i]['first_name'];?> <?php echo $students[$i]['last_name']; ?></td>
              <td>
                  <input type="hidden" name="<?php echo $i; ?>[] " value="<?php echo $students[$i]['id']; ?>" />
                  Yes <input class="form-check-input" type="radio" name="<?php echo $i; ?>[] " value="yes" id="flexCheckDefault"  />
                    No <input class="form-check-input" type="radio" name="<?php echo $i; ?>[] " value="no" id="flexCheckDefault" />

              </td>
              <td><?php echo $students[$i]['section'];?></td>
            </tr>
     <?php }} ?>
          </tbody>
        </table>
        <button type="submit" id="submitAttendanceBtn">Submit</button>
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
  function submitAttendance() {
  var form = document.getElementById("attendanceForm");
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