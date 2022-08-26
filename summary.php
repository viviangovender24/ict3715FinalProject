
<?php
// Include config file
require_once "config.php";

// variables
$date = "";
$msg = "";

$sql = " SELECT * FROM `exam` WHERE date= ? ";
if ($stmt = $mysqli->prepare($sql)) 
{
	
	if( empty($_GET['start']) )
	{
		$msg = 'Please Enter Date '; 
	}
	else
	{
		
		if( !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$_GET['start']) )
		{
			$msg = 'Enter Date in YY-MM-DD Format '; 
		}
	   else
	   {	
		$date=$_GET['start'];
		
		$stmt->bind_param("s", $param_date);
	    $param_date = $date;
		
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

     
<form action = "summary.php" method = "get">
    <label></br>Date : </label><input type="text" name="start" class="datepicker" id='start' >
    <input type="submit" value="Submit" id ="submit">
</form>

    <meta charset="UTF-8">
    <title>Total By Date</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Exams For Date : <?php echo $msg; ?> </br></h1>
    <p>
		<a href="admin.php" class="btn btn-secondary btn-lg btn-block " >Back</a>
    </p>
	
	
</body>
</html>
