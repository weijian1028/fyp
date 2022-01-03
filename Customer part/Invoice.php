<?php
session_start();

?>
<?php include("connection.php"); ?>
<html>
<head>
<title>Cart</title>
<link rel="stylesheet" href="css/Basic.css">
<link rel="stylesheet" href="css/Invoice.css">
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
	if(isset($_GET["pay"]))
	{
	$pid = $_GET["code"];   
    $spid = $_GET["shp"];
    
	$result = mysqli_query($connect, "select * from cart_details where Cart_ID = '$pid'");
    $result_ship = mysqli_query($connect, "select * from shipping where shipping_id = '$spid'");

	}
?>


<?php

if (isset($_GET["invoice"])) 
{
    $leftid = $_GET["left"];
    if($leftid <0 )
    {
        $leftid = 0;
    }

    $cartid = $_GET["code"];
    $memberid = $_SESSION["id"];
    $shipping_id = $_GET["shipp"];

    foreach ($_SESSION["invoice_item"] as $item)
    {
        echo "Hi";
        $product_stock = 0;
        $array_product = $item["Product_ID"];
        $result_pd = mysqli_query($connect, 'Select * from product where Product_ID = "'.$array_product.'"');
		$ps = mysqli_fetch_array($result_pd);

		$product_stock = $ps["Product_stock"] - $item["Product_qty"];

        if($product_stock < 0)
        {
            echo '<script type="text/javascript"> 
            alert("The product ID '.$array_product.' is out of stock!")
            location.href="Payment.php"
            </script>';
            exit;
        }
        else {
            mysqli_query($connect, "UPDATE product SET Product_stock='$product_stock' WHERE Product_ID ='$array_product'");
        }
    }



	$result = mysqli_query($connect, "select * from cart_details where Cart_ID = '$cartid'");
	
    mysqli_query($connect, "update cart_id set Cart_status=1 where Cart_ID ='$cartid'");
    
    mysqli_query($connect, "update users set balance='$leftid' where id ='$memberid'");

	mysqli_query($connect, 'insert into invoice(Member_ID,Cart_ID,shipping_id)
	values('.$memberid.','.$cartid.','.$shipping_id.')');

    $invoiceid = mysqli_insert_id($connect);

    unset($_SESSION["invoice_item"]);
    echo '<script type="text/javascript"> 
        alert("Your invoice ID is '.$invoiceid.'")
        location.href="History.php"
        </script>';


}

?>

		<h1 class="title2">Invoice Detail</h1>
		<div class="invoice-box">
		<form name="updatefrm" method="post" action="">
        <table border="0" width="650px" style="border-collapse: collapse;">
			<h2 class="title">INVOICE</h2>
            <p>Style Shop</p>
            <p>666,Jalan Gembira</p>
            <p>Taman Sungai,</p>
            <p>81000, Kulai, Johor.</p>
            <hr>
            <?php 
                $info_ship = mysqli_fetch_assoc($result_ship);
                $date = date('m/d/Y h:i:s a', time());
            ?>
            <br>
            <p>Bill to : <?php echo $info_ship["shipping_name"]; ?></p>
            <p>Shipping ID: <?php echo $info_ship["shipping_id"]; ?></p>
            <p>Address: <?php echo $info_ship["shipping_address"]; ?></p>
            <p align="right">Invoice Date:<?php echo date("d-m-Y"); ?></p>
			<tr class="content">
				<th>Product ID</th>
                <th>Product Name</th>
				<th>Quantity</th>
                <th>Price</th>
				<th>Total price</th>
			</tr>
            <?php
            $total = 0;
            $total_quantity=0;
            $total_price=0;
            $times = 0;

            while($list = mysqli_fetch_assoc($result))
				{
                    $prod_id = $list["Product_ID"];
				    $result_name = mysqli_query($connect,'SELECT * from product where Product_ID = "'.$prod_id.'"');
			    	$list_name = mysqli_fetch_assoc($result_name);
                    $total += $list["Product_total_price"];
                    
                    $invArray = array($list["Product_ID"]=>array('Product_ID'=>$list["Product_ID"],'Product_qty'=>$list["Product_qty"]));
                    if($times == 0)
                    {
                        $_SESSION["invoice_item"] = $invArray;
                    }
                    else {
                        $_SESSION["invoice_item"] = array_merge($_SESSION["invoice_item"],$invArray);
                    }
                    
                    $times++;
                    ?>
            <tr class="ev">
					<td><?php echo $list["Product_ID"]; ?></td>
                    <td><?php echo $list_name["Product_name"]; ?></td>
					<td><?php echo $list["Product_qty"]; ?></td>
                    <td><?php echo $list["Product_price"]; ?></td>
					<td><?php echo $list["Product_total_price"]; ?></td>
				</tr>
                <?php
                    $total_quantity += $list["Product_qty"];
                    $total_price += ($list["Product_price"]*$list["Product_qty"]);
                }
                ?>
                <tr class="content">
                <td colspan="2" align="right">Total:</td>
                <td align="left" colspan="2"><?php echo $total_quantity; ?></td>
                <td align="center" ><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
                </tr>
        
        </table>
		


        <?php
            $bid = $_SESSION["id"];
            $balanceid = mysqli_query($connect, "select * from users where id = '$bid'");
            $balance_name = mysqli_fetch_assoc($balanceid);
            $balance = $balance_name["balance"];
            $tax = 0;
            $total = 0;
            $left=0;
            $tax = $total_price * 0.03;
            $total = $total_price + $tax; 
            $left = $balance - $total;
        ?>
		<div class="space">
        <br>
        <p>Your current balance:<span id="show"><?php echo "RM ".number_format($balance, 2); ?></span></p>
        <p>Subtotal:<span id="show"><?php echo "RM ".number_format($total_price, 2); ?></span></p>
        <p>Shipping Fee (3%):<span id="show"><?php echo "RM ".number_format($tax, 2); ?></p>
        <p>Total:<span id="show"><?php echo "RM ".number_format($total, 2); ?></span></p>
        <p>Balance:<span id="show"><?php echo "RM ".number_format($left, 2); ?></span></p>
        <br>
        <hr>
        <br>
        <p style="font-size:30px;">Total:<span id="show"><?php echo "RM ".number_format($total, 2); ?></span></p>
		</div>
		</div>
        <br><br>
        <a class="inf"href="Payment.php">Back</a>
        <a class="inff" href="Invoice.php?invoice&code=<?php echo $pid; ?>&left=<?php echo $left; ?>&shipp=<?php echo  $info_ship["shipping_id"];?>">Pay</a>
        

        </form>


</body>
</html>

