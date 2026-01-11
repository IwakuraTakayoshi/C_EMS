<?php
session_start();

$token = $_GET['event'] ?? '';

if ($token === '') {
    die("Invalid event link.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
</head>
<body class="container mt-5 text-center">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/u_ems/index.php">
                C-EMS
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                </ul>
            </div>
        </div>
    </nav>

    <div class="success-box">
        <h2 class="text-success mb-3">🎉 Registration Successful!</h2>

        <p class="mb-3">
            Thank you for registering. Your spot has been successfully reserved.
        </p>

        <p class="text-muted">
            You may close this page or return to the registration page.
        </p>

        <?php if ($token): ?>
            <a href="registration.php?event=<?= htmlspecialchars($token) ?>" class="btn btn-primary mt-3">
                Back to Event
            </a>
        <?php endif; ?>
    </div>

    <?php include "../include/footer.php";?>

</body>
</html>
