<?php
session_start();

if (isset($_SESSION['error'])) {
    echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
</head>
<body class="container mt-5">

<?php include "../config/navbar.php";?>

    <h2>Register As A Host</h2>

    <form action="register_process.php" method="POST" class="register-form">
        <input type="text" name="username"  placeholder="Fullname" class="form-control"><br><br>
        <input type="email" name="email" placeholder="Email"  class="form-control"><br><br>
        <input type="password" name="password" placeholder="Password" class="form-control"><br><br>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <?php include "../config/footer.php";?>
</body>
</html>