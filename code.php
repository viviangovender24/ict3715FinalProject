
<?php
// Include config file
require_once "config.php";

// variables
$modu = "";
$msg = "";

$sql = " SELECT * FROM `exam` WHERE module_code= ? ";
if ($stmt = $mysqli->prepare($sql)) 
{
	
	if( empty($_GET['start']) )
	{
		$msg = 'Please Enter Module Code '; 
	}
	else
	{
		
		if( strlen(trim($_GET['start'])) != 7) 
		{
			$msg = ' Invalid Module Code '; 
		}
	   else
	   {	
		$modu=$_GET['start'];
		
		$stmt->bind_param("s", $param_modu);
	    $param_modu = $modu;
		
		$stmt->execute();
        $stmt->store_result();
        $msg = $stmt->num_rows;
	   }
	}
	

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="UTF-8">
    <title>Total By Module</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>

<form action = "code.php" method = "get">
    <label></br>Module : </label><input type="text" name="start" class="datepicker" id='start' >
    <input type="submit" value="Submit" id ="submit">
</form>

    <h1 class="my-5">Students For Exam : <?php echo $msg; ?> </br></h1>
    <p>
		<a href="admin.php" class="btn btn-secondary btn-lg btn-block " >Back</a>
    </p>
	
	
</body>
</html>
