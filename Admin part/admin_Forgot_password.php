<?php include("connection.php"); ?>
<?php
// Define variables and initialize with empty values
$useremail = "";
$useremail_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["reset_password"])){
    
    include "../Customer part/sendmail.php";    
    // Check if email is empty
    if(empty(trim($_POST["user_email"]))){
        $useremail_err = "Please enter your email.";
    } else{
        $useremail = trim($_POST["user_email"]);
    }
    // Validate credentials
    if(empty($useremail_err)){

        $result = mysqli_query($connect,"SELECT * from admin where admin_email = '$useremail'" );
		$count=mysqli_num_rows($result);
		if ($count == 1)
		{
            $password = randomPassword();
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($connect,"update admin set password = '$hash_password' where admin_email = '$useremail' ");
            send_new_password_admin($password,$useremail);
            //header("location:admin_login.php");
		}
		else
		{
			$useremail_err = "The email name cannot found !";
        }
    }
}
?>
<?php
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }    
    return implode($pass); //turn the array into a string
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
	<link rel="stylesheet" href="css/Admin.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
body{
	background-image:url('https://wallpaperaccess.com/full/303526.jpg');
	background-repeat: no-repeat;
	background-size: cover;
	height:300px;
	width:100%;
}


h2,p,label{
	color:white;
}
    </style>
</head>
<body>



<div class="wrapper" id="container">

    <h2>Forgot Password</h2>
    <p>Please fill your email to reset password.</p>
    <form action="" method="post"> 
        <div class="form-group <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
            <label>Email:</label>
            <input type="text" name="user_email" class="form-control" value="<?php echo $useremail; ?>">
            <span class="help-block"><?php echo $useremail_err; ?></span>
        </div> 
           
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit" name="reset_password">
            <input type="button" class="btn btn-primary" value="Back" onclick="location='admin_login.php'">
        </div>
    </form>
	</div>
	

	
</body>
</html>