<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';

if (!isset($_SESSION['superadmin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$conn = $database->connect();

$id = $_GET['id'];
$userType = $_GET['type'];

$table = ($userType === 'admin') ? 'admins' : 'users';

// Delete the user
$stmt = $conn->prepare("DELETE FROM $table WHERE id = :id");
$stmt->execute([':id' => $id]);

// Set success message
$_SESSION['success_message'] = ucfirst($userType) . " deleted successfully!";

// Redirect back to the previous page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
