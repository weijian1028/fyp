<?php
session_start();
?>
<?php include("connection.php"); ?>
<html>
<head>
<title>About us</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/About.css">
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
<img src="image/about_background_1.jpg"></img>
</div>


<!-- About part -->
<div id="aboutpart">
	<div class="aboutpart middletext">
	<h2><span style="color:#D6C874;">About us</span></h2>
	<a class="servicelogo"><span class="material-icons">flight_takeoff</span>Shipping</a>
	<a class="servicelogo"><span class="material-icons">groups</span>Team</a>
	<a class="servicelogo"><span class="material-icons">chat</span>24 Hours Online</a>
	</div>
</div>
<div id="abouttext">
<p> Bakery Shop – a bakery that extends a warmth feeling that comes from the skilled hands of bread artisans. </p>
<p>When most of the businesses today are in pursuit of rapid production, we chose the unconventional approach to “slow down the pace” to ensure that fresh and high quality products being produced. 
Bakery Shop always emphasizes on never compromising on techniques and steps, differentiating ourselves through the textures and ingredients of our bakes. </p>
<p>We will strive to ensure that our products and services maintain the high quality that is expected from our valued customers whilst remaining creative, innovative and responsive to their needs. Interested parties can get in touch with us in several ways:</p>
<p>CONTACT NO: 016 1234567</p>
<p>EMAIL: bakery@hotmail.com</p>
</div>


</body>
</html>