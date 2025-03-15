<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';

if (!isset($_SESSION['superadmin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userType = $_POST['userType'];
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Validate input
    if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid input data!";
        header('Location: superadmin.php');
        exit;
    }

    // Check for valid user type
    $table = ($userType === 'admin') ? 'admins' : 'users';

    try {
        $stmt = $conn->prepare("INSERT INTO $table (name, email) VALUES (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Set success message
        $_SESSION['success_message'] = "Successfully added to $table!";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Failed to add user. Error: " . $e->getMessage();
    }

    // Redirect to Super Admin panel
    // Redirect with session data
echo "<script>window.location.href='../public/superadmin.php';</script>";

    exit;
}
