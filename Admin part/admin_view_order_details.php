<?php 
	include("connection.php"); 
	session_start();
?>

<?php
	if(isset($_GET["view"]))
	{
	$pid = $_GET["code"];
    $invid = $_GET["inv"];
    
    $result_inv = mysqli_query($connect, "SELECT * FROM invoice WHERE Invoice_ID='$invid';");
    $row_inv = mysqli_fetch_assoc($result_inv);
	$result = mysqli_query($connect, "select * from cart_details where Cart_ID = '$pid'");
	}
?>

<?php
if (isset($_GET["done"])) 
{
	$code = $_GET["code"];
	//update invoice table and set status to 1
	mysqli_query($connect, "update invoice set Invoice_status=1 where Invoice_ID ='$code'");
	echo '<script type="text/javascript"> 
        alert("Successful Send!")
        location.href="admin_view_order.php"
        </script>';
}

?>



<html>
<head>
<title>View order details</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="css/Admin_view_order_details.css">
<script src="script/sidebar.js"></script>
</head>


<body>
<!-- Header -->
<div id="header">
<a class="title"><span class="animationstyle">Bakery Shop ADMIN</span></a>
<a class="welcome">Hi, welcome back 
<?php
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    ?><b><?php echo htmlspecialchars($_SESSION["adminname"]); ?></b>
	<?php
	}
	?>	
</a>
<a href="Logout.php"><button class="btn-1">Logout</button></a>
</div>


<!-- Sidebar -->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="admin_view_customer.php" class="fa fa-search" aria-hidden="true"> Customer List</a>
  <a href="admin_view_order.php" class="fa fa-search" aria-hidden="true"> View Orders</a>
  <a href="admin_add_product_list.php" class="fa fa-plus-square" aria-hidden="true"> Add Product</a>
  <a href="admin_view_product_list.php" class="fa fa-search" aria-hidden="true"> View Product</a>
  <a href="add_category.php" class="fa fa-plus-square" aria-hidden="true"> Add Category</a>
  <a href="admin_register.php" class="fa fa-plus-square" aria-hidden="true"> Admin register</a>
  <a href="admin_view_report.php" class="fa fa-search" aria-hidden="true"> View report</a>
  <a href="admin_view_feedback.php" class="fa fa-phone" aria-hidden="true">  View Feedback</a>
</div>
<div id="sidemenu">
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>
<a href="admin_homepage.php" class="btnhome">
<span class="material-icons">home</span>Home</a>
</div>


<!-- List -->
<div id="designall">
		<h1>Order details</h1>
		
		<table border="0" width="750px" style="border-collapse: collapse;">
			<tr>
                <th>Image</th>
				<th>Product ID</th>
                <th>Product Name</th>
				<th>Product Price</th>
				<th>Product Quantity</th>
			</tr>


		
			<?php		
			
				while($row = mysqli_fetch_assoc($result))
				{
				$prod_id = $row["Product_ID"];
				$result_prod = mysqli_query($connect,'SELECT * from product where Product_ID = "'.$prod_id.'"');
				$prod_name = mysqli_fetch_assoc($result_prod);
				?>			

				<tr>
                <td>
                <?php
	                echo "<div id='img_div'>";
                    echo "<img src='images/".$prod_name['Product_image']."' width=100px; height=100px; >";
	                echo "</div>";
                ?>
                </td>
					<td><?php echo $row["Product_ID"]; ?></td>
                    <td><?php echo $prod_name["Product_name"]; ?></td>
					<td><?php echo $row["Product_price"]; ?></td>
					<td><?php echo $row["Product_qty"]; ?></td>
				</tr>
				<?php
				
				}		
			
			?>

		</table>
        <a href="admin_view_order.php" class="editbtn"><span class="material-icons">reply</span></a>
        <a href="admin_view_order_details.php?done&code=<?php echo $row_inv["Invoice_ID"]; ?>" class="editbtn"><span class="material-icons">save</span></a>
        <?php 
		    $result_sp = mysqli_query($connect,'SELECT * from shipping where shipping_id = "'.$row_inv["shipping_id"].'"');
			$shp = mysqli_fetch_assoc($result_sp);
        ?>
			<div class="ship">
			<p>Shipping ID: <?php echo $row_inv["shipping_id"] ?></p>
			<p>Shipping Name: <?php echo $shp["shipping_name"] ?></p>
			<p>Shipping Email: <?php echo $shp["shipping_email"] ?></p>
			<p>Shipping Address: <?php echo $shp["shipping_address"] ?></p>
			</div>

</div>
</body>
</html>



