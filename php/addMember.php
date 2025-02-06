<?php
// Detect the current session
session_start(); 

// Read the data input from previous page
$name = $_POST["name"];
$dob = $_POST["dob"];
$address = $_POST["address"];
$country = $_POST["country"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = $_POST["password"];
$passwordQn = $_POST["passwordQn"];
$passwordAns = $_POST["passwordAns"];

// Create a password hash using the default bcrypt algorithm
$password =  password_hash($_POST["password"], PASSWORD_DEFAULT);

// Include the PHP file that establishes database connection handle: $conn 
include_once("mysql_conn.php");

// Define the INSERT SQL statement
$qry = "INSERT INTO Shopper (Name, BirthDate, Address, Country, Phone, Email, Password, PwdQuestion, PwdAnswer)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($qry);
// "ssssss" - 6 string parameters
$stmt->bind_param("sssssssss", $name, $dob ,$address, $country, $phone, $email, $password, $passwordQn, $passwordAns);

if ($stmt->execute()) { // SQL statement executed successfully 
    // Retrieve the Shooper ID assigned to the new shopper
    $qry = "SELECT LAST_INSERT_ID() AS ShopperID";
    $result = $conn->query($qry); // Execute the SQL and get the returned result 
    while ($row = $result->fetch_array()) {
        $_SESSION["ShopperID"] = $row["ShopperID"];
    }

    // Successful message and Shopper ID
    $Message = "Registration successful!<br />
                Your Shopper ID is $_SESSION[ShopperID]<br />";
    // Save the Shopper Name in a session variable
    $_SESSION["ShopperName"] = $name;
}
else { // Error message
    $Message="<h3 style='color:red'>Error in inserting record</h3>";
}

// Release the resource allocated for prepared statement
$stmt->close();
// Close database connection
$conn->close();
// Redirect to home page
header("Location: ../index.php");
// Display Page Layout header with updated session state and links.
include("header.php");
// Display message
echo $Message;
// Display Page Layout footer
include("footer.php");
?>