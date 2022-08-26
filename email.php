
<?php
// Include config file
require_once "config.php";

// variables
$msg = "";

$query = $mysqli->prepare("SELECT email FROM student"); // prepate a query
$query->execute(); // actually perform the query
$result = $query->get_result(); // retrieve the result so it can be used inside PHP
$r = $result->fetch_array(MYSQLI_ASSOC); // bind the data from the first result row to $r

	if(!preg_match('/@mylife.unisa.ac.za$/',$r['email'] ))
	{
		$msg =$r['email']; // will return email
	}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invalid Email</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Invalid Email  <?php echo $msg; ?> </br></h1>
    <p>
		<a href="admin.php" class="btn btn-secondary btn-lg btn-block " >Back</a>
    </p>
</body>
</html>
