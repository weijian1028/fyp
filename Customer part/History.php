<?php
session_start();


?>
<?php include("connection.php"); ?>
<html>
<head>
<title>Cart</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Payment.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="script/sidebar.js"></script>

<script type="text/javascript">

function confirmation()
{
	choice = confirm("Do you want to delete?");
    return choice;
}

</script>



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


<?php
    if(empty($_SESSION["id"]))
	{
		?>
		<script type="text/javascript">
			alert("You must login and make payment.");
		</script>
		<?php
       header("location: Cart.php");
	}
    else
    {
        $memberid = $_SESSION["id"];
    }
?>


<!-- Get cart ID -->
<h1 class="pp">Order Done List</h1>
<form action="" method="post">

<table border="0" width="650px" style="border-collapse: collapse;">
			<tr class="content">
				<th>Cart ID</th>
				<th>Total quantity</th>
				<th>Total price</th>
				<th>Status</th>
				<th colspan="2">Action</th>
			</tr>
<?php
$cart_list = mysqli_query($connect, "select * from cart_id where Cart_status = 1 and Member_ID = '$memberid'");
while($list = mysqli_fetch_assoc($cart_list))
{
?>			
                <tr class="ev">
					<td><?php echo $list["Cart_ID"]; ?></td>
					<td><?php echo $list["Cart_total_qty"]; ?></td>
					<td><?php echo $list["Cart_total_price"]; ?></td>
					<?php
							if($list["Cart_status"] == 0)
							{
								echo "<td style='color:#F9F59C;'><span class='material-icons'>hourglass_full</span></td>";
							}
							else if($list["Cart_status"] == 1)
							{
				
								echo "<td style='color:#C7F99C;'><span class='material-icons'>check</span></td>";
							}
					?>
					
                    <td><a class="pay" href="History_details.php?view&code=<?php echo $list["Cart_ID"]; ?>"><span class="material-icons">receipt</span></a></td>
			
				</tr>
                <?php
				
				}		
			
			?>

		</table>

</form>




</body>
</html>




<?php
//remove cart from cart list
if (isset($_GET["del"])) 
{
	$code = $_GET["code"];
	//update cart table and set Cart_status to -1
	mysqli_query($connect, "update cart_id set Cart_status=-1 where Cart_ID ='$code'");
	echo '<script type="text/javascript"> 
        alert("Successful delete!")
        location.href="Payment.php"
        </script>';
}

?>