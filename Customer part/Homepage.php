<?php
session_start();
?>
<?php include("connection.php"); ?>
<html>
<head>
<title>Homepage</title>
<link rel="stylesheet" href="css/Homepage.css">
<link rel="stylesheet" href="css/Basic.css">
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

<!-- Slide show part -->
<div id="container">
    <img src="image/Background1.jpg">
    <img src="image/Background2.jpg">
    <img src="image/Background3.jpg">
    <img src="image/Background4.jpg">
	
	<div class="middletext">
	<h1>Bakery shop</h1><br>
	<h4>A better place to choose your like.</h4><br>
	<a class="shopbutton" href="Category.php">SHOP NOW</a><br>
	</div>
</div>

<!-- Category part -->
<div id="categorypart">
<div class="categorypart bar">
<h2>Category</h2>
</div>
<div class="categorypart row">
	<div class="categorypart column" style="background-color:pink;">
		<a href="Category.php?comein&code=16"  target="_blank"><img src="image/category_cake.jpg" ></img></a>
		<span>Cake</span>
	</div>
	<div class="categorypart column" style="background-color:white;">
		<a href="Category.php?comein&code=17" target="_blank"><img src="image/category_bread.jpg"></img></a>
		<span>Bread</span>
	</div>
		<div class="categorypart column" style="background-color:pink;">
		<a href="Category.php?comein&code=18" target="_blank"><img src="image/category_tart.jpg"></img></a>
		<span>Tart</span>
	</div>
		<div class="categorypart column" style="background-color:white;">
		<a href="Category.php?comein&code=19" target="_blank"><img src="image/category_others.jpg"></img></a>
		<span>Others</span>
	</div>

</div>

<!-- About us part -->
<div id="Aboutuspart">
	<img src="image/about_us.jpg"></img>
		<div class="Aboutuspart middletext">
			<h1>About us</h1><br>
			<p>Synonymous with freshly baked goods.</p><br>
			<p>It is our everyday goal to produce foods that will not only nourish your body but also delight your senses, leaving you a wonderful memory.</p><br>
			<a class="readmore" href="About.php">Read More</a>
			
		</div>
</div>

<!-- Service part -->
<div id="servicepart">
	<div class="servicepart middletext">
	<h2>Our service</h2>
	<a class="servicelogo"><span class="material-icons">shop_2</span>Shop</a>
	<a class="servicelogo"><span class="material-icons">shopping_cart</span>Purchase</a>
	<a class="servicelogo"><span class="material-icons">local_shipping</span>Shipping</a>
	</div>
</div>

<!-- Our target part -->
<div id="Ourtargetpart">
	<img src="image/target.jpg"></img>
		<div class="Ourtargetpart middletext">
			<h1>Our beliefs:</h1><br>
			<p>-Produce safe and quality products with no added preservatives, pork, lard and/or alcohol</p><br>
			<p>-Support local farmers and various purveyors in producing exceptional ingredients</p><br>
			<p>-Honesty, passion and care in everything we do</p><br>
			<a class="readmore" href="Service.php">Read More</a>
		</div>
</div>

<!-- Contact part -->
<div id="contactpart">
	<div class="contactpart middletext">
	<h2>Contact us</h2>
	<div class="contact-box">
		<input type="text" class="field" placeholder="Your Name">
		<input type="text" class="field" placeholder="Your Email">
		<input type="text" class="field" placeholder="Phone">
		<textarea placeholder="Message" class="field"></textarea>
		<button class="btn"> <a href = "#"> Send </a> </button>
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

</body>
</html>