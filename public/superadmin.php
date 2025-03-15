<?php
$title= "Super Admin";
session_start();
require_once __DIR__ . '/../classes/Database.php';

if (!isset($_SESSION['superadmin_logged_in'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../includes/header.php';

// Success message
$successMessage = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);

// Error message
$errorMessage = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);
?>

<main>
<h2 style="margin-top:30px; text-align:center; background-color:black; padding:10px; color:white;">Super Admin Panel</h2>

<div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4 shadow-lg">
          <h4 class="text-center mb-4">Add User</h4>
          <form method="POST" action="../classes/add_user.php">
            <div class="mb-3">
              <label class="form-label">Select User Type:</label>
              <select class="form-select" name="userType">
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>
            <div class="mb-3">
              <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Data</button>
          </form>
        </div>
      </div>
    </div>
</div>
</main>

<!-- Bootstrap Success Toast -->
<?php if (!empty($successMessage)): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
  <div id="successToast" class="toast bg-success text-white show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-success text-white">
      <strong class="me-auto">Success</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?= htmlspecialchars($successMessage) ?>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Bootstrap Error Toast -->
<?php if (!empty($errorMessage)): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
  <div id="errorToast" class="toast bg-danger text-white show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-danger text-white">
      <strong class="me-auto">Error</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?= htmlspecialchars($errorMessage) ?>
    </div>
  </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
