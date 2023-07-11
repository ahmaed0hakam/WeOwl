<?php include('../../config.php');

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: manager-login.php');
    exit;
}

$idcheck=$_SESSION['id'];

$sql = "SELECT id FROM manager WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Session id not found in the database, redirect to login page
    header('Location: manager-login.php');
    exit;
}

$CLASS_ID=$_GET['id'];

 $stmt = $conn->prepare("SELECT * FROM student WHERE class_id = ? AND deleted = 0 ORDER BY section_id, first_name");
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
    <link rel="stylesheet" href="manager.css/manager-home.css" />
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
  <div ng-include="'../../views/headers/manager-header.php'"></div>
    <div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3 id="modal-title"></h3>
    <div id="modal-content"></div>
  </div>
  </div>

    <section class="section students" id="students">
      <h1 class="welcome">Welcome Manager!</h1>
      <h2 class="title">Students List</h2>
      
      
      
      <div class="table-scroll">
        <table >
          <thead>
            <tr>
              <th colspan="7">
              <div class="actions">
              
              <form id="take-arrival" action="student-list-arrival.php? id=<?php echo $CLASS_ID;?>" method="post">
                  <input id="go-btn" type="submit" value="Arrival">
                </form>
              <form id="take-leaving" action="student-list-leaving.php? id=<?php echo $CLASS_ID;?>" method="post">
                  <input id="go-btn" type="submit" value="Leaving">
                </form>
              <form id="check-attendance" action="attendance-reports.php? id=<?php echo $CLASS_ID;?>" method="post">
                  <input id="go-btn" type="submit" value="Attendance Reports">
                </form>
              
            </div>
              </th>
            </tr>
            <tr>
              <th><input type="text" id="search-name" placeholder="Name" class="form-control"></th>
              <th><input type="text" id="search-parent" placeholder="Parent" class="form-control"></th>
              <th><input type="text" id="search-email" placeholder="Email" class="form-control"></th>
              <th><input type="tel" id="search-phone" placeholder="Phone" class="form-control"></th>
              <th><input type="text" id="search-class" placeholder="Class" class="form-control"></th>
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
<script>

<?php
  $sql1 = "SELECT * FROM notifications WHERE user_type ='manager' AND user_id = $idcheck AND viewed = 0";
  $result10 = mysqli_query($conn, $sql1);
  
  if (mysqli_num_rows($result10) >= 1) {
    $newNotifications = true;} 
  else $newNotifications=false;
?>

// JavaScript code to update the notification bell
document.addEventListener('DOMContentLoaded', function() {
  var notificationBell = document.querySelector('.notification');
  var badge = notificationBell.querySelector('.badge');

  // Update the bell's appearance based on the newNotifications variable
  if (<?php echo $newNotifications ? 'true' : 'false'; ?>) {
    badge.style.display = 'block';
  } else {
    badge.style.display = 'none';
  }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
  var notificationBell = document.querySelector('.notification');
  var badge = notificationBell.querySelector('.badge');
  var notificationPopup = notificationBell.querySelector('.notification-popup');

  // Set initial display state of the notification popup
  notificationPopup.style.display = 'none';

  // Update the badge and show/hide the notification popup when the bell is clicked
  notificationBell.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the link from navigating

    // Toggle the visibility of the notification popup
    if (window.getComputedStyle(notificationPopup).display === 'none') {
      notificationPopup.style.display = 'block';

    } else {
      notificationPopup.style.display = 'none';
      
    }
  });

});
</script>

<script>

function openModal(id, title, content) {
  // Make an AJAX request to the server-side script
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "view_notification.php", true); // Replace "update_database.php" with your server-side script URL
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Send the data to the server-side script
  var data = "id=" + encodeURIComponent(id) + "&title=" + encodeURIComponent(title);
  xhr.send(data);
  // Handle the response from the server-side script if needed
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Handle the response here
      console.log(xhr.responseText);
      var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var closeBtn = document.getElementsByClassName("close")[0];

// Set the title in the modal
var modalTitle = document.getElementById("modal-title");
modalTitle.innerText = title;
var modalContent = document.getElementById("modal-content");
modalContent.innerText = content;
// Display the modal
modal.style.display = "block";

// Close the modal when the user clicks on the close button
closeBtn.onclick = function() {
  modal.style.display = "none";
};

// Close the modal when the user clicks anywhere outside of the modal
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
    } else {
      console.error("Request failed. Status: " + xhr.status);
    }
  };
}

</script>
