<?php
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php"); 

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["password"];

// validating login credentials with database
include_once("./mysql_conn.php"); // sql connection string php file
$qry = "SELECT * FROM shopper WHERE Email LIKE '%$email%'";
$result = $conn->query($qry);


// To Do 1 (Practical 2): Validate login credentials with database
if ($result->num_rows > 0) {
	// Save user's info in session variables
	while ($row = $result->fetch_array()){
		//Get the hashed password from database
		$hashed_pwd = $row["Password"];
		if (password_verify($pwd, $hashed_pwd) == true)
		{//if (password_verify($pwd, $hashed_pwd) == true)
			$checkLogin = true;
			$_SESSION["ShopperName"] = $row["Name"];
			$_SESSION["ShopperID"] = $row["ShopperID"];
			// // To Do 2 (Practical 4): Get active shopping cart
			// $sid = $_SESSION["ShopperID"];
			// $qry = "SELECT sc.ShopCartID, COUNT(sci.ProductID) AS NumItems FROM ShopCart sc LEFT JOIN ShopCartItem sci ON sc.ShopCartID = sci.ShopCartID WHERE sc.ShopperID=$sid AND sc.OrderPlaced = 0";
			// $result = $conn->query($qry);

			// if ($result->num_rows > 0) {
			// 	while ($row = $result->fetch_array()){
			// 		$_SESSION["Cart"] = $row["ShopCartID"];
			// 		$_SESSION["NumCartItem"] = $row["NumItems"];
			// 	}
			// }

			// Redirect to home page
			header("Location: ../index.php");
			// Redirect to product page temporarily until home discounts is added
			header("Location: ./category.php");
			exit;
		}
		else {
			echo  "<h3 style='color:red'>Invalid Login Credentials</h3>";
		}
		
	}
}else{
	echo  "<h3 style='color:red'>Invalid User</h3>";
}
	
// Include the Page Layout footer
include("footer.php");
?>
