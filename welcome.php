<?php
// Initialize the session
session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></br> Welcome to the Online Exam Portal </h1>
    <p>
        <a href="student.php" class="btn btn-primary btn-lg btn-block " >Student</a>
		<a href="admin.php" class="btn btn-secondary btn-lg btn-block " >Admin</a>
		<a href="reset-password.php" class="btn btn-warning btn-lg btn-block">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger btn-lg btn-block">Sign Out of Your Account</a>
    </p>
</body>
</html>