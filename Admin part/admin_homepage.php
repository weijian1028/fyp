<?php include("connection.php"); ?>

<?php
// Initialize the session
session_start();
?>


<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://use.fontawesome.com/0f85f270f7.js"></script>
<script src="script/sidebar.js"></script>
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="css/AdminHomepage.css">

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


<!-- Total number of invoice -->
<?php
    $sql_total = "SELECT COUNT(Invoice_ID) AS total FROM invoice";
    $result = $connect->query($sql_total);
    $row = $result->fetch_assoc();
    $total_invoice = ceil($row["total"]);

?>

<!-- Total income -->
<?php
  $total_income =  mysqli_query($connect,"SELECT * FROM cart_id WHERE Cart_status = 1");
  $tincome = 0;
  while($row_income = mysqli_fetch_assoc($total_income))
  {
    $tincome += $row_income["Cart_total_price"];
  }

?>

<!-- Pending Order -->
<?php
  $pending = "SELECT count(*) AS total FROM invoice WHERE Invoice_status = 0";
  $result_pend = $connect->query($pending);
  $row_pending = $result_pend->fetch_assoc();
  $pending_order = ceil($row_pending["total"]);

?>

<!-- Number of product sell -->
<?php
  $total_sell =  mysqli_query($connect,"SELECT * FROM cart_id WHERE Cart_status = 1");
  $tsell = 0;
  while($row_tsell = mysqli_fetch_assoc($total_sell))
  {
    $tsell += $row_tsell["Cart_total_qty"];
  }

?>


<!-- List -->
<div id="homepage">
  <div class="title1"><h1>Dashboard</h1></div>


  <div class="box" style="top:100px; left:100px;">
    <p><span class="material-icons">pending_actions</span>Pending order:<?php echo $pending_order;?></p>
  </div>
  <div class="box" style="top:100px; left:250px;">
    <p><span class="material-icons">paid</span>Total income: RM<?php echo $tincome;?></p>
  </div>
  <div class="box" style="top:100px; left:400px;">
    <p><span class="material-icons">receipt</span>Total invoice:<?php echo $total_invoice;?></p>
  </div>
  <div class="box" style="top:100px; left:550px;">
    <p><span class="material-icons">local_offer</span>Product sale:<?php echo $tsell;?></p>
  </div>

  <!-- List -->
<div id="designall"style="position:absolute; top:400px; left:100px;">
		<h1>Pending Orders</h1>
		<form action="admin_view_order.php" method="post">
		
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
       $search_result = mysqli_query($connect,"SELECT * from invoice where Invoice_status=0 ORDER BY Invoice_ID");
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


</div>

   
</body>
</html> 
