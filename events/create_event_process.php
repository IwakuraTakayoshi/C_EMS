<?php
session_start();

if (!isset($_SESSION['host_id'])) {
    header("Location: ../host/login.php");
    exit();
}

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $host_id = $_SESSION['host_id'];

    $event_name = trim($_POST['event_name'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    $event_time = $_POST['event_time'] ?? '';
    $max_participants = $_POST['max_participants'] ?? null;
    $reg_start = $_POST['reg_start'] ?? '';
    $reg_end = $_POST['reg_end'] ?? '';

    if (
        $event_name === '' ||
        $event_date === '' ||
        $event_time === '' ||
        $reg_start === '' ||
        $reg_end === ''
    ) {
        $_SESSION["error"] = "All required fields must be filled.";
        header("Location: create_events.php");
        exit();
    }


    if ($reg_start > $reg_end) {
        $_SESSION["error"] = "Registration end date must be after start date.";
        header("Location: create_events.php");
        exit();
    }

    if ($max_participants !== null && $max_participants !== '') {
        $max_participants = (int)$max_participants;
        if ($max_participants < 1) {
            $_SESSION["error"] = "Maximum participants must be at least 1.";
            header("Location: create_events.php");
            exit();
        }
    } else {
        $max_participants = null;
    }

    $token = bin2hex(random_bytes(8));

    $sql = "INSERT INTO events 
        (host_id, event_name, event_date, event_time, max_participants, reg_start_date, reg_end_date, unique_token)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $host_id,
            $event_name,
            $event_date,
            $event_time,
            $max_participants,
            $reg_start,
            $reg_end,
            $token
        ]);

    } catch (PDOException $e) {
        $_SESSION["error"] = "Event creation failed.";
        header("Location: create_events.php");
        exit();
    }

    header("Location: ../index.php");
    exit();
}
