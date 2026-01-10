<?php
session_start();
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header("Location: ../index.php");
    exit();
}

$event_id = $_POST["event_id"] ?? '';
$event_token = $_POST["event_token"] ?? '';

$full_name = trim($_POST["full_name"] ?? '');
$email = trim($_POST["email"] ?? '');
$phone = trim($_POST["phone"] ?? '');
$gender = $_POST["gender"] ?? '';
$location = trim($_POST["location"] ?? '');
$expectation = trim($_POST["expectation"] ?? '');

if ($event_id === '' || $event_token === '' || $full_name === '' || $email === '' || $phone === '' || $gender === '') {
    die("All required fields must be filled.");
}

$sql = "SELECT * FROM events WHERE id = ? LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Invalid event.");
}

// Prevent duplicate registration (same email, same event)
$sql = "SELECT id FROM registrations WHERE event_id = ? AND email = ? LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id, $email]);

if ($stmt->fetch()) {
    die("This email has already been registered for this event.");
}

$today = date("Y-m-d");
if (
    $today < $event['reg_start_date'] ||
    $today > $event['reg_end_date']
) {
    die("Registration is closed.");
}

if (!empty($event['max_participants'])) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $count = $stmt->fetchColumn();

    if ($count >= $event['max_participants']) {
        die("This event is fully booked.");
    }
}

$sql = "INSERT INTO registrations
(event_id, full_name, email, phone, gender, location, expectation)
VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $event_id,
    $full_name,
    $email,
    $phone,
    $gender,
    $location,
    $expectation
]);

header("Location: registration_success.php?event=" . urlencode($event_token));
exit();

