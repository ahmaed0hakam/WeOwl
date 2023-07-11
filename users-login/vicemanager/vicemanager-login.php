<?php
session_start();
 include('../../config.php');
 $error_masseg=NULL;
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // get the submitted username and password
  $username = $_POST['username'];
  $password = $_POST['password'];

  // prepare a SQL statement to select the user with the submitted credentials
  $sql = "SELECT * FROM vice WHERE email='$username'";

  // execute the SQL statement
  $result = mysqli_query($conn, $sql);

  // check if the query returned any rows
  if (mysqli_num_rows($result) == 1) {
    // the user exists, retrieve the hashed password from the database
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];

    // compare the submitted password with the hashed password
    if (password_verify($password, $hashed_password)) {
      // the credentials are correct, redirect to the parent home page
      $_SESSION['id'] = $row['id'];
      header("Location: index.php");
      exit;
    } else {
      // the password is incorrect, show an error message
      $error_masseg = "Invalid username or password.";
    }
  } else {
    // the user does not exist, show an error message
    $error_masseg = "Invalid username or password.";
  }
}
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../users-login.css" />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="../../images/logo/apple-touch-icon.png"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    <title>ViceManager Login - WeOwl</title>
  </head>
  <body>
    <article>
      <h2 class="form-title">Login as Vice Manager</h2>
      <form action="#" method="POST">
      <?php
        if(strlen($error_masseg)!=0){
          echo "<span class='fas fa-exclamation-triangle'> ".$error_masseg."</span>";
        } ?>
        <label for="username">
          <span>Email</span>
          <input type="text" name="username" id="username" placeholder="Enter your email"/>
        </label>
        <label for="psw">
          <span>Password</span>
          <input type="password" name="password" id="psw" placeholder="Enter your password"/>
        </label>
        <input type="submit" id="send" value="Login" />
        <div class="another-options">
          <a href="../parent/parent-login.php">login as Parent</a>
          <a href="../teacher/teacher-login.php">login as Teacher</a>
          <a href="../manager/manager-login.php">login as Manager</a>
        </div>
      </form>
    </article>
  </body>
</html>
