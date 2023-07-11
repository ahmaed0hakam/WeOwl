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


$CLASS_ID=$_GET['id'];

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
    <title>Students list</title>
    <link rel="stylesheet" href="vicemanager.css/student-list-all.css" />
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
    <section class="section students" id="students">
      <h1 class="welcome">Welcome Vice Manager !</h1>
      <h2 class="title">Students List</h2>
      
      
      
      <div class="table-scroll">
        <table >
          <thead>
            <tr>
              <th colspan="7">
              <div class="actions">
              
              <form id="take-arrival" action="students-list-arrival.php? id=<?php echo $CLASS_ID;?>" method="post">
                  <input id="go-btn" type="submit" value="Arrival">
                </form>
              <form id="take-leaving" action="students-list-leaving.php? id=<?php echo $CLASS_ID;?>" method="post">
                  <input id="go-btn" type="submit" value="Leaving">
                </form>
              <form id="check-attendance" action="attendance-reports.php? id=<?php echo $CLASS_ID;?>" method="post">
                  <input id="go-btn" type="submit" value="Attendance Reports">
                </form>
              
            </div>
              </th>
            </tr>
            <tr>
              <th><input type="text" id="search-name" placeholder="Name" class="form-control" style="min-width:200px"></th>
              <th><input type="text" id="search-parent" placeholder="Parent" class="form-control" style="min-width:200px"></th>
              <th><input type="text" id="search-email" placeholder="Email" class="form-control" style="min-width:200px"></th>
              <th><input type="tel" id="search-phone" placeholder="Phone" class="form-control" style="min-width:200px"></th>
              <th><input type="text" id="search-class" placeholder="Class" class="form-control" style="min-width:200px"></th>
              <th>Edit</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody id="table-body">
            <?php for($i=0;$i<count($students);$i++){ 
              
              $stmt = $conn->prepare("SELECT * FROM parent WHERE student_id = ?");
              $stmt->bind_param("i", $students[$i]['id']);
              $stmt->execute();
              $result = $stmt->get_result();
              $parent = mysqli_fetch_assoc($result);
                  
              
              ?>
            <tr>
              <td><?php echo $students[$i]['first_name']; echo ' '; echo $students[$i]['last_name']; ?></td>
              <td><?php echo $parent['first_name']; echo ' '; echo $students[$i]['last_name']; ?></td>
              <td><a href="mailto:<?php echo $parent['email']; ?>"><?php echo $parent['email']; ?></a></td>
              <td><a href="tel:<?php echo $parent['phone']; ?>"><?php echo $parent['phone']; ?></a></td>
              <td><?php echo $students[$i]['class_name']; echo $students[$i]['section']; ?></td>
              <td>
                <a href="edit-student.php? id=<?php echo $students[$i]['id'];?>"><button>Edit</button></a>
              </td>
              <td>
                <form id="delete-student" action="delete-student.php? id=<?php echo $students[$i]['id'];?>" method="post">
                  <input id="delete-btn" type="submit" value="Delete">
                </form>
              </td>
            </tr>
           <?php }?>
          </tbody>
        </table>
      </div>
    </section>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"
    ></script>
    <script>
  const searchNameInput = document.getElementById('search-name');
  const searchParentInput = document.getElementById('search-parent');
  const searchEmailInput = document.getElementById('search-email');
  const searchPhoneInput = document.getElementById('search-phone');
  const searchClassInput = document.getElementById('search-class');
  const tableBody = document.getElementById('table-body');

  function filterTable() {
    const searchNameValue = searchNameInput.value.toLowerCase();
    const searchParentValue = searchParentInput.value.toLowerCase();
    const searchEmailValue = searchEmailInput.value.toLowerCase();
    const searchClassValue = searchClassInput.value.toLowerCase();
    const searchPhoneValue = searchPhoneInput.value;
    const rows = tableBody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
      const nameColumn = rows[i].getElementsByTagName('td')[0];
      const parentColumn = rows[i].getElementsByTagName('td')[1];
      const emailColumn = rows[i].getElementsByTagName('td')[2];
      const phoneColumn = rows[i].getElementsByTagName('td')[3];
      const classColumn = rows[i].getElementsByTagName('td')[4];
      const name = nameColumn.textContent.toLowerCase();
      const parent = parentColumn.textContent.toLowerCase();
      const email = emailColumn.textContent.toLowerCase();
      const phone = phoneColumn.textContent;
      const classValue = classColumn.textContent.toLowerCase();

      if (
        name.includes(searchNameValue) &&
        email.includes(searchEmailValue) &&
        phone.includes(searchPhoneValue) &&
        parent.includes(searchParentValue) &&
        classValue.includes(searchClassValue)
      ) {
        rows[i].style.display = '';
      } else {
        rows[i].style.display = 'none';
      }
    }
  }

  searchNameInput.addEventListener('input', filterTable);
  searchEmailInput.addEventListener('input', filterTable);
  searchPhoneInput.addEventListener('input', filterTable);
  searchParentInput.addEventListener('input', filterTable);
  searchClassInput.addEventListener('input', filterTable);
</script>
<div ng-include="'../../views/footer.html'"></div>
  </body>
</html>
