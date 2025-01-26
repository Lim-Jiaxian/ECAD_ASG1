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
		// Get the hashed password or non-hashed password from database
		$hashed_pwd = $row["Password"];
		// Check if the current passowrd length is not hashed and contains less than 60 characters 
		// Bcrypt hashed passwords contain 60 characters
		if (strlen($hashed_pwd) < 60) {
			if ($pwd == $hashed_pwd){
				$checkLogin = true;
				$_SESSION["ShopperName"] = $row["Name"];
				$_SESSION["ShopperID"] = $row["ShopperID"];
				// Create a password hash using the default bcrypt algorithm since the user's password was not hashed before
				$password =  password_hash($_POST["password"], PASSWORD_DEFAULT);
				// Define the UPDATE SQL statement for password
				$qry = "UPDATE Shopper set Password = ? where Email = ?";
				$stmt = $conn->prepare($qry);
				// Binding of parameters
				$stmt->bind_param("ss", $password, $row["Email"]);
				// Execute SQL statement
				$stmt->execute();
				// Redirect to home page
				header("Location: ../index.php");
				exit;
			}
		}
		else if (password_verify($pwd, $hashed_pwd) == true)
		{
			// Set checking for login to true
			$checkLogin = true;
			// Assign shopper details to session
			$_SESSION["ShopperName"] = $row["Name"];
			$_SESSION["ShopperID"] = $row["ShopperID"];
			// Redirect to home page
			header("Location: ../index.php");
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
