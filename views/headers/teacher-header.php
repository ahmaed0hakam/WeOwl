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

?>

<header>
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
          <a href="index.php?id=<?php echo $idcheck?> " class="navbar-brand"
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
                <a href="index.php?id=<?php echo $idcheck?> " class="nav-link">Classes</a>
              </li>
              <div style="height:20px; width:1px; background-color:white;"></div>
              <li style="padding: 0 7px" class="nav-item">
              <a href="chats.php"><i class="fas fa-comments" style="color:white"></i></a>
              </li>
              <div style="height:20px; width:1px; background-color:white;"></div>
              <li class="nav-item">
              <div class="" id="navbarNavDarkDropdown">
                  <ul class="navbar-nav" style="position: abslute !important;">
                   <li class="nav-item dropdown notification">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >
                        <span class="fas fa-user" style="color:white"></span>
                        </a>
                        <ul class="notification-list dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <li class="dropdown-item">
                          <a href="edit-password.php?id=<?php echo $idcheck?> " class="nav-link">Profile</a>
                        </li>
                        <li class="dropdown-item">
                          <a href="teacher-logout.php" class="nav-link">Logout</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>