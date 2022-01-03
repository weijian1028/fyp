<?php
session_start();
include("connection.php");
?>

<?php
	if(empty($_SESSION["id"])){  
		header("location: Login.php");
	}
	
?>

<html>
<head>
<title>Cart</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Cart.css">
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


<a id="btnEmpty" class="inff" href="Cart.php?empty">Delete All<span class="material-icons">delete_forever</span></a>

<?php
	if(isset($_GET["cart"]))
	{
		$pid = $_GET["pid"];
		$result = mysqli_query($connect, "select * from product where Product_ID = '$pid'");
		$productByCode=mysqli_fetch_array($result);


		if(empty($_POST["quantity"]))
		{
			echo '<script type="text/javascript"> 
       		 alert("Quantity cannot be null!")
       		 location.href="Category.php"
       		 </script>';
		}
		else if($_POST["quantity"]>$productByCode["Product_stock"])
		{
			echo '<script type="text/javascript"> 
       		 alert("Out of stock!")
       		 location.href="Category.php"
       		 </script>';
		}
		else
		{
			$pid = $_GET["pid"];
			$result = mysqli_query($connect, "select * from product where Product_ID = '$pid'");

			while($productByCode=mysqli_fetch_array($result))
			{
				
				$itemArray = array($productByCode["Product_ID"]=>array('Product_name'=>$productByCode["Product_name"], 'Product_ID'=>$productByCode["Product_ID"], 'quantity'=>$_POST["quantity"], 'Product_price'=>$productByCode["Product_price"], 'Product_image'=>$productByCode["Product_image"]));
				if(!empty($_SESSION["cart_item"])) 
				{
					
					// searches for specific value code
					 if(in_array($productByCode[0],array_keys($_SESSION["cart_item"]))) 
					 {
				
					 	foreach($_SESSION["cart_item"] as $k => $v) 
					 	{
					 		if($productByCode[0] == $k) 
					 		{
					 			if(empty($_SESSION["cart_item"][$k]["quantity"])) 
					 			{
					 				$_SESSION["cart_item"][$k]["quantity"] = 0;
					 			}
					 			$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
					 		}
					 	}
					 }
					 else
					 {
						
						//The array_merge() function merges one or more arrays into one array.
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
					 }
				}
				else 
				{
					$_SESSION["cart_item"] = $itemArray;
					
				}
			}
			echo '<script type="text/javascript"> 
       		 alert("Successful Add!")
       		 location.href="Category.php"
       		 </script>';
		}
	}
?>



<!-- Cart ---->
<div id="shopping-cart">
<div class="txt-heading" id="hding">Shopping Cart</div>
<form method="post" action="Cart.php?save_record">

<?php
if(isset($_SESSION["cart_item"])){
$total_quantity = 0;
$total_price = 0;
?>


<table class="tbl-cart" cellpadding="0" cellspacing="0" >
<tbody>
<tr class="content">
<th style="text-align:left; ">Image</th>
<th style="text-align:left; "width="35%">Name</th>
<th style="text-align:left; ">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right; " width="10%">Price</th>
<th style="text-align:center; " width="15%">Remove</th>
</tr>

<?php
	foreach ($_SESSION["cart_item"] as $item){
	$item_price = $item["quantity"]*$item["Product_price"];
?>

<tr class="ev">
<td>
<?php
	echo "<div id='img_div'>";
    echo "<img src='../Admin part/images/".$item['Product_image']."' width=100px; height=100px; >";
	echo "</div>";
?>
</td>
<td><?php echo $item["Product_name"]; ?></td>
<td><?php echo $item["Product_ID"]; ?></td>
<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
<td style="text-align:right;"><?php echo "$ ".$item["Product_price"]; ?></td>
<td style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
<td style="text-align:center;"><a href="Cart.php?remove&pid=<?php echo $item["Product_ID"]; ?>" class="btnRemoveAction"><span class="material-icons">delete</span></a></td>
</tr>

<?php
$total_quantity += $item["quantity"];
$total_price += ($item["Product_price"]*$item["quantity"]);
}
?>
<tr class="content">
<td colspan="3" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>
<input type="submit" value="Save Cart" class="btnAddAction" />
<a class="inf" href="Payment.php">Payment</a>
</form>


<?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php
}
?>
</div>


<!-- remove item -->
<?php
if(isset($_GET["remove"]))
{
	if(!empty($_SESSION["cart_item"]))
	{
		foreach($_SESSION["cart_item"] as $k => $v) {
		if($_GET["pid"] == $k)
		unset($_SESSION["cart_item"][$k]);
		if(empty($_SESSION["cart_item"]))
		unset($_SESSION["cart_item"]);
		}
	}
	echo '<script type="text/javascript"> 
        alert("Successful delete!")
        location.href="Cart.php"
        </script>';
}
?>

<!-- Clear cart -->
<?php
if(isset($_GET["empty"]))
{
	unset($_SESSION["cart_item"]);
	echo '<script type="text/javascript"> 
        alert("Successful delete!")
        location.href="Cart.php"
        </script>';
}
?>

<!-- Save record -->
<?php
if(isset($_GET["save_record"]))
{
	if(empty($_SESSION["id"]))
	{
		echo '<script type="text/javascript"> 
        alert("You must login and make payment!")
        location.href="Cart.php"
        </script>';
	}
	else
	{

	$username = $_SESSION["id"];
	// Save new order
	mysqli_query($connect, 'insert into cart_id(Member_ID,Cart_total_qty,Cart_total_price)
	values('.$username.','.$total_quantity.','.$total_price.')');
	$ordersid = mysqli_insert_id($connect);

	// Save order details for new order
	foreach ($_SESSION["cart_item"] as $item)
	{
		// $product_stock =0;
		$productid = $item["Product_ID"];
		$item_price = $item["quantity"]*$item["Product_price"];
		// $result_pd = mysqli_query($connect, 'Select * from product where Product_ID = "'.$productid.'"');
		// $ps = mysqli_fetch_array($result_pd);

		//$product_stock = $ps["Product_stock"] - $item["quantity"];

		mysqli_query($connect, 'INSERT INTO cart_details(`Product_qty`, `Cart_ID`, `Product_price`, `Product_ID`,`Product_total_price`)
		values('.$item["quantity"].', '.$ordersid.','.$item["Product_price"].', "'.$productid.'",'.$item_price.')');

		//mysqli_query($connect, "UPDATE product SET Product_stock='$product_stock' WHERE Product_ID ='$productid'");

	}
	?>
		<script type="text/javascript">
			alert("Record saved! Your Cart ID is <?php echo $ordersid ?>");
		</script>

	<?php


	}
}
?>


</body>
</html>