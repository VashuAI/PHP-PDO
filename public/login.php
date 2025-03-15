<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM superadmins WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $password === $admin['password']) {
        $_SESSION['superadmin_logged_in'] = true;
        header("Location: superadmin.php");
        exit;
    } else {
        echo "Invalid credentials!";
    }
}
?>

<main>

<div class="container d-flex justify-content-center align-items-center vh-70">
    <div style="margin-top: 30px;" class="card p-4 shadow-lg" style="width: 400px;">
      <h3 class="text-center mb-4">Login</h3>
      <form method="POST" action="">
        <div class="mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
      
    </div>
  </div>

</main>
<?php
require_once __DIR__ . '/../includes/footer.php';
?>