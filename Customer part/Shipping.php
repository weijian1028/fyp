<?php
session_start();

?>
<?php include("connection.php"); ?>
<html>
<head>
<title>Cart</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Reload.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="script/sidebar.js"></script>

<script type="text/javascript">

function confirmation()
{
	choice = confirm("Do you want to delete?");
    return choice;
}

</script>

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
	if(isset($_GET["pay"]))
	{
	    $pid = $_GET["code"];   
	}
?>


<?php
    if(isset($_POST["ship"]))
    {
        $prd = $_POST["cartid"];
        $ship_name = $_POST["username"];
        $ship_email = $_POST["email"];
        $ship_address = $_POST["address"];
        
        mysqli_query($connect,"INSERT INTO shipping (shipping_name,shipping_email,shipping_address) 
		             VALUES('$ship_name','$ship_email','$ship_address')");
        $shpid = mysqli_insert_id($connect);

        echo '<script type="text/javascript"> 
        alert("Successful send!")
        location.href="Invoice.php?pay&code='.$prd.'&shp='.$shpid.'"
        </script>';
    }
   


?>

<form action="" method="post">
<h1 class="title">Payment</h1>
<div class="container">
        <div class="titi">
        <h3>Billing Address</h3>
        <label><i class="fa fa-user"></i> Cart ID</label>
        <input type="text"name="cartid" value="<?php echo $pid;?>">
        </div>
        <br>
        <label><i class="fa fa-user"></i> Full Name</label>
        <input type="text"name="username" placeholder="Enter your name">
        <label><i class="fa fa-envelope"></i> Email</label>
        <input type="text" name="email" placeholder="johncena@example.com">
        <label><i class="fa fa-address-card-o"></i> Address</label>
        <input type="text" name="address" placeholder="Jalan xxx">
</div>


        <input type="submit" name="ship" value="Confirm">
</form>
</body>
</html>

