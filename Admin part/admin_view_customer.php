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
		//search id
		if(!empty($_POST['idToSearch']))
		{
			$idToSearch = $_POST['idToSearch'];
		}
		else
		{
			$idToSearch = "";
		}
		
		//search name
		if(!empty($_POST['nameToSearch']))
		{
			$nameToSearch = $_POST['nameToSearch'];
		}
		else
		{
			$nameToSearch = "";
		}
		
		//search gender
		if(!empty($_POST['genderToSearch']))
		{
			$genderToSearch = $_POST['genderToSearch'];;
		}
		else
		{
			$genderToSearch = "";
		}
		
		
		$search_result = mysqli_query($connect,"SELECT * FROM users WHERE 
		id LIKE '%".$idToSearch."%'
		and username LIKE '%".$nameToSearch."%'
		and Member_gender LIKE '%".$genderToSearch."%'
		LIMIT $start_from, ".$results_per_page);
	}
	else
	{
		$search_result = mysqli_query($connect,"SELECT * from users ORDER BY id ASC LIMIT $start_from, ".$results_per_page);
	}
	
?>

<html>
<head>
<title>View Customer list</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="css/Admin_view_customer.css">
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
		<h1>Customer List</h1>
		<form action="admin_view_customer.php" method="post">
		<input type="text" name="idToSearch" placeholder="ID">
		<input type="text" name="nameToSearch" placeholder="Customer Name">
		<p>Gender :<select name="genderToSearch">
					<option value="">--Select Gender--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
			             </select>
		<input type="submit" name="search" value="Filter">
		
		<table border="0" width="1050px" style="border-collapse: collapse;">
			<tr>
				<th>ID</th>
				<th>Customer Name</th>
				<th>Gender</th>
				<th>IC</th>
				<th>Phone</th>
				<th>Email</th>
                <th>Address</th>
                <th>Balance</th>
				<th colspan="3">Action</th>
			</tr>


		
			<?php		
			
				while($row = mysqli_fetch_assoc($search_result))
				{
				?>			

				<tr>
					<td><?php echo $row["id"]; ?></td>
					<td><?php echo $row["username"]; ?></td>
					<td><?php echo $row["Member_gender"]; ?></td>
					<td><?php echo $row["Member_IC"]; ?></td>
                    <td><?php echo $row["Member_phone"]; ?></td>
                    <td><?php echo $row["Member_email"]; ?></td>
					<td><?php echo $row["Member_address"]; ?></td>
					<td><?php echo $row["balance"]; ?></td>
					<td><a href="admin_view_customer.php?del&code=<?php echo $row["id"]; ?>"class="delbtn" onclick="return confirmation();"><span class="material-icons">delete</span></a></td>
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
	//delete user id
	mysqli_query($connect, "DELETE FROM users WHERE id='$code';");
	echo '<script type="text/javascript"> 
        alert("Successful delete!")
        location.href="admin_view_customer.php"
        </script>';
}

?>


<?php 
$sql_total = "SELECT COUNT(id) AS total FROM users";
$result = $connect->query($sql_total);
$row = $result->fetch_assoc();
$total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
  
for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
            echo "<a href='admin_view_customer.php?page=".$i."'";
            if ($i==$page)  echo " class='curPage'";
            echo ">".$i."</a> "; 
}; 
?>