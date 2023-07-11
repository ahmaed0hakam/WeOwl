<?php include('../../config.php');

session_start();
if (!isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
    header('Location: teacher-login.php');
    exit;
}
$idcheck=$_SESSION['id'];

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  if ($id != $idcheck) {
      // User is trying to access another user's account, redirect to same page
      $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
      echo "<script>alert('{$_SESSION['error']}');</script>";
      echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
      exit;
  }
}

$sql = "SELECT id FROM teacher WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Session id not found in the database, redirect to login page
    session_unset();
    session_destroy();
    header('Location: teacher-login.php');
    exit;
}


 $ID=$_GET['id'];

 //$query= "SELECT * FROM parent  WHERE id= $ID ";
// $query="SELECT parent.id, parent.first_name, parent.last_name, parent.email, 
// student.class_name, student.section, student.first_name as student_first_name, 
// student.last_name as student_last_name
// FROM parent
// JOIN student ON parent.id = student.parent_id
// WHERE parent.id = $ID;
// ";


//  $result = mysqli_query($conn , $query);
//  $row = mysqli_fetch_array($result);


$query = "SELECT teacher_subject_class.class_id,teacher_subject_class.subject_id,teacher_subject_class.subject_name
FROM teacher_subject_class
JOIN class ON teacher_subject_class.class_id=class.id
WHERE teacher_subject_class.teacher_id = $ID ORDER BY class.id";
$result = mysqli_query($conn , $query);

$stmt = $conn->prepare("SELECT * FROM teacher WHERE id = ? ");
$stmt->bind_param("i", $ID);
$stmt->execute();
$r = $stmt->get_result();
$teacher = mysqli_fetch_assoc($r);
$teacher = $teacher['first_name'];

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
    <title>Teacher Home</title>
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
    <section class="section classes">
      <h1 class="welcome">Welcome Teacher <?php echo $teacher;?> !</h1>
      <h2 class="title">Classes List</h2>
      <div class="buttons-scroll">

        <?php
          // Loop through the rows of the query result and display class buttons
          while($row = mysqli_fetch_assoc($result)) {
            $classId = $row['class_id'];
            $subject = $row['subject_name'];
            $subject_id = $row['subject_id'];
            ?>
            <form action="students-list.php" method="post">
              <input type="hidden" name="class_id" id="class_id" value="<?php echo $classId ;?>" >
              <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $ID ;?>" >
              <input type="hidden" name="subject_id" id="subject_id" value="<?php echo $subject_id ;?>" >
              <button type="submit" id="submit" name="submit" value="class" ><?php echo 'Class '.$classId.' '.$subject;?></button>
            </form>
                                             
         <?php }
        ?>

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
