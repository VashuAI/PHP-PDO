<?php
session_start();
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../classes/Search.php';

$search = new Search();

// Get search keyword and userType from the request
$keyword = $_GET['q'] ?? '';
$userType = $_GET['userType'] ?? '';

// Success message handling
$successMessage = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);

// Perform the search
$results = $search->globalSearch($keyword, $userType);
?>

<table class="table">
 
    <tbody>
        <?php foreach ($results as $table => $data): ?>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <?php if (isset($_SESSION['superadmin_logged_in'])): ?>
                        <td>
                            <a href="../classes/edit_user.php?type=<?= $userType ?>&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</button>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>


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
          <?= htmlspecialchars($successMessage) ?>
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
