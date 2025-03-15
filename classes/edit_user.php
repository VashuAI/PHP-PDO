<?php
$title= "Edit User";
session_start();
require_once __DIR__ . '/../classes/Database.php';
require __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['superadmin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$conn = $database->connect();

$id = $_GET['id'];
$userType = $_GET['type'];

$table = ($userType === 'admin') ? 'admins' : 'users';

// Fetch data to edit
$stmt = $conn->prepare("SELECT * FROM $table WHERE id = :id");
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $redirectUrl = $_POST['redirect_url'];

    $update = $conn->prepare("UPDATE $table SET name = :name, email = :email WHERE id = :id");
    $update->execute([
        ':name' => $name,
        ':email' => $email,
        ':id' => $id
    ]);

    $successMessage = ucfirst($userType) . " updated successfully!";
}
?>

<main>
    <h2 style="margin-top:30px; text-align:center; background-color:black; padding:10px; color:white;">Edit
        <?= ucfirst($userType) ?></h2>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-lg">
                    <h4 class="text-center mb-4">Update</h4>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name"
                                value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="<?= htmlspecialchars($user['email']) ?>" required>
                            <!-- Store the previous page URL -->
                            <input type="hidden" name="redirect_url" value="<?= $_SERVER['HTTP_REFERER'] ?>">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Bootstrap Modal for Success Message -->
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
        // Show the popup
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();

        // Redirect to previous page after 5 seconds
        setTimeout(function() {
            window.location.href = "<?= htmlspecialchars($redirectUrl) ?>";
        }, 3000);
    </script>
<?php endif; ?>

<?php require __DIR__ . '/../includes/footer.php'; ?>
