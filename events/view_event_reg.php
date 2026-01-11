<?php
session_start();

if (!isset($_SESSION["host_id"])) {
    header("Location: ../host/login.php");
    exit();
}
require "../config/db.php";

$event_id = $_GET['id'] ?? null;
if (!$event_id) {
    $_SESSION["error"] = "Invalid event.";
    header("Location: ../index.php");
    exit();
}

$sql = "
SELECT 
    e.event_name,
    r.full_name,
    r.gender,
    r.email,
    r.phone,
    r.location,
    r.expectation
FROM events e
LEFT JOIN registrations r ON e.id = r.event_id
WHERE e.id = ? AND e.host_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id, $_SESSION['host_id']]);
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$registrations) {
    $_SESSION["error"] = "Event not found or you do not have permission to view it.";
    header("Location: ../index.php");
    exit();
}

$event_name = $registrations[0]['event_name'] ?? 'Event Registrations';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrants</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
</head>
<body class="container mt-5">
    
    <?php include "../include/navbar.php";?>

<h2><?= htmlspecialchars($event_name) ?> – Registrants</h2>

<?php if (empty($registrations) || empty($registrations[0]['full_name'])): ?>
    <p>No registrations yet.</p>
<?php else: ?>

<table class="table table-bordered mt-3">
<thead>
<tr>
    <th>Name</th>
    <th>Gender</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Location</th>
    <th>Expectation</th>
</tr>
</thead>
<tbody>

<?php foreach ($registrations as $reg): ?>
<tr>
    <td><?= htmlspecialchars($reg['full_name']) ?></td>
    <td><?= htmlspecialchars($reg['gender']) ?></td>
    <td><?= htmlspecialchars($reg['email']) ?></td>
    <td><?= htmlspecialchars($reg['phone']) ?></td>
    <td><?= htmlspecialchars($reg['location']) ?></td>
    <td><?= htmlspecialchars($reg['expectation']) ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
<?php endif; ?>

<a href="../index.php" class="btn btn-secondary">Back</a>

<?php include "../include/footer.php";?>

</body>
</html>
