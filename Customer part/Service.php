<?php
session_start();
?>
<?php include("connection.php"); ?>
<html>
<head>
<title>Service</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Service.css">
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
<img src="image/service_background_1.jpg"></img>
</div>

<!-- Service part -->
<div id="servicepart">
	<div class="servicepart middletext">
	<h2><span style="color:#D6C874;">Our service</span></h2>
	<a class="servicelogo"><span class="material-icons">shop_2</span>Shop</a>
	<a class="servicelogo"><span class="material-icons">shopping_cart</span>Purchase</a>
	<a class="servicelogo"><span class="material-icons">local_shipping</span>Shipping</a>
	</div>
</div>
<div id="servicetext">
<p>An array of cakes from classic to innovative flavours, handmade egg tart, many types of bread, and a plethora of macarons using only high quality ingredients await you daily at Bakery Shop</p>
<p>We minimise our carbon footprint by using high quality, local ingredients whenever possible.</p>
</div>


<!-- Target part -->
<div id="targetpart">
<img src="image/service_background_2.jpg"></img>
	<div class="targetpart middletext">
	<h1>Beliefs:</h1><br>
	<p>-Produce safe and quality products with no added preservatives, pork, lard and/or alcohol.</p>
	<p>-Support local farmers and various purveyors in producing exceptional ingredients</p>
	<p>-Honesty, passion and care in everything we do</p>
	</div>
</div>

</body>
</html>