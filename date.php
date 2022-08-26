
<?php
// Include config file
require_once "config.php";

// variables
$date = "";
$msg = "";


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
$sql = " SELECT student.student_num,student.first_name,student.surname,exam.module_code FROM exam,student WHERE date='$date' AND exam.id=student.id ";
			
			$result = $mysqli->query($sql);
			
			
            if ($result->num_rows > 0) 
            {
	          $msg = $result->num_rows;
              // output data of each row
              while($row = $result->fetch_assoc()) 
			  {
              echo $row["student_num"]."        ".$row["first_name"]. " 			 " . $row["surname"]. "			  " . $row["module_code"]."<br>";
              }
            } else 
           {
              echo "0 results";
           }
		}
	   
	}


$mysqli->close();


?>


<!DOCTYPE html>
<html lang="en">
<head>

     
<form action = "date.php" method = "get">
    <label></br>Search Date : </label><input type="text" name="start" class="datepicker" id='start' >
    <input type="submit" value="Submit" id ="submit">
</form>

    <meta charset="UTF-8">
    <title>Search By Date</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Number Of Students : <?php echo $msg; ?> </br></h1>
    <p>
		<a href="admin.php" class="btn btn-secondary btn-lg btn-block " >Back</a>
    </p>
	
	
</body>
</html>
