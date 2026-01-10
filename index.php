<?php
session_start();

if (!isset($_SESSION["host_id"])) {
    header("Location: host/login.php");
    exit;
}

require "config/db.php";
$host_id = $_SESSION["host_id"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
</head>
<body class="container mt-5">

<?php include "config/navbar.php";?>

    <div class="card p-4">
<h2>Welcome, <?php echo htmlspecialchars($_SESSION["host_name"]); ?></h2>

<?php
$sql = "
SELECT 
    e.*,
    COUNT(r.id) AS total_registrations,
    SUM(CASE WHEN r.gender = 'male' THEN 1 ELSE 0 END) AS males,
    SUM(CASE WHEN r.gender = 'female' THEN 1 ELSE 0 END) AS females
FROM events e
LEFT JOIN registrations r ON e.id = r.event_id
WHERE e.host_id = ?
GROUP BY e.id
ORDER BY e.created_at DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$host_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h3 class="mt-4">My Events</h3>

<?php if (empty($events)): ?>
    <p>No events created yet.</p>
<?php else: ?>

<table class="table table-striped">
<thead>
<tr>
    <th>Event</th>
    <th>Date</th>
    <th>Registrations</th>
    <th>Gender (M / F)</th>
    <th>Status</th>
    <th>Slots Left</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>

<?php foreach ($events as $event): ?>
    <?php
        $today = date("Y-m-d");

        $reg_open = (
            !empty($event["reg_start_date"]) &&
            !empty($event["reg_end_date"]) &&
            $today >= $event["reg_start_date"] &&
            $today <= $event["reg_end_date"]
        );

        $available_slots = "Unlimited";
        if (!empty($event["max_participants"])) {
            $available_slots = max(
                $event["max_participants"] - $event["total_registrations"],
                0
            );
        }
    ?>
<tr>
    <td><?= htmlspecialchars($event["event_name"]) ?></td>
    <td><?= htmlspecialchars($event["event_date"]) ?></td>
    <td><?= (int)$event["total_registrations"] ?></td>
    <td><?= (int)$event["males"] ?> / <?= (int)$event["females"] ?></td>
    <td>
        <span class="badge <?= $reg_open ? 'bg-success' : 'bg-danger' ?>">
            <?= $reg_open ? 'Open' : 'Closed' ?>
        </span>
    </td>
    <td><?= $available_slots ?></td>
    <td>
        <a href="events/view_event_reg.php?id=<?= (int)$event["id"] ?>"
           class="btn btn-sm btn-primary">
           View Registrants
        </a>
        <div class="mt-1">
            <input type="text"
                class="form-control form-control-sm"
                value="http://localhost/c_ems/public/registration.php?event=<?= htmlspecialchars($event["unique_token"]) ?>"
                readonly
                onclick="this.select();">
        </div>
    </td>

</tr>
<?php endforeach; ?>

</tbody>
</table>
<?php endif; ?>

<br>

<?php include "config/footer.php";?>

</body>
</html>
