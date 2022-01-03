<?php
session_start();
?>
<?php include("connection.php"); ?>
<?php
		$results_per_page = 100;
				
					
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
		
		
		$search_result = mysqli_query($connect,"SELECT * FROM product WHERE 
		Product_isDelete = 0 
		and Product_ID LIKE '%".$idToSearch."%'
		and Product_name LIKE '%".$nameToSearch."%'
		and Category_ID LIKE '%".$categoryToSearch."%'
		LIMIT $start_from, ".$results_per_page);
	}
	else
	{
		if(isset($_GET['comein']))
		{
			$comecategory = $_GET['code'];
			$search_result = mysqli_query($connect,"SELECT * FROM product WHERE 
			Product_isDelete = 0
		    and Category_ID LIKE '%".$comecategory."%'
		    LIMIT $start_from, ".$results_per_page);
		}
		else
		{
			$search_result = mysqli_query($connect,"SELECT * from product where Product_isDelete = 0 ORDER BY Product_ID ASC LIMIT $start_from, ".$results_per_page);
		}
		
	}
	
?>
<html>
<head>
<title>Category</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Category.css">
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



<nav class="product-filter">
	<h1>List of Products</h1>
		<div class="sort">
			<form action="" method="post" class="form-inline">
				<div class="collection-sort">
					<input type="text" name="idToSearch" placeholder="Product ID" >
				</div>
				<div class="collection-sort">
					<input type="text" name="nameToSearch" placeholder="Product Name">
				</div>
				<div class="collection-sort">
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
				</div>
						<br><br>
						<button type="submit" name="search" value="Filter">Search</button>
						
    		</form>
		</div>
</nav>

    <section class="products">

			<?php		

				while($row = mysqli_fetch_assoc($search_result))
				{
				?>			
          <div class="product-card">
          <form method="post" action="Cart.php?cart&pid=<?php echo $row["Product_ID"]; ?>">
          <?php
          echo "<div class='product-image'>";
      			echo "<img src='../Admin part/images/".$row['Product_image']."' >";
          echo "</div>";
          ?>
          <div class="product-info">
					<h1><?php echo $row["Product_ID"]; ?></h2>
					<h2><?php echo $row["Product_name"]; ?></h2>
					<h2>RM:<?php echo $row["Product_price"]; ?></h2>
					<div class="cart-action">
					<input type="text" class="product-quantity" name="quantity" value="1" size="2" />
					
					<input type="submit" value="Add to Cart" class="btnAddAction" />
					</div>
				  <a class="inf" href="view_info.php?info&code=<?php echo $row["Product_ID"]; ?>">Details</a>
				  
          </div>
          </form>
          </div>
			
				<?php
				
				}		
			
			?>
  
    </section>




</body>
</html>




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