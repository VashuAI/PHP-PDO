<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Website'; ?></title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<style>
    html,
    body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }
</style>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="/pdo_project/public/index.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pdo_project/public/admins.php">Admin</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/pdo_project/public/superadmin.php">Super Admin Panel</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['superadmin_logged_in'])): ?>
                            
                            <a class="nav-link" href="/pdo_project/public/logout.php">Logout</a>
                        <?php endif; ?>
                    </li>
                </ul>


                <form method="GET" action="" class="d-flex" id="searchForm">
                    <input class="form-control me-2" type="text" name="q" id="searchInput" placeholder="Search..."
                        autocomplete="off" />
                    <input type="hidden" id="userType"
                        value="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'user' : 'admin' ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

            </div>
        </div>
    </nav>


    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let keyword = this.value;
            let userType = document.getElementById('userType').value;

            fetch('search.php?q=' + keyword + '&userType=' + userType)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('dataTable').innerHTML = data;
                });
        });
    </script>