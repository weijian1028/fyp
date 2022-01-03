<?php


$connect = mysqli_connect("localhost", "root", "", "fyp");

if($connect)
{
	echo("<script>console.log('Connect successfully!');</script>");
}

?>
