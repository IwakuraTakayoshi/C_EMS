<?php
session_start();
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $name  = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $pass  = $_POST["password"] ?? '';

    if (empty($name) || empty($email) || empty($pass)) {
        $_SESSION["error"] = "All fields are required.";
        header("Location: register.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Invalid email format.";
        header("Location: register.php");
        exit();
    }

    if (strlen($pass) < 6 || strlen($pass) > 15) {
        $_SESSION["error"] = "Password must be between 6 and 15 characters.";
        header("Location: register.php");
        exit();
    }

    if (!preg_match("/[A-Z]/", $pass) || !preg_match("/[0-9]/", $pass)) {
        $_SESSION["error"] = "Password must contain at least one uppercase letter and one number.";
        header("Location: register.php");
        exit();
    }
    
    $sql = "SELECT id FROM hosts WHERE email = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION["error"] = "Email is already registered.";
        header("Location: register.php");
        exit();
    }

    $password = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO hosts (name, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
    $stmt->execute([$name, $email, $password]);
    } catch (PDOException $e) {
        $_SESSION["error"] = "Registration failed. Please try again.";
        header("Location: register.php");
        exit();
    }

    header("Location: login.php");
    exit();
}
