<?php
session_start();
session_unset();
session_destroy();
header("Location: manager-login.php");
exit();
?>