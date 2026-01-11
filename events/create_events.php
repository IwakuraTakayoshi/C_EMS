<?php
session_start();

if (!isset($_SESSION["host_id"])) {
    header("Location: ../host/login.php");
    exit();
}

if (isset($_SESSION["error"])) {
    echo "<p style='color:red'>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
}
require "../config/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Event</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
</head>
<body class="container mt-5">

<?php include "../include/navbar.php";?>

<h2>Create Event</h2>

<form action="create_event_process.php" method="POST">

    <div class="mb-3">
        <label class="form-label">Event Name</label>
        <input type="text" name="event_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Event Date</label>
        <input type="date" name="event_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Event Time</label>
        <input type="time" name="event_time" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Maximum Participants (optional)</label>
        <input type="number" name="max_participants" class="form-control" min="1">
    </div>

    <div class="mb-3">
        <label class="form-label">Registration Start Date</label>
        <input type="date" name="reg_start" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Registration End Date</label>
        <input type="date" name="reg_end" class="form-control" required>
    </div>

    <button class="btn btn-success">Create Event</button>
    <a href="../index.php" class="btn btn-secondary">Back</a>
</form>

<?php include "../include/footer.php";?>

</body>
</html>
