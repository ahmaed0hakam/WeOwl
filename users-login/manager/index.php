<?php include('../../config.php');

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: manager-login.php');
    session_unset();
    session_destroy();
    exit;
}

$idcheck=$_SESSION['id'];

$sql = "SELECT id FROM manager WHERE id = $idcheck";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    // Session id not found in the database, redirect to login page
    session_unset();
    session_destroy();
    header('Location: manager-login.php');
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../app/app.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manager Home</title>
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
  <div class="sub-topoics-nav">
      <a href="index.php#teachers" class="sub-topoics">Teachers</a>
      <a href="index.php#classes" class="sub-topoics">Classes</a>
  </div>
    <div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3 id="modal-title"></h3>
    <div id="modal-content"></div>
  </div>
  </div>
    <section class="section teachers" id="teachers">
      <h1 class="welcome">Welcome Manager!</h1>
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
      <a href="#add-teacher"><button class="add-user">Add Teacher</button></a>
    </section>
    <section class="section classes" id="classes">
      <h2 class="title">Classes List</h2>
      <div class="buttons-scroll">
      <?php 
        for ($i = 0; $i < count($classes); $i++) {
          ?>
          <div class="row">
            <a href="students-list.php? id=<?php echo $classes[$i]['id'];?>"><button> Class  <?php  echo $classes[$i]['name'];?></button></a>
          </div>
        <?php } ?>
      </div>
      <a href="#add-student"><button class="add-user">Add Student</button></a>
    </section>
    <div class="section add-teacher" id="add-teacher">
      <h2 class="title">Add Teacher</h2>
      <article>
        <form id="add-new-teacher">
          <label for="first-name">
            <span>First Name</span>
            <input type="text" name="first-name" id="first-name" required/>
          </label>
          <label for="last-name">
            <span>Last Name</span>
            <input type="text" name="last-name" id="last-name" required/>
          </label>
          <label for="email">
            <span>Email</span>
            <input type="email" name="email" id="email" required/>
          </label>
          <label for="phone">
            <span>Phone</span>
            <input type="tel" name="phone" id="phone" required/>
          </label>
          <label for="subject">
            <span>Subject</span>
            <select id="subject" name="subject" class="form-select">
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
            <select id="class" name="class" class="form-select">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </label>
          <label for="password">
            <span>Initial Password for Teacher</span>
            <input type="password" name="password" minlength="8" id="password"  required/>
          </label>
          <input type="submit" id="send" value="Add" />
        </form>
      </article>
    </div>
    <div class="section add-student" id="add-student">
      <h2 class="title">Add Student</h2>
      <article>
        <form id="add-new-student">
        <label for="first_name">
            <span>First Name</span>
            <input type="text" name="first_name" id="first_name" required/>
          </label>
          <label for="last_name">
            <span>Last Name</span>
            <input type="text" name="last_name" id="last_name" required/>
          </label>
          <label for="parentname">
            <span>Parent Name</span>
            <input type="text" name="parentname" id="parentname" required/>
          </label>
          <label for="email">
            <span>Parent Email</span>
            <input type="email" name="email" id="email" required/>
          </label>
          <label for="phone">
            <span>Parent Phone</span>
            <input type="tel" name="phone" id="phone" required/>
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
          <label for="password">
            <span>Initial Password for Parent</span>
            <input type="password" name="password" minlength="8" id="password" required/>
          </label>
          <input type="submit" id="send" value="Add" />
        </form>
      </article>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"
    ></script>
  </body>
  <div ng-include="'../../views/footer.html'"></div>
</html>

<script>


function deleteTeacher() {
  var form = document.getElementById("add-another-sc");
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

// function addStudent() {
//   var form = document.getElementById("add-new-student");
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

// function addTeacher() {
//   var form = document.getElementById("add-new-teacher");
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
  const searchNameInput = document.getElementById('search-name');
  const searchEmailInput = document.getElementById('search-email');
  const searchPhoneInput = document.getElementById('search-phone');
  const tableBody = document.getElementById('table-body');

  function filterTable() {
    const searchNameValue = searchNameInput.value.toLowerCase();
    const searchEmailValue = searchEmailInput.value.toLowerCase();
    const searchPhoneValue = searchPhoneInput.value.toLowerCase();
    const rows = tableBody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
      const nameColumn = rows[i].getElementsByTagName('td')[0];
      const emailColumn = rows[i].getElementsByTagName('td')[1];
      const phoneColumn = rows[i].getElementsByTagName('td')[2];
      const name = nameColumn.textContent.toLowerCase();
      const email = emailColumn.textContent.toLowerCase();
      const phone = phoneColumn.textContent.toLowerCase();

      if (
        name.includes(searchNameValue) &&
        email.includes(searchEmailValue) &&
        phone.includes(searchPhoneValue)
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
</script>


<script>
$(document).ready(function() {
  $('#add-new-student').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();

    var form = this;
    // Send an AJAX request to the server
    $.ajax({
      type: 'POST',
      url: 'add-new-student.php',
      data: formData,
      dataType: 'json',
      success: function(response) {
        console.log(response);
        if (response.response == 1) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This Student already exists in the system.'
          });
        }
        else{
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Student added successfully.'
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
<script>
$(document).ready(function() {
  $('#add-new-teacher').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();


    var form = this;
    // Send an AJAX request to the server
    $.ajax({
      type: 'POST',
      url: 'add-new-teacher.php',
      data: formData,
      dataType: 'json',
      success: function(response) {
        console.log(response);
        if (response.response == 1) {
          // Teacher exists, show alert
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This Teacher already exists in the system.'
          });
        }
        else if(response.response==2){
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
            text: 'Teacher added successfully.'
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

var bellIcon = document.querySelector('.fa-bell');

// Get the element with class 'badge'
var badgeElement = document.querySelector('.badge');

// Add a click event listener to the bell icon
bellIcon.addEventListener('click', function() {
  // Hide the badge element
  badgeElement.style.display = 'none';
});

</script>

<style>
  

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


  </style>