<?php 
include('../../config.php');

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: manager-login.php');
    session_unset();
    session_destroy();
    exit;
}

$notification_id = $id = $_POST['id'];

$stmt = "UPDATE notifications SET viewed = 1 WHERE id = $notification_id;";
mysqli_query($conn, $stmt);


?>