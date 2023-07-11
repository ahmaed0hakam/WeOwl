<?php
include('../../config.php');

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: manager-login.php');
    session_unset();
    session_destroy();
    exit;
}

// Get the notification ID from the AJAX request
$notificationID = $_POST['notificationID'];

// Fetch the notification content from the database
$query = "SELECT content FROM notifications WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $notificationID]);
$notification = $stmt->fetch();

// Return the notification content as JSON
echo json_encode($notification);
?>
