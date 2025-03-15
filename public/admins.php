<?php
session_start();
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../classes/Search.php';

$adminModel = new Admin();
$admins = $adminModel->getAdmins();

// By default, show all admin data
$search = new Search();
$results = $search->globalSearch('', 'admin');

// Check if super admin is logged in
$isSuperAdmin = isset($_SESSION['superadmin_logged_in']);

// Success message handling
$successMessage = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);

$title = "Admins";
require __DIR__ . '/../includes/header.php';
?>

<main class="container py-5">
<h2>Admin Panel</h2>

<table class="table table-striped table-hover" border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <?php if ($isSuperAdmin): ?> 
                <th>Action</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody id="dataTable">
        <?php foreach ($results['admins'] as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <?php if ($isSuperAdmin): ?> 
                <td>
                    <a href="../classes/edit_user.php?type=admin&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</button>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</main>

<!-- Bootstrap Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Success Message Modal -->
<?php if ($successMessage): ?>
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="successModalLabel">Success</h5>
        </div>
        <div class="modal-body">
          <?= $successMessage ?>
        </div>
      </div>
    </div>
  </div>
  
  <script>
      var successModal = new bootstrap.Modal(document.getElementById('successModal'));
      successModal.show();
      setTimeout(function() {
        successModal.hide();
      }, 3000);
  </script>
<?php endif; ?>

<script>
    function confirmDelete(userId) {
        const deleteUrl = `../classes/delete_user.php?type=admin&id=${userId}`;
        document.getElementById('confirmDeleteBtn').href = deleteUrl;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
