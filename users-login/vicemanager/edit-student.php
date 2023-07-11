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

$STUDENT_ID=$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM student WHERE id = ?");
$stmt->bind_param("i", $STUDENT_ID);
$stmt->execute();
$result = $stmt->get_result();
$student = mysqli_fetch_assoc($result);


$stmt = $conn->prepare("SELECT * FROM parent WHERE student_id = ?");
$stmt->bind_param("i", $STUDENT_ID);
$stmt->execute();
$result = $stmt->get_result();
$parent = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM manager WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);
$manager = mysqli_fetch_assoc($result);

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
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
  <script src="../../app/app.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Student</title>
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
    <section class="section edit-student">
      <h2 class="title">Edit Student</h2>
      <article>
        <form id="edit-student-form" action="save-student-edit.php? id=<?php echo $STUDENT_ID ?>" method="POST">
          <label for="first-name">
            <span>First Name</span>
            <input type="text" name="first-name" id="first-name" value="<?php echo $student['first_name']; ?>" required/>
          </label>
          <label for="last-name">
            <span>Last Name</span>
            <input type="text" name="last-name" id="last-name" value="<?php echo $student['last_name']; ?>" required/>
          </label>
          <label for="parent-name">
            <span>Parent Name</span>
            <input type="text" name="parent-name" id="parent-name" value="<?php echo $parent['first_name']; ?>" required/>
          </label>
          <label for="email">
            <span>Email</span>
            <input type="email" name="email" id="email" value="<?php echo $parent['email']; ?>" required/>
          </label>
          <label for="phone">
            <span>Phone</span>
            <input type="tel" name="phone" id="phone" value="<?php echo $parent['phone']; ?>" required/>
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

<style>
  .section {
  position: relative;
  width: 100%;
  height: 120vh;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}
  article {
  background-color: #ab2a19;
  width: 50%;
  height: fit-content;
  border-radius: 15px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  position: relative;
  border: #ffffe8 dotted 3px;
}
select{
  width: 150%;
  border-color: #ab2a19;
  background-color: #eed86e;
  color: #ab2a19;
  border-radius: 3px;
}
</style>

<script>
    window.addEventListener("load", function() {
    document.getElementById("class").value = "<?php echo $student['class_name']; ?>";
    document.getElementById("section").value = "<?php echo $student['section']; ?>";
  });

  function editStudent() {
  var form = document.getElementById("edit-student-form");
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