<?php
session_start();
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $email = trim($_POST["email"] ?? '');
    $passWord = $_POST["password"] ?? '';

    if (empty($email) || empty($passWord)) {
        $_SESSION["error"] = "All fields are required.";
        header("Location: login.php");
        exit();
    }

    $sql = "SELECT * FROM hosts WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $host = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$host || !password_verify($passWord, $host['password'])) {
        $_SESSION["error"] = "Invalid login credentials.";
        header("Location: login.php");
        exit();
    }

    $_SESSION["host_id"] = $host["id"];
    $_SESSION["host_name"] = $host["name"];

    header("Location: ../index.php");
    exit();
}
