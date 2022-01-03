<?php 
	include("connection.php"); 
	session_start();
?>

<?php
		$results_per_page = 20;
				
					
				if (isset($_GET["page"])) 
				{ 
					$page  = $_GET["page"]; 
				} 
				else 
				{ 
					$page=1; 
				};
				$start_from = ($page-1) * $results_per_page;

		
	if(isset($_POST['search']))
	{
		//search product id
		if(!empty($_POST['idToSearch']))
		{
			$idToSearch = $_POST['idToSearch'];
		}
		else
		{
			$idToSearch = "";
		}
		
		//search product name
		if(!empty($_POST['nameToSearch']))
		{
			$nameToSearch = $_POST['nameToSearch'];
		}
		else
		{
			$nameToSearch = "";
		}
		
		//search product category
		if(!empty($_POST['categoryToSearch']))
		{
			$categoryToSearch = $_POST['categoryToSearch'];;
		}
		else
		{
			$categoryToSearch = "";
		}
		
		//search product status
		if(!empty($_POST['statusToSearch']))
		{
			$statusToSearch = $_POST['statusToSearch'];;
		}
		else
		{
			$statusToSearch = 0;
		}
		
		$search_result = mysqli_query($connect,"SELECT * FROM product WHERE 
		Product_ID LIKE '%".$idToSearch."%'
		and Product_name LIKE '%".$nameToSearch."%'
		and Category_ID LIKE '%".$categoryToSearch."%'
		and Product_isDelete LIKE '%".$statusToSearch."%'
		LIMIT $start_from, ".$results_per_page);
	}
	else
	{
		$search_result = mysqli_query($connect,"SELECT * from product where Product_isDelete = 0 ORDER BY Product_ID ASC LIMIT $start_from, ".$results_per_page);
	}
	
?>

<html>
<head>
<title>View product</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="css/Admin_view_product.css">
<script src="script/sidebar.js"></script>
</head>


<script type="text/javascript">

function confirmation()
{
	choice = confirm("Do you want to delete?");
    return choice;
}

</script>


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
		<h1>List of Products</h1>
		<form action="admin_view_product_list.php" method="post">
		<input type="text" name="idToSearch" placeholder="Product ID">
		<input type="text" name="nameToSearch" placeholder="Product Name">
		<p>Category :<select name="categoryToSearch">
					<option value="">--Select category--</option>
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
		<p>Status :<select name="statusToSearch">
				   <option value="0">Selling</option>
				   <option value="1">Deleted</option>
		<input type="submit" name="search" value="Filter">
		
		<table border="0" width="1050px" style="border-collapse: collapse;">
			<tr>
				<th>Product ID</th>
				<th>Product Name</th>
				<th>Category</th>
				<th>Product Price</th>
				<th>Product Stock</th>
				<th>Product Description</th>
				<th colspan="3">Action</th>
			</tr>


		
			<?php		
			
				while($row = mysqli_fetch_assoc($search_result))
				{
				$cate_id = $row["Category_ID"];
				$result_cate = mysqli_query($connect,"SELECT * from category where Category_ID = ".$cate_id);
				$cate_name = mysqli_fetch_assoc($result_cate);
				?>			

				<tr>
					<td><?php echo $row["Product_ID"]; ?></td>
					<td><?php echo $row["Product_name"]; ?></td>
					<td><?php echo $cate_name["Category_name"]; ?></td>
					<td><?php echo $row["Product_price"]; ?></td>
					<td><?php echo $row["Product_stock"]; ?></td>
					<td><?php echo $row["Product_description"]; ?></td>
					<td><a href="admin_edit_product_list.php?edit&code=<?php echo $row["Product_ID"]; ?>" class="editbtn"><span class="material-icons">edit</span></a></td>
					<td><a href="admin_view_product_list.php?del&code=<?php echo $row["Product_ID"]; ?>"class="delbtn" onclick="return confirmation();"><span class="material-icons">delete</span></a></td>
				</tr>
				<?php
				
				}		
			
			?>

		</table>

	</form>
</div>
</body>
</html>

<?php
//remove product from product list
if (isset($_GET["del"])) 
{
	$code = $_GET["code"];
	//update product table and set product_isDelete to 1
	mysqli_query($connect, "update product set Product_isDelete=1 where Product_ID ='$code'");
	echo '<script type="text/javascript"> 
        alert("Successful delete!")
        location.href="admin_view_product_list.php"
        </script>';
}

?>


<?php 
$sql_total = "SELECT COUNT(Product_ID) AS total FROM product where Product_isDelete = 0";
$result = $connect->query($sql_total);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
            echo "<a href='admin_view_product_list.php?page=".$i."'";
            if ($i==$page)  echo " class='curPage'";
            echo ">".$i."</a> "; 
}; 
?>