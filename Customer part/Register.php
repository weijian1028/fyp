<?php include("connection.php"); ?>

<?php

// Define variables and initialize with empty values
$username = $password = $confirm_password = $memberic = $memberphone = $memberemail = $memberemailvalid = "";
$username_err = $password_err = $confirm_password_err = $memberic_err = $memberphone_err = $memberemail_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($connect, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
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
    
    // Validate ic
    if(empty(trim($_POST["member_ic"])))
    {
        $memberic_err = "Please enter your IC number.";     
    } 
    else if(strlen(trim($_POST["member_ic"])) != 12)
    {
        $memberic_err = "Invalid IC number (must have 12 numbers).";
    } 
    else
    {
        $memberic = trim($_POST["member_ic"]);
    }

    // Validate phone
    if(empty(trim($_POST["member_phone"])))
    {
        $memberphone_err = "Please enter your phone number.";     
    } 
    else
    {
        $memberphone = trim($_POST["member_phone"]);
    }

    // Validate e-mail
    if (empty($_POST["member_email"])) 
    {
        $memberemail_err = "Please enter your email";
    }
    else 
    {
        $memberemailvalid = trim($_POST["member_email"]);
        $result = mysqli_query($connect,"SELECT * from users where Member_email = '$memberemailvalid'" );
		$count=mysqli_num_rows($result);
		if ($count == 0)
		{
            $memberemail = trim($_POST["member_email"]);
            // check if e-mail address is well-formed
            if (!filter_var($memberemail, FILTER_VALIDATE_EMAIL)) 
            {
                $memberemail_err = "Invalid email format"; 
            }
		}
		else
		{
			$memberemail_err = "The email name is already taken";
		}
        
     }

     $membergender = trim($_POST["member_gender"]);
     $memberaddress = trim($_POST["member_address"]);

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) &&empty($memberemail_err) &&empty($memberic_err) &&empty($memberphone_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password,Member_IC,Member_phone,Member_gender,Member_email,Member_address) 
        VALUES (?, ?,'$memberic','$memberphone','$membergender','$memberemail', '$memberaddress')";
        
        if($stmt = mysqli_prepare($connect, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: Login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
	<link rel="stylesheet" href="css/Basic.css">
	<link rel="stylesheet" href="css/Register.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="script/sidebar.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }

	</style>
</head>
<body>
<!-- header bar -->
<div id="header">
<a class="title"><span class="animationstyle">Bakery Shop</span></a>
<a href="#" class="nav__link">
	<span class="material-icons">email</span>bakery@hotmail.com</a>
	<a href="#" class="nav__link">
	<span class="material-icons">phone</span>016-1234567</a>
</div>

<!-- Home bar -->
<div class="navbar">
  <a href="Homepage.php" class="nav__link">
	<span class="material-icons">home</span>Home</a>
  <a href="About.php" class="nav__link">
	<span class="material-icons">info</span>About</a>
  <a href="Service.php" class="nav__link">
	<span class="material-icons">build_circle</span>Service</a>
 <div class="dropdown">
    <button class="dropbtn">Category 
     <span class="material-icons">keyboard_arrow_down</span>
    </button>
    <div class="dropdown-content">
      <a href="Profile.php">Profile</a>
      <a href="Cart.php">Cart</a>
	  <a href="Payment.php">Payment</a>
	  <a href="History.php">Order History</a>
      <a href="Logout.php">Log out</a>
    </div>
  </div> 
  <a href="Contact.php" class="nav__link">
	<span class="material-icons">perm_phone_msg</span>Contact</a>
	
	<div class="righthandside">
	<a href="Category.php" class="nav__link">
	<span class="material-icons">shopping_cart</span>Shop</a>
	
	<div class="dropdown">
    <button class="dropbtn"><span class="material-icons">account_circle</span>User 
    </button>
    <div class="dropdown-content">
      <a href="Profile.php">Profile</a>
      <a href="Cart.php">Cart</a>
      <a href="Login.php">Log out</a>
    </div>
  </div> 
	</div>
</div>
<div>
<img src="image/log.jpg" class="bg">
    <div class="wrapper" id="box">
	<img src="image/logo.png" class="logo">
	<div id="form">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span style="color:#EBF2A9;"><?php echo $username_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($memberemail_err)) ? 'has-error' : ''; ?>">
                <label>Email:</label>
                <input type="text" name="member_email" class="form-control" value="<?php echo $memberemail; ?>">
                <span style="color:#EBF2A9;"><?php echo $memberemail_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($memberic_err)) ? 'has-error' : ''; ?>">
                <label>IC number:</label>
                <input type="text" name="member_ic" class="form-control" value="<?php echo $memberic; ?>">
                <span style="color:#EBF2A9;"><?php echo $memberic_err; ?></span>
            </div>  
            <label>Gender :</label>
            <select name="member_gender">
            <option name="Male" value="Male">Male</option>
            <option name ="Female" value="Female">Female</option>
            </select>
            <div class="form-group <?php echo (!empty($memberphone_err)) ? 'has-error' : ''; ?>">
                <label>Phone number:</label>
                <input type="text" name="member_phone" class="form-control" value="<?php echo $memberphone; ?>">
                <span style="color:#EBF2A9;"><?php echo $memberphone_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Address:</label>
                <input type="text" name="member_address" class="form-control" value="">
            </div> 
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span style="color:#EBF2A9;"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span style="color:#EBF2A9;"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a class="ff" href="Login.php">Login here</a>.</p>
        </form>
	</div>
    </div>
</div>    
</body>
</html>