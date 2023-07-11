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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manager Home</title>
    <link rel="stylesheet" href="manager.css/manager-home.css" />
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
  <body>
    <header>
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
          <a href="#" class="navbar-brand"
            ><img src="../../images/WeOwl.png" alt="WeOwl" width="50px" />
            WeOwl</a
          >
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navmenu"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a href="index.php" class="nav-link">Home</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Requests</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <section class="section teachers">
      <h1 class="welcome">Welcome Manager!</h1>
      <h2 class="title">Add & Remove Teachers</h2>
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th>Action</th>
              <th>Name</th>
              <th>Courses</th>
              <th>Accept</th>
              <th>Reject</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Remove</td>
              <td>Ahmad Hakam Mohammad Alhafi</td>
              <td>Arabic, English</td>
              <td>
                <a href="requests.php"><button>Accept</button></a>
              </td>
              <td>
                <a href="requests.php"><button>Reject</button></a>
              </td>
            </tr>
            <tr>
              <td>Remove</td>
              <td>Ahmad Hakam Mohammad Alhafi</td>
              <td>Arabic, English</td>
              <td>
                <a href="requests.php"><button>Accept</button></a>
              </td>
              <td>
                <a href="requests.php"><button>Reject</button></a>
              </td>
            </tr>
            <tr>
              <td>Remove</td>
              <td>Ahmad Hakam Mohammad Alhafi</td>
              <td>Arabic, English</td>
              <td>
                <a href="requests.php"><button>Accept</button></a>
              </td>
              <td>
                <a href="requests.php"><button>Reject</button></a>
              </td>
            </tr>
            <tr>
              <td>Add</td>
              <td>Ahmad Hakam Mohammad Alhafi</td>
              <td>Arabic, English</td>
              <td>
                <a href="requests.php"><button>Accept</button></a>
              </td>
              <td>
                <a href="requests.php"><button>Reject</button></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
    <section class="section students">
      <h2 class="title">Add & Remove Students</h2>
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th>Action</th>
              <th>Name</th>
              <th>Class</th>
              <th>Accept</th>
              <th>Reject</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Remove</td>
              <td>Yafa Ahmad Hakam Alhafi</td>
              <td>4A</td>
              <td>
                <a href="requests.php"><button>Accept</button></a>
              </td>
              <td>
                <a href="requests.php"><button>Reject</button></a>
              </td>
            </tr>
            <tr>
              <td>Add</td>
              <td>Yafa Ahmad Hakam Alhafi</td>
              <td>4A</td>
              <td>
                <a href="requests.php"><button>Accept</button></a>
              </td>
              <td>
                <a href="requests.php"><button>Reject</button></a>
              </td>
            </tr>
            <tr>
              <td>Remove</td>
              <td>Yafa Ahmad Hakam Alhafi</td>
              <td>4A</td>
              <td>
                <a href="requests.php"><button>Accept</button></a>
              </td>
              <td>
                <a href="requests.php"><button>Reject</button></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"
    ></script>
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