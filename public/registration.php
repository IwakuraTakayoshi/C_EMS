<?php
session_start();
require "../config/db.php";

if (isset($_SESSION["error"])) {
    echo "<p style='color:red'>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
}

$token = $_GET["event"] ?? '';

if ($token === '') {
    die("Invalid event link.");
}

$sql = "SELECT * FROM events WHERE unique_token = ? LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$token]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Event not found.");
}

$today = date("Y-m-d");
$registration_open =
    $today >= $event["reg_start_date"] &&
    $today <= $event["reg_end_date"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
</head>
<body class="container mt-5">

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

<h2><?= htmlspecialchars($event["event_name"]) ?></h2>

<?php if (!$registration_open): ?>
    <div class="alert alert-danger">
        Registration is closed for this event.
    </div>
<?php else: ?>

<form method="POST" action="registration_process.php">

    <input type="hidden" name="event_id" value="<?= $event["id"] ?>">
    <input type="hidden" name="event_token" value="<?= htmlspecialchars($token) ?>">


    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-control" required>
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Expectation</label>
        <textarea name="expectation" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Register</button>
</form>

<?php endif; ?>

<?php include "../include/footer.php";?>

</body>
</html>
