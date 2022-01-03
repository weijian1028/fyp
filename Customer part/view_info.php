<?php
session_start();
?>
<?php include("connection.php"); ?>


<html>
<head>
<title>Service</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Info.css">
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
      <a href="Logout.php">Log out</a>
    </div>
  </div> 
	</div>
</div>


<?php
	if(isset($_GET["info"]))
	{
	$pid = $_GET["code"];

	$result = mysqli_query($connect, "select * from product where Product_ID = '$pid'");
	$row = mysqli_fetch_assoc($result);
	}
?>

		<h1 class="title1">Product Detail</h1>
		
		<div id="card">
		<a href="Category.php" class="previous"><< Go back</a>
		<form name="updatefrm" method="post" action="Cart.php?cart&pid=<?php echo $row["Product_ID"]; ?>">
			<?php
				echo "<div class='ima' id='img_div'>";
      			echo "<img src='../Admin part/images/".$row['Product_image']."'width='350px';height='300px' >";
	  			echo "</div>";
            ?>
            <div>
			    <p>ID:<?php echo $row["Product_ID"]; ?><p>
                <p>Name :<?php echo $row["Product_name"]; ?></p>
                <p>Price :RM <?php echo $row["Product_price"]; ?></p>
                <p>Stock :<?php echo $row["Product_stock"]; ?></p>
                <p>Description:<?php echo $row["Product_description"]; ?></p>
				<hr>
				<div class="ad">
				<input type="text" class="product-quantity" name="quantity" value="1" size="2" />
				<input class="cc" type="submit" value="Add to Cart" class="btnAddAction" />
				</div>
            </div>
		</form>
		</div>
		
		
	

</body>
</html>