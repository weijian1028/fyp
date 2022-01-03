<?php 
	include("connection.php"); 
	session_start();
?>

<?php
		$results_per_page = 10;
				
					
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
		//search invoice id
		if(!empty($_POST['idToSearch']))
		{
			$idToSearch = $_POST['idToSearch'];
		}
		else
		{
			$idToSearch = "";
		}
		
		//search Member ID
		if(!empty($_POST['idMemberToSearch']))
		{
			$idMemberToSearch = $_POST['idMemberToSearch'];
		}
		else
		{
			$idMemberToSearch = "";
		}
		
		//search invoice status
		if(empty($_POST['statusToSearch']))
		{
			$statusToSearch = "";
		}
		else if($_POST['statusToSearch'] == 1)
		{
			$statusToSearch = 1;
			
		}
		else if($_POST['statusToSearch'] == 2)
		{
			$statusToSearch = 0;
			
		}
		
		$search_result = mysqli_query($connect,"SELECT * FROM invoice WHERE 
		Invoice_ID LIKE '%".$idToSearch."%'
		and Member_ID LIKE '%".$idMemberToSearch."%'
		and Invoice_status LIKE '%".$statusToSearch."%'
		LIMIT $start_from, ".$results_per_page);
	}
	else
	{
		$search_result = mysqli_query($connect,"SELECT * from invoice ORDER BY Invoice_ID ASC LIMIT $start_from, ".$results_per_page);
	}
	
?>

<html>
<head>
<title>View order list</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="css/Admin_view_order.css">
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
		<h1>Order List</h1>
		<form action="admin_view_order.php" method="post">
		<input type="text" name="idToSearch" placeholder="ID">
		<input type="text" name="idMemberToSearch" placeholder="Member ID">
		<p>Status :<select name="statusToSearch">
					<option value="">--Select status--</option>
                    <option value="2">Waiting</option>
                    <option value="1">Done</option>
			             </select>
		
		<input type="submit" name="search" value="Filter">
		
		<table border="0" width="1050px" style="border-collapse: collapse;">
			<tr>
				<th>Invoice ID</th>
				<th>Date</th>
				<th>Status</th>
                <th>Customer ID</th>
				<th>Cart ID</th>
                <th>Payment</th>
				<th colspan="3">Action</th>
			</tr>


		
			<?php		
			
				while($row = mysqli_fetch_assoc($search_result))
				{
				$cart_id = $row["Cart_ID"];
				$result_cart = mysqli_query($connect,"SELECT * from cart_id where Cart_ID = ".$cart_id);
				$cart_name = mysqli_fetch_assoc($result_cart);
				?>			

				<tr>
					<td><?php echo $row["Invoice_ID"]; ?></td>
					<td><?php echo $row["Invoice_date"]; ?></td>
                    <?php
							if($row["Invoice_status"] == 0)
							{
								echo "<td style='color:#F9F59C;'><span class='material-icons'>pending_actions</span></td>";
							}
							else if($row["Invoice_status"] == 1)
							{
				
								echo "<td style='color:#C7F99C;'><span class='material-icons'>check</span></td>";
							}
					?>
					<td><?php echo $row["Member_ID"]; ?></td>
					<td><?php echo $row["Cart_ID"]; ?></td>
					<td><?php echo $cart_name["Cart_total_price"]; ?></td>
					
					<td><a href="admin_view_order_details.php?view&code=<?php echo $row["Cart_ID"]; ?>&inv=<?php echo $row["Invoice_ID"]; ?>" class="editbtn"><span class="material-icons">text_snippet</span></a></td>
					<td><a href="admin_view_order.php?del&code=<?php echo $row["Invoice_ID"]; ?>"class="delbtn" onclick="return confirmation();"><span class="material-icons">delete</span></a></td>
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
	mysqli_query($connect, "DELETE FROM invoice WHERE Invoice_ID='$code';");
	echo '<script type="text/javascript"> 
        alert("Successful delete!")
        location.href="admin_view_order.php"
        </script>';
}

?>


<?php 
$sql_total = "SELECT COUNT(Invoice_ID) AS total FROM invoice";
$result = $connect->query($sql_total);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
            echo "<a href='admin_view_order.php?page=".$i."'";
            if ($i==$page)  echo " class='curPage'";
            echo ">".$i."</a> "; 
}; 
?>