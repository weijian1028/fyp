<?php
session_start();
?>
<?php include("connection.php"); ?>

<html>
<head>
<title>Profile</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Profile.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="script/sidebar.js"></script>

<body>
<?php
	if(!empty($_SESSION["id"])){  
		$user_id = $_SESSION["id"];
		$result = mysqli_query($connect, "SELECT * FROM users WHERE id='$user_id'");
		$row = mysqli_fetch_assoc($result);
	}else{
		header("location: Login.php");
	}
	

?>


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
		while($row1 = mysqli_fetch_assoc($cate_result))
		{
		?>	
			<a href="Category.php?comein&code=<?php echo $row1["Category_ID"]; ?>"><?php echo $row1["Category_name"];?></a>
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

if(isset($_POST["save"]))	
{	
	$pid=$_SESSION["id"];
	$mphone=$_POST["Member_phone"];
	$add=$_POST["Member_Address"];

	
	mysqli_query($connect,"UPDATE users SET Member_phone='$mphone',Member_address='$add' WHERE id ='$pid'");
	header("location: Profile.php");
	
}

if(isset($_POST["savepicture"]))
{
	$pid=$_SESSION["id"];
	$image = $_FILES['image']['name'];
	$target = "images/".basename($image);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		$msg = "Image uploaded successfully";
	}else{
		$msg = "Failed to upload image";
	}

	mysqli_query($connect,"UPDATE users SET image='$image' WHERE id ='$pid'");
	header("location: Profile.php");
}	


if(isset($_POST["savepass"]))
{
	$pid=$_SESSION["id"];
	$pass=$_POST["password"];
	$hash_password = password_hash($pass, PASSWORD_DEFAULT);
	mysqli_query($connect,"UPDATE users SET password='$hash_password' WHERE id ='$pid'");
}	

?>




<!-- Profile -->
<form method="post" action=""  enctype="multipart/form-data">
<?php
	if(!empty($row["image"])){
		echo "<div class='profile'>";		
      	echo "<img src='images/".$row['image']."' >";	
	    echo "<div class='upload-btn-wrapper'>";
	    echo "<button class='btn'>Upload profile</button>";
		echo "<input type='file' name='image'>";
		echo "</div>";
		echo "</div>";
	}else{
		echo "<div class='profile'>";
      	echo "<img src='image/profile.jpeg'/>";
		echo "<div class='upload-btn-wrapper'>";
		echo "<button class='btn'>Upload profile</button>";
		echo "<input type='file' name='image'>";		
	  	echo "</div>";
		echo "</div>";
	}

?>


<div class="box">
	<div class="title1"><h2>User Info</h2></div>
	<div class="info">
	<p><label>Name    :</label><input class="line" "type="text" name="username" value="<?php echo $row["username"]; ?>" disabled></p>
	
	
	<p><label>Contact:</label><input class="line" "type="text" name="Member_phone" value="<?php echo $row["Member_phone"]; ?>"></p>
	<p><label>Address:</label><input class="line" "type="text" name="Member_Address" value="<?php echo $row["Member_address"]; ?>"></p>
	<p><label>Balance:</label><input class="line1" "type="text" name="Member_Balance" value="<?php echo $row["balance"]; ?>" disabled><a href="Reload.php" class="reload">Reload</a></p>
	</div>
</div>


<div class="box2">
	<div class="title1"><h2>Security</h2></div>
	<div class="pass">
	<p><label>New Password:</label><input type="password" name="password"></p>
	<p><label>Confirm Password:</label><input type="password" name="password"></p>
	<input name="savepass" type="submit" value="Save Password" class="savepassbtn">
	</div>
</div>
<div class="save">
	<input name="savepicture" type="submit" value="Save Picture">
	<input name="save" type="submit" value="Save Changes">
	<span></span>
    <input name="cancel" type="reset" value="Cancel">
</div>
</form>


</body>
</html>
