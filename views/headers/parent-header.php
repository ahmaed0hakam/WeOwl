
<?php include('../../config.php');


session_start();
if (!isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
    header('Location: parent-login.php');
    exit;
}
$idcheck=$_SESSION['id'];

$sql1 = "SELECT * FROM notifications WHERE user_type ='parent' AND user_id = $idcheck ORDER BY id DESC";
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
        <div class="container">
          <a href="index.php? id=<?php echo $idcheck?>" class="navbar-brand"
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
                <a href="attendance.php? id=<?php echo $idcheck?> " class="nav-link">Attendance</a>
              </li>
              <div style="height:20px; width:1px; background-color:white;"></div>
              <li style="padding: 0 7px" class="nav-item">
              <a href="chats.php"><i class="fas fa-comments" style="color:white"></i></a>
              </li>
              <div style="height:20px; width:1px; background-color:white;"></div>
            <li class="nav-item">
              <div class="" id="navbarNavDarkDropdown">
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
                          <a href="parent-logout.php" class="nav-link">Logout</a>
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