<?php 
	include("connection.php"); 
	session_start();
?>

<?php
		$results_per_page = 30;
				
					
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
		//search year
		if(!empty($_POST['yearToSearch']))
		{
			$yearToSearch = $_POST['yearToSearch'];
		}
		else
		{
			$yearToSearch = "";
		}
		
		//search month
		if(!empty($_POST['monthToSearch']))
		{
			$monthToSearch = $_POST['monthToSearch'];
		}
		else
		{
			$monthToSearch = "";
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
		YEAR(Invoice_date) LIKE '%".$yearToSearch."%'
		and MONTH(Invoice_date) LIKE '%".$monthToSearch."%'
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
<title>View Report</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="css/Admin_view_report.css">
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
		<h1>View Report</h1>
		<form action="admin_view_report.php" method="post">
        <input type="text" name="yearToSearch" placeholder="Year">
		<p>Month :<select name="monthToSearch">
					<option value="">--Select Month--</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
			             </select>
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
                <th>Product qty</th>
                <th>Cart ID</th>
                <th>Payment</th>
			</tr>


		
			<?php		
                $total_payment = 0;
                $total_qty = 0;
                $total_product = 0;
				while($row = mysqli_fetch_assoc($search_result))
				{
				$cart_id = $row["Cart_ID"];
				$result_cart = mysqli_query($connect,"SELECT * from cart_id where Cart_ID = ".$cart_id);
				$cart_name = mysqli_fetch_assoc($result_cart);

                $total_payment += $cart_name["Cart_total_price"];
                $total_product += $cart_name["Cart_total_qty"];
                $total_qty += 1;
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
                    <td><?php echo $cart_name["Cart_total_qty"]; ?></td>
                    <td><?php echo $row["Cart_ID"]; ?></td>	
					<td><?php echo $cart_name["Cart_total_price"]; ?></td>	
				</tr>
				<?php
				
				}		
			
			?>

                <tr class="last">
                <td></td>
                <td colspan="0" align="right">Total quantity:</td>
                <td align="left"><?php echo $total_qty; ?></td>
                <td colspan="0" align="right">Total product sales:</td>
                <td align="left"><?php echo $total_product; ?></td>
                <td colspan="0" align="right">Total income:</td>
                <td align="left"><?php echo "$ ".number_format($total_payment, 2); ?></td>
                </tr>

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
        location.href="admin_view_report.php"
        </script>';
}

?>


<?php 
$sql_total = "SELECT COUNT(Invoice_ID) AS total FROM invoice";
$result = $connect->query($sql_total);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
            echo "<a href='admin_view_report.php?page=".$i."'";
            if ($i==$page)  echo " class='curPage'";
            echo ">".$i."</a> "; 
}; 
?>