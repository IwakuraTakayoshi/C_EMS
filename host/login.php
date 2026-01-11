<?php
session_start();

if (isset($_SESSION["error"])) {
    echo "<p style='color:red'>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
</head>
<body class="container mt-5">

<?php include "../include/navbar.php";?>

    <h2>Host Login</h2>
    <form action="login_process.php" method="POST">
    <input type="email" name="email" placeholder="Email" class="form-control"><br><br>
    <input type="password" name="password" placeholder="Password" class="form-control"><br><br>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php include "../include/footer.php";?>

</body>
</html>