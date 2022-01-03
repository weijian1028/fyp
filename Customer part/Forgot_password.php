<?php
session_start();
?>
<?php include("connection.php"); ?>
<?php
// Define variables and initialize with empty values
$useremail = "";
$useremail_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["reset_password"])){
    
    include "sendmail.php";    
    // Check if email is empty
    if(empty(trim($_POST["user_email"]))){
        $useremail_err = "Please enter your email.";
    } else{
        $useremail = trim($_POST["user_email"]);
    }
    // Validate credentials
    if(empty($useremail_err)){

        $result = mysqli_query($connect,"SELECT * from users where Member_email = '$useremail'" );
		$count=mysqli_num_rows($result);
		if ($count == 1)
		{
            $password = randomPassword();
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($connect,"update users set password = '$hash_password' where Member_email = '$useremail' ");
            send_new_password($password,$useremail);
            header("location:Login.php");
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
	<link rel="stylesheet" href="css/Forgot.css">
    <link rel="stylesheet" href="css/Basic.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<!-- header bar -->
<div id="header">
<a class="title"><span class="animationstyle">Bakery Shop</span></a>
<a href="#home" class="nav__link">
	<span class="material-icons">email</span>bakery@hotmail.com</a>
	<a href="#home" class="nav__link">
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
	<?php 
		$cate_result = mysqli_query($connect, "select * from category where Category_isDelete = 0");
		while($row = mysqli_fetch_assoc($cate_result))
		{
		?>	
			<a href="Category.php?comein&code=<?php echo $row["Category_ID"]; ?>"><?php echo $row["Category_name"];?></a>
		<?php
		}
		?>
    </div>
  </div> 
  <a href="Contact.php" class="nav__link">
	<span class="material-icons">perm_phone_msg</span>Contact</a>
	
	<div class="righthandside">
	<a href="Category.php" class="nav__link">
	<span class="material-icons">shopping_cart</span>Shop</a>
	
	<div class="dropdown">
    <button class="dropbtn"><span class="material-icons">account_circle</span>
	<?php
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    ?><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
	<?php
	}
	?>	
    </button>
    <div class="dropdown-content">
      <a href="Profile.php">Profile</a>
      <a href="Cart.php">Cart</a>
	  <a href="Payment.php">Payment</a>
	  <a href="History.php">Order History</a>
      <a href="Logout.php">Log out</a>
    </div>
  </div> 
	</div>
</div>


<div>
	<img src="image/log.jpg" class="bg">
<div id="box">
	<div id="form">
    <div class="wrapper">
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
            </div>
        </form>
    </div>   
	</div>
</div>	
</div>
</body>
</html>








