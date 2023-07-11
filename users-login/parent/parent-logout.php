<?php
session_start();
session_unset();
session_destroy();
header("Location: parent-login.php");
exit();
?>