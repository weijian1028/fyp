<?php 
	include("connection.php"); 
	session_start();
?>
<?php

$productID = $productname =$productprice = $productstock = "";
$productID_err = $productname_err =$productprice_err = $productstock_err = "";

if (isset($_POST["savebtn"])) 	
{
	// Check if productID is empty
	if(empty(trim($_POST["prod_id"])))
	{
        $productID_err = "Please enter Product ID.";
	}
	else
	{
		//Check if Product Id is already taken
		$pid = $_POST["prod_id"];  
        $result = mysqli_query($connect,"SELECT * from product where Product_ID = '$pid'" );
		$count=mysqli_num_rows($result);
		if ($count != 0)
		{
			$productID_err = "The Product ID is already taken";
		}
		else
		{
			$productID = trim($_POST["prod_id"]);
		}

    }

    
    // Check if productname is empty
    if(empty(trim($_POST["prod_name"]))){
        $productname_err = "Please enter your Product Name.";
	} else
	{
		//Check if Product Name is already taken
        $pname = $_POST["prod_name"];  
        $result = mysqli_query($connect,"SELECT * from product where Product_name = '$pname'" );
		$count=mysqli_num_rows($result);
		if ($count != 0)
		{
			$productname_err = "The Product name is already taken";
		}
		else
		{
			$productname = trim($_POST["prod_name"]);
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

	$image = $_FILES['image']['name'];
	$target = "images/".basename($image);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		$msg = "Image uploaded successfully";
	}else{
		$msg = "Failed to upload image";
	}
	
	$pcategory = $_POST["prod_category"];  
	$pdescription = $_POST["prod_description"];	

	//If no error then insert the data
	if(empty($productID_err) && empty($productname_err) && empty($productprice_err) &&empty($productstock_err))
	{
		mysqli_query($connect,"INSERT INTO product (Product_ID,Product_name,Product_price,Product_stock,Product_description,Category_ID,Product_image) 
		             VALUES('$productID','$productname','$productprice','$productstock','$pdescription','$pcategory','$image')");
	?>
		<script type="text/javascript">
			alert(" Record saved!");
		</script>
	<?php
	}
}
?>

<html>
<head>
<meta charset="UTF-8">
    <title>Add new product</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="css/Admin_add_product.css">
	<link rel="stylesheet" href="css/basic.css">
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
	<div class="wrapper">
		<h1>Add New Product Detail</h1>

		<form name="addnewfrm" method="post" action="" enctype="multipart/form-data">

			<div class="form-group <?php echo (!empty($productID_err)) ? 'has-error' : ''; ?>">
                <label>Product ID :</label>
                <input type="text" name="prod_id" class="form-control" value="<?php echo $productID; ?>">
                <span class="help-block"><?php echo $productID_err; ?></span>
            </div>    
			<div class="form-group <?php echo (!empty($productname_err)) ? 'has-error' : ''; ?>">
                <label>Product Name :</label>
                <input type="text" name="prod_name" class="form-control" value="<?php echo $productname; ?>">
                <span class="help-block"><?php echo $productname_err; ?></span>
            </div>  
			<p><label>Category :</label><select name="prod_category">
						<?php 
						$cate_result = mysqli_query($connect, "select * from category where Category_isDelete = 0");
						while($row = mysqli_fetch_assoc($cate_result))
						{
						?>	
						<option value="<?php echo $row["Category_ID"];?>"><?php echo $row["Category_name"];?></option>
						<?php
						}
						?>
			             </select>
			<div class="form-group <?php echo (!empty($productprice_err)) ? 'has-error' : ''; ?>">
                <label>Price :</label>
                <input type="text" name="prod_price" class="form-control" value="<?php echo $productprice; ?>">
                <span class="help-block"><?php echo $productprice_err; ?></span>
            </div>  
			<div class="form-group <?php echo (!empty($productstock_err)) ? 'has-error' : ''; ?>">
                <label>Stock :</label>
                <input type="text" name="prod_stock" class="form-control" value="<?php echo $productstock; ?>">
                <span class="help-block"><?php echo $productstock_err; ?></span>
            </div>  
			<p><label>Description:</label><input type="text" name="prod_description">
			<div class="upload-btn-wrapper">
				<label>Upload Image:</label>
				<button class="btn">Upload a file</button>
  	  			<input type="file" name="image">
  			</div>
		   <br><br>
			
			<p><input type="submit" name="savebtn" value="Save Product">

		</form>

		<input type="button" value="View" onclick="location='admin_view_product_list.php'">
		
</div>


</body>
</html>


