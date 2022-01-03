<?php
session_start();

?>
<?php include("connection.php"); ?>
<html>
<head>
<title>Cart</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Reload.css">
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

if (isset($_POST["reload"])) 
{
    $reload_amount = $_POST["balance"];
    $memberid = $_SESSION["id"];

  	$mid = mysqli_query($connect, "select * from users where id = '$memberid'");
    $row_id = mysqli_fetch_assoc($mid);

    $current_balance = $row_id["balance"];

    $new_balance = $current_balance + $reload_amount;


    mysqli_query($connect, "update users set balance='$new_balance' where id ='$memberid'");
  
    echo '<script type="text/javascript"> 
        alert("Your Balance successful reload")
        location.href="Profile.php"
        </script>';

}

?>

<h1 class="title">Payment Form</h1>

<form action="" method="post">
<div class="container2">
        <div class="titi">
        <h3>Payment</h3>
        </div>
        <br>
        <label for="cname">Name on Card</label>
        <input type="text" name="cardname" placeholder="Card Name">
        <label for="ccnum">Credit card number</label>
        <input type="text" name="cardnumber" placeholder="1111-2222-3333-4444">
        <label for="expmonth">Exp Month</label>
        <input type="text" name="expmonth" placeholder="June/July/August">
        <label for="expyear">Exp Year</label>
        <input type="text"  name="expyear" placeholder="2018">
        <label for="cvv">CVV</label>
        <input type="text" name="cvv" placeholder="333">
        <label for="cvv">Amount</label>
        <input type="text" name="balance" placeholder="RM">
 
</div>
        <input type="submit" name="reload" value="Confirm">
</form>
</body>
</html>

