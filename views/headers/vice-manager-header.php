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
?>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<header>
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
          <a href="index.php" class="navbar-brand"
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
                <a href="index.php" class="nav-link">Classes</a>
              </li>
              <li class="nav-item">
                <a href="teachers-list.php" class="nav-link">Teachers</a>
              </li>
              <li class="nav-item">
                <a href="send-request.php" class="nav-link">Add User</a>
              </li>
              <li class="nav-item">
              <a href="attendance-reports-classes.php" class="nav-link">Attendance Reports</a>
              </li>
              <div style="height:20px; width:1px; background-color:white;"></div>
              <li class="nav-item">
              <div class=" navbar-brand" id="navbarNavDarkDropdown">
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
                          <a href="vicemanager-logout.php" class="nav-link">Logout</a>
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