<?php 
	include("connection.php"); 
	session_start();
?>

<?php
	if(isset($_GET["edit"]))
	{
	$pid = $_GET["code"];

	$result = mysqli_query($connect, "select * from product where Product_ID = '$pid'");
	$row = mysqli_fetch_assoc($result);
	}
?>


<?php

$productID = $productname =$productprice = $productstock = "";
$productID_err = $productname_err =$productprice_err = $productstock_err = "";

if (isset($_POST["savebtn"])) 	
{
    // Check if productname is empty
    if(empty(trim($_POST["prod_name"]))){
        $productname_err = "Please enter your Product Name.";
	} else
	{
		//Check if Product Name is already taken
        $pname = $_POST["prod_name"];  
        $result = mysqli_query($connect,"SELECT * from product where Product_name = '$pname'" );
		$count=mysqli_num_rows($result);
		if ($count <= 1)
		{
			$productname = trim($_POST["prod_name"]);
		}
		else
		{
			$productname_err = "The Product name is already taken";
		}
	}
	
	// Check if productprice is empty
    if(empty(trim($_POST["prod_price"]))){
        $productprice_err = "Please enter your Product Price.";
	} 
	else if(trim($_POST["prod_price"]) <= 0)
	{
		//Check the price is bigger than 0
        $productprice_err = "The price cannot less than or equal to 0.";
	}
	else
	{
		$productprice = trim($_POST["prod_price"]);
	}
	
	// Check if productstock is empty
    if(empty(trim($_POST["prod_stock"]))){
        $productstock_err = "Please enter your Product Stock.";
	} 
	else if(trim($_POST["prod_stock"]) <= 0)
	{
		//Check the stock is bigger than 0
        $productstock_err = "The stock cannot less than or equal to 0.";
	}
	else
	{
		$productstock = trim($_POST["prod_stock"]);
	}
	
	$pcategory = $_POST["prod_category"];  
	$pdescription = $_POST["prod_description"];	

	//If no error then insert the data
	if(empty($productID_err) && empty($productname_err) && empty($productprice_err) &&empty($productstock_err))
	{
		mysqli_query($connect,"update product set Product_name = '$productname', 
		Product_price = '$productprice', Category_ID = '$pcategory', Product_stock = '$productstock', 
		Product_description = '$pdescription' where Product_ID = '$pid'");

		echo '<script type="text/javascript"> 
        alert("Record updated!")
        location.href="admin_view_product_list.php"
        </script>';
	}
}
?>


<html>
<head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="css/Admin_edit_product.css">
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



		<div class="wrapper">
		<div class="background_img">
			<img src="https://cdn.wallpapersafari.com/39/27/ohLZNV.jpg">
		</div>
		<h1>Update Product Detail</h1>

		<form name="updatefrm" method="post" action="">
			<?php
				echo "<div id='img_div'>";
      			echo "<img src='images/".$row['Product_image']."' >";
	  			echo "</div>";
			?>
			<label>Product ID:</label><input type="text" name="prod_id"  value="<?php echo $row["Product_ID"]; ?>"  disabled>
			<div class="form-group <?php echo (!empty($productname_err)) ? 'has-error' : ''; ?>">
                <label>Product Name :</label>
                <input type="text" name="prod_name" class="form-control" value="<?php echo $row["Product_name"]; ?>">
                <span class="help-block"><?php echo $productname_err; ?></span>
            </div>
			
			<label>Category:</label><select name="prod_category">
								<?php 
						$cate_result = mysqli_query($connect, "select * from category where Category_isDelete = 0");
						while($cate_row = mysqli_fetch_assoc($cate_result))
						{
						?>	
						<option value="<?php echo $cate_row["Category_ID"];?>"><?php echo $cate_row["Category_name"];?></option>
						<?php
						}
						?>
			                  </select>
			<div class="form-group <?php echo (!empty($productprice_err)) ? 'has-error' : ''; ?>">
                <label>Price :</label>
                <input type="text" name="prod_price" class="form-control" value="<?php echo $row["Product_price"]; ?>">
                <span class="help-block"><?php echo $productprice_err; ?></span>
            </div> 
			<div class="form-group <?php echo (!empty($productstock_err)) ? 'has-error' : ''; ?>">
                <label>Stock :</label>
                <input type="text" name="prod_stock" class="form-control" value="<?php echo $row["Product_stock"]; ?>">
                <span class="help-block"><?php echo $productstock_err; ?></span>
            </div> 
			<label>Description:</label><input type="text" name="prod_description"  value="<?php echo $row["Product_description"]; ?>">
					
			<p><input type="submit" name="savebtn" value="Update Product"><p>
		</form>
		<p><input type="button" value="Cancel" onclick="location='admin_view_product_list.php'"><p>
	</div>

</body>
</html>


