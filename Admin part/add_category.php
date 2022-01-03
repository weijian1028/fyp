<?php 
	include("connection.php"); 
	session_start();
?>

<html>
<head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/Admin_add_category.css">
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
		
	<div id="designall">
		<h1>Category</h1>
		<form name="addnewfrm" method="post" action="">
			<p>Insert the category name:<input type="text" name="cate_name">
			<p><input type="submit" name="savebtn" value="Add Category">
		</form>
		
		

		<table border="0px" width="95%" style="border-collapse: collapse;" class="center">
			<tr>
				<th>Category name</th>
				<th colspan="3">Action</th>
			</tr>

			<?php
			
			$result = mysqli_query($connect, "select * from category where Category_isDelete = 0");	
	         while($row = mysqli_fetch_assoc($result))
				{
				
					

				echo "<tr>
					<td> ".$row["Category_name"]."</td>
					<td><button class='editbtn' onclick=update(".$row["Category_ID"].")><span class='material-icons'>edit</span></button></td>
					<td><a href='add_category.php?del&code=".$row["Category_ID"]." onclick='return confirmation();'><button class='delbtn'><span class='material-icons'>delete</span></button></a></td>
				</tr>";
			
				
				}		
			
			?>

			
			
			
		</table>
    </div>

</body>
</html>
<script>
	function update(id){
		var newcategory = prompt("Please enter the new category name.");
		location.href="add_category.php?edit=&code="+id+"&category="+newcategory;
	}



</script>
<?php


if (isset($_POST["savebtn"])) 	
{
	$categoryname = $_POST["cate_name"];
	
	if($categoryname == "")
	{
	?>
		<script type = "text/javascript">
			alert("The category name cannot be null.");
		</script>
	<?php
	}
	else
	{
	
$result = mysqli_query($connect,"SELECT * from category where Category_name = '$categoryname'" );
$count=mysqli_num_rows($result);
	if ($count != 0)
	{
	?>
		<script type = "text/javascript">
			alert("The category name is already in use. Please change.");
		</script>
	<?php
	}
	else
	{
		mysqli_query($connect,"INSERT INTO category (Category_name) 
		             VALUES('$categoryname')");
		echo '<script type="text/javascript"> 
        alert("Successful add!")
        location.href="add_category.php"
        </script>';

	}
}
}
?>


<?php
//remove category from category list
if (isset($_GET["del"])) 
{
	$code = $_GET["code"];
	//update category table and set category_isDelete to 1
	mysqli_query($connect, "update category set Category_isDelete=1 where Category_ID ='$code'");
	echo '<script type="text/javascript"> 
        alert("Successful delete!")
        location.href="add_category.php"
        </script>';
}

?>


<?php
//edit category name from category list
if (isset($_GET["edit"])) 
{
	$code = $_GET["code"];
	$newcategory = $_GET["category"];
   	if(mysqli_query($connect, "UPDATE category set Category_name = '$newcategory' where Category_ID =$code")){
		echo '<script type="text/javascript"> 
        alert("Record updated!")
        location.href="add_category.php"
        </script>';
	}else{
		echo $connect->error;
	}
	
}