<?php
 include('../../config.php');
 header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
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
$parent_ID=$_POST['parent_id'];
if (isset($parent_ID)) {
  if ($parent_ID != $idcheck) {
      // User is trying to access another user's account, redirect to login page
      $_SESSION['error'] = "You are not authorized to access this page. Please do not try this again.";
      echo "<script>alert('{$_SESSION['error']}');</script>";
      echo "<script>setTimeout(function(){window.location.href='index.php?id={$idcheck}'});</script>";
      exit;
  }
}
  $teacher_ID=$_POST['teacher_id'];

  $query2 = "SELECT * FROM messages WHERE (sender_id =$teacher_ID AND receiver_id =$parent_ID) or  (sender_id =$parent_ID AND receiver_id =$teacher_ID)";
  $result2 = mysqli_query($conn , $query2);


  $query5="SELECT * FROM teacher WHERE (id = $teacher_ID)";
  $result5 = mysqli_query($conn , $query5);
  $row5 = mysqli_fetch_assoc($result5);
  $teacher_first_name= $row5['first_name'];
  $teacher_last_name= $row5['last_name'];


  $sql1 = "SELECT * FROM notifications WHERE user_type ='parent' AND user_id = $idcheck ORDER BY id DESC";
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
  <script src="../../app/app.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Class Page</title>
    <link rel="stylesheet" href="parent-home.css/teacher-home.css" />
    <link rel="stylesheet" href="parent-home.css/chat.css" />
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  </head>
  <body ng-controller="myController">
  <div ng-include="'../../views/headers/parent-header.php'"></div>
    <div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3 id="modal-title"></h3>
    <div id="modal-content"></div>
  </div>
  </div>
    <div id="chat-header">
    <h4>Teacher <?php echo $teacher_first_name." ".$teacher_last_name?></h4>
</div>
    <div class="chat-container" id="chat">
    <?php
if ($result2) {
    while ($row = mysqli_fetch_assoc($result2)) {
        $messags = $row['messag'];
        $publish_date = explode(' ',$row['publish_date']);
        $today_date = date("Y-m-d");
        $currentDate = date('Y-m-d', strtotime('today'));
        $currentDateAsString = (string)$currentDate;
        if ($publish_date[0]==date('Y-m-d', strtotime('today'))){
          $publish_date[0]="Today";
        }
        else if ($publish_date[0]==date('Y-m-d', strtotime('yesterday'))){
          $publish_date[0]="Yesterday";
        }

        $senderID = $row['sender_id'];

        $publish_date[1]= substr($publish_date[1],0,-3);

        $query3 = "SELECT * FROM teacher WHERE id = $senderID";
        $result3 = mysqli_query($conn, $query3);
        if ($result3 && mysqli_num_rows($result3) > 0) {
            $row3 = mysqli_fetch_assoc($result3);
            $name = $row3['first_name'];
            $name2 = $row3['last_name'];
            $userClass = "me";
        } else {
            $query4 = "SELECT * FROM parent WHERE id = $senderID";
            $result4 = mysqli_query($conn, $query4);
            if ($result4 && mysqli_num_rows($result4) > 0) {
                $row4 = mysqli_fetch_assoc($result4);
                $name = $row4['first_name'];
                $name2 = $row4['last_name'];
                $userClass = "others";
            } else {
                $name = "Unknown";
                $name2 = ""; // Set a default value for $name2
            }
        }

        echo "<div class='msg-div $userClass'>
               <span class='text'>$messags</span>
               <h6>sent $publish_date[0] by $name $name2 at $publish_date[1]</h6>
              </div>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
  
</div>
<div id="message-field-container">
  <form id="handleform">
    <label for="message">
      <textarea name="message" id="message" cols="30" rows="2" placeholder="Message" required ></textarea>
    </label>
    <input type="text" name="parent_id" id="parent_id" value="<?php echo $parent_ID;?>" hidden>
    <input type="text" name="teacher_id" id="teacher_id" value="<?php echo $teacher_ID;?>" hidden>
    <input type="submit" id="send" value="Send" />
  </form>
</div>


<div ng-include="'../../views/footer.html'"></div>
<script>
      window.addEventListener('load', function() {
  var chat = document.getElementById('chat');
  chat.scrollTop = chat.scrollHeight;
  window.scrollTo(0, document.body.scrollHeight);

  var form = document.getElementById('handleform');
  var messageInput = document.getElementById('message');
  
  form.addEventListener('submit', function(event) {
    if (messageInput.value.trim() === '') {
      event.preventDefault(); // Prevent form submission
      alert('Please enter a message.'); // Show an error message
    }
  });
});
    </script>


<script>
$(document).ready(function() {
  $('#handleform').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the form data
    var formData = $(this).serialize();

    // Send an AJAX request to the server
    $.ajax({
      type: 'POST',
      url: 'sendMessageTO.php',
      data: formData,
      success: function(response) {
        // Display the success message or perform any additional actions
        console.log(response);

        // Append the new message to the chat container
        var message = $('#message').val();
        var newMessageHtml = '<div class=" me msg-div others"><span class="text">' + message + '</span><h6>sent Today by You at ' + getCurrentTime() + '</h6></div>';
        $('#chat').append(newMessageHtml);

        // Clear the message input field
        $('#message').val('');

        // Scroll to the bottom of the chat container
        var chatContainer = document.getElementById('chat');
        chatContainer.scrollTop = chatContainer.scrollHeight;
      },
      error: function(xhr, status, error) {
        // Handle any errors that occurred during the AJAX request
        console.log(error);
      }
    });
  });

  // Function to get the current time in HH:MM format
  function getCurrentTime() {
  var now = new Date();
  now.setHours(now.getHours() - 1); // Subtract one hour
  var hours = now.getHours().toString().padStart(2, '0');
  var minutes = now.getMinutes().toString().padStart(2, '0');
  return hours + ':' + minutes;
}
});

</script>

</body>
    </html>
  
 <script>

<?php
  $sql1 = "SELECT * FROM notifications WHERE user_type ='parent' AND user_id = $idcheck AND viewed = 0";
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