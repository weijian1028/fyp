<?php
session_start();
?>
<?php include("connection.php"); ?>
<html>
<head>
<title>Contact</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Contact.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="script/sidebar.js"></script>
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

<!-- Background part -->
<div id="img1">
<img src="image/contact_background1.jpg"></img>
</div>


<!-- Contact part -->
<form action="" method="POST">
<div id="contactpart">
	<div class="contactpart middletext">
	<h2>Contact us</h2>
	<div class="contact-box">
		<input type="text" class="field" name="Contact_Name" placeholder="Your Name">
		<input type="text" class="field" name="Contact_Email" placeholder="Your Email">
		<input type="text" class="field" name="Contact_Phone" placeholder="Phone">
		<textarea placeholder="Message"  name="Contact_Message" class="field"></textarea>
		<input type="submit" name="send" value="Confirm">Send  </input>
	</div>
	<div class="mapouter">
	<a style="color:white; float:left; font-size:20px;">Address:</a>
	<div class="gmap_canvas">
	<iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=2880%20Broadway,%20New%20York&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
	</iframe><a href="https://123movies-to-org.blogspot.com"></a><br>
	<a href="https://www.embedgooglemap.net">adding google map to website</a><style>
	</div>
	</div>
	</div>
</div>
</form>

</body>
</html>
<?php
if(isset($_POST["send"])){
	$cname = $_POST["Contact_Name"];
	$cmail = $_POST["Contact_Email"];
	$cphone = $_POST["Contact_Phone"];
	$cmessage = $_POST["Contact_Message"];
	mysqli_query($connect,"INSERT INTO contact (Contact_name, Contact_email, Contact_phone, Contact_message) 
		         VALUES('$cname','$cmail','$cphone','$cmessage')");
}

?>