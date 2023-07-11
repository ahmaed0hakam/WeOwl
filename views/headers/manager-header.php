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
$sql1 = "SELECT * FROM notifications WHERE user_type ='manager' AND user_id = $idcheck ORDER BY id DESC";
$result10 = mysqli_query($conn, $sql1);
$notifications = array();
if (mysqli_num_rows($result10) > 0) {
    while ($notification = mysqli_fetch_assoc($result10)) {
        $notifications[] = $notification;
    }
}
?>
<header>
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container" >
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
              <div class=" navbar-brand" id="navbarNavDarkDropdown">
                  <ul class="navbar-nav">
                   <li class="nav-item dropdown notification bell">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"  >
                          <span class="fas fa-bell" style="color:white"></span><span class="badge"></span>
                        </a>
                        <ul class="notification-list dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <!-- Add initial notification items here -->
                            <?php
                            if(count($notifications)==0){ ?>
                            <li class="dropdown-item">There is no notification</li>
                            <?php }?>
                            <?php
                            for ($i=0;$i<count($notifications) && $i<7; $i++) { ?>
                          <li> <a class="dropdown-item" href="#" onclick="openModal('<?php echo $notifications[$i]['id']; ?>', '<?php echo $notifications[$i]['title']; ?>','<?php echo $notifications[$i]['content']; ?>')"><?php echo $notifications[$i]['title']; ?></a></li>
                        <?php } ?>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li>
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
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-item">
                          <a href="manager-logout.php" class="nav-link">Logout</a>
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