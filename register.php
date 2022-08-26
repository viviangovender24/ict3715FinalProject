<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$surname = $fname = $student_num = $surname = $first_name = $username = $password = $confirm_password = "";
$surname_err = $fname_err = $student_numerr = $surname_err = $first_nameerr = $username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
 
    // Validate username
    if(empty(trim($_POST["username"])))
	{
        $username_err = "Please enter a username.";
    } 
	elseif(!preg_match('/[a-zA-Z0-9@.]/',$_POST["username"]) )
	{
        $username_err = "Username not valid.";
    } 
	else
{
        // Prepare a select statement
        $sql = "SELECT id FROM student WHERE email = ?";
        
        if($stmt = $mysqli->prepare($sql))
		{
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute())
			{
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1)
				{
                    $username_err = "This username is already taken.";
                } 
				else
				{
                    $username = trim($_POST["username"]);
                }
				
				if(!preg_match('/@mylife.unisa.ac.za$/',$_POST["username"] ))
				{
					$username_err = "Not a valid UNISA email: ".$username;
				}
            } 
			else
			{
                echo "Oops! Something went wrong. Please try again later.";
				
            }

            // Close statement
            $stmt->close();
        }
    }
	
	
	    // Validate student number
    if(empty(trim($_POST["student_num"])))
	{
        $student_numerr = "Please enter a password.";     
    } elseif( (strlen(trim($_POST["student_num"])) != 8) )
	{
        $student_numerr = "Student Number must be 8 Digits eg,12345678.";
    } 
	elseif( !preg_match('/^[0-9]*$/', trim($_POST["student_num"])) )
	{
		$student_numerr = "Student Number must be [0-9]";
	}
	else
	{
        $student_num = trim($_POST["student_num"]);
    }
	
       // Validate first name
    if(empty(trim($_POST["fname"])))
	{
        $fname_err = "Please enter First Name.";     
    } elseif(  !preg_match('/^[a-zA-Z]+$/', trim($_POST["fname"])) )
	{
        $fname_err = "Invalid First Name";
    } 
	else
	{
        $fname = trim($_POST["fname"]);
    }
	
	       // Validate surname
    if(empty(trim($_POST["surname"])))
	{
        $surname_err = "Please enter Surname.";     
    } elseif(  !preg_match('/^[a-zA-Z]+$/', trim($_POST["surname"])) )
	{
        $surname_err = "Invalid Surname";
    } 
	else
	{
        $surname = trim($_POST["surname"]);
    }
	
    // Validate password
    if(empty(trim($_POST["password"])))
	{
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) != 8){
        $password_err = "Password must have 8 characters.";
    } 
	else
	{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
	
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($surname_err) && empty($first_nameerr) && empty($student_numerr) && empty($fname_err) && empty($surname_err) )
	{
        
        // Prepare an insert statement
        $sql = "INSERT INTO student (student_num, surname, first_name, email, pass) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $param_num, $param_fname, $param_surname, $param_username, $param_password);
            
            // Set parameters
			$param_num = $student_num;
			$param_fname = $fname;
			$param_surname = $surname;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute())
			{
                // Redirect to login page
                header("location: login.php");
            } 
			else
			{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
		
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 16px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Register</h2>
        <p>Please fill this form to create an login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username / Email</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
				
            </div> 

			
            <div class="form-group">
                <label>Student Number</label>
                <input type="text" name="student_num" class="form-control <?php echo (!empty($student_numerr)) ? 'is-invalid' : ''; ?>" value="<?php echo $student_num; ?>">
                <span class="invalid-feedback"><?php echo $student_numerr; ?></span>
				
            </div> 
			
			<div class="form-group">
                <label>First Name </label>
                <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
				
            </div>
			
			<div class="form-group">
                <label>Surname </label>
                <input type="text" name="surname" class="form-control <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $surname; ?>">
                <span class="invalid-feedback"><?php echo $surname_err; ?></span>
				
            </div>
			
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have a login? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>