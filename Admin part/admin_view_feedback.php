<?php 
	include("connection.php"); 
	session_start();
?>
<html>
<head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="css/admin_view_feedback.css">
<link rel="stylesheet" href="css/Admin_edit_product.css">
<script src="script/sidebar.js"></script>

</head>
<body>
<!-- Header -->
<div id="header">
<a class="title"><span class="animationstyle">bakery Shop ADMIN</span></a>
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

<h2 class="pp">Contact us<span class="material-icons">chat</span></h2>
<form action="" method="POST">
<table width="650px" style="border-collapse: collapse;">
			

<?php
$c_list = mysqli_query($connect, "select * from contact ");
while($list = mysqli_fetch_assoc($c_list))
{
?>			
                <div class="ev">
					<p><span class="material-icons">face</span>Name:<?php echo $list["Contact_name"]; ?></p>
					<p><span class="material-icons">mail</span>Email:<?php echo $list["Contact_email"]; ?></p>
					<p><span class="material-icons">phone</span>Contact:<?php echo $list["Contact_phone"]; ?></p>
					<p><span class="material-icons">speaker_notes</span>Message:<?php echo $list["Contact_message"]; ?></p>
                    <br>
				</div>
                <?php
				
				}		
			
			?>

		</table>
</form>




</body>
</html>