<?php
session_start();

?>
<?php include("connection.php"); ?>
<html>
<head>
<title>Cart</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Invoice.css">
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
	  <a href="History.php">Order History</a>
      <a href="Logout.php">Log out</a>
    </div>
  </div> 
	</div>
</div>

<?php
	if(isset($_GET["view"]))
	{
	$pid = $_GET["code"];   
    
	$result_cart = mysqli_query($connect, "select * from cart_details where Cart_ID = '$pid'");
    $result_inv = mysqli_query($connect, "select * from invoice where Cart_ID = '$pid'");

	}
?>
		<h1 class="title2">Receipt Detail</h1>
		<div class="invoice-box">
		<form name="updatefrm" method="post" action="">
        <table border="0" width="650px" style="border-collapse: collapse;">
			<h2 class="title">RECEIPT </h2>
            <p>Bakery Shop</p>
            <p>666,Jalan Gembira</p>
            <p>Taman Sungai,</p>
            <p>81000, Kulai, Johor.</p>
            <hr>
            <?php  
            while($row_inv = mysqli_fetch_assoc($result_inv))
				{
                    $ship_id = $row_inv["shipping_id"];
				    $result_shp = mysqli_query($connect,'SELECT * from shipping where shipping_id = "'.$ship_id.'"');
			    	$row_shp = mysqli_fetch_assoc($result_shp);
            ?>
            <p align="right">Invoice ID :<?php echo $row_inv["Invoice_ID"]; ?> </p>
            <p align="right">Invoice Date :<?php echo $row_inv["Invoice_date"]; ?> </p>
            <?php
                }
            ?>
            <p>Bill to : <?php echo $row_shp["shipping_name"]; ?></p>
            <p>Shipping ID: <?php echo $ship_id ?></p>
            <p>Address: <?php echo $row_shp["shipping_address"]; ?></p>
            
			<tr class="content">
				<th>Product ID</th>
                <th>Product Name</th>
				<th>Quantity</th>
                <th>Price</th>
				<th>Total price</th>
			</tr>
            <?php
            $total = 0;
            $total_quantity=0;
            $total_price=0;

            while($row_cart = mysqli_fetch_assoc($result_cart))
				{
                    $prod_id = $row_cart["Product_ID"];
				    $result_prod = mysqli_query($connect,'SELECT * from product where Product_ID = "'.$prod_id.'"');
			    	$row_prod = mysqli_fetch_assoc($result_prod);
                    $total += $row_cart["Product_total_price"];
                    ?>
            <tr class="ev">
					<td><?php echo $row_cart["Product_ID"]; ?></td>
                    <td><?php echo $row_prod["Product_name"]; ?></td>
					<td><?php echo $row_cart["Product_qty"]; ?></td>
                    <td><?php echo $row_cart["Product_price"]; ?></td>
					<td><?php echo $row_cart["Product_total_price"]; ?></td>
				</tr>
                <?php
                    $total_quantity += $row_cart["Product_qty"];
                    $total_price += ($row_cart["Product_price"]*$row_cart["Product_qty"]);
                }
                ?>
                <tr class="content">
                <td colspan="2" align="right">Total:</td>
                <td align="left" colspan="2"><?php echo $total_quantity; ?></td>
                <td align="center" ><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
                </tr>
        
        </table>
		


        <?php
            $tax = 0;
            $total = 0;
            $tax = $total_price * 0.03;
            $total = $total_price + $tax; 
        
        ?>
		<div class="space">
        <br>
        <p>Subtotal:<span id="show"><?php echo "RM ".number_format($total_price, 2); ?></span></p>
        <p>Shipping Fee (3%):<span id="show"><?php echo "RM ".number_format($tax, 2); ?></p>
        <p>Total:<span id="show"><?php echo "RM ".number_format($total, 2); ?></span></p>
        <br>
        <hr>
        <br>
        <p style="font-size:30px;">Total:<span id="show"><?php echo "RM ".number_format($total, 2); ?></span></p>
		</div>
		</div>
        <br><br>
        <a class="inf"href="History.php">Back</a>
 
        

        </form>


</body>
</html>

