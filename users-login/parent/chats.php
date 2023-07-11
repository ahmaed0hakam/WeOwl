<?php include('../../config.php');

session_start();
if (!isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
    header('Location: parent-login.php');
    exit;
}
$idcheck=$_SESSION['id'];


$sql = "SELECT id FROM parent WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Session id not found in the database, redirect to login page
    session_unset();
    session_destroy();
    header('Location: parent-login.php');
    exit;
}


 $ID=$idcheck;

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

$query = "SELECT *
FROM messages WHERE
sender_id = $ID or receiver_id = $ID GROUP BY sender_id , receiver_id";
$result = mysqli_query($conn , $query);

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
    <link rel="stylesheet" href="parent-home.css/parent-home.css" />

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
  <div ng-include="'../../views/headers/parent-header.php'"></div>
    <section class="section classes">
      <h1 class="welcome">Chats List</h1>
      <div class="buttons-scroll">
        <?php
$teacherIDs = array(); 
while ($row = mysqli_fetch_assoc($result)) {
    $sender_id = $row['sender_id'];
    $receiver_id = $row['receiver_id'];

if($sender_id!=$idcheck){
    if (!in_array($sender_id, $teacherIDs)) {
        $teacherIDs[] = $sender_id;
    }
}
if($receiver_id!=$idcheck){
    if (!in_array($receiver_id, $teacherIDs)) {
        $teacherIDs[] = $receiver_id;
    }
}
}

foreach ($teacherIDs as $teacher_id) {
    
    $stmt = $conn->prepare("SELECT * FROM teacher WHERE id = ? ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $r = $stmt->get_result();
    $teacher = mysqli_fetch_assoc($r);
    $teacher_name = $teacher['first_name'].' '.$teacher['last_name'];
    ?>
    <form action="parent_chat.php" method="post">
        <input type="hidden" name="parent_id" id="parent_id" value="<?php echo $idcheck; ?>" >
        <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $teacher_id; ?>" >
        <button type="submit" id="submit" name="submit" value="<?php echo $teacher_name; ?>" ><?php echo $teacher_name; ?></button>
    </form>
    <?php
}

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
