<?php
// Start session
session_start();

// Include the database connection
include_once("mysql_conn.php");

// Read the data input from previous page
$shopperID = $_SESSION["ShopperID"];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    // Update Query
    $updateQry = "UPDATE Shopper SET Name = ?, Email = ?, Country = ?, Address = ?, Phone = ? WHERE ShopperID = ?";
    
    // Prepare and execute the statement
    $stmt = $conn->prepare($updateQry);
    $stmt->bind_param("sssssi", $name, $email, $country, $address, $phone, $shopperID);

    // Cheeck if update was successful
    if ($stmt->execute()) {
        // Set success message and redirect back to profile page
        $_SESSION['message'] = "Your profile information has been updated successfully!";
        header("Location: profile.php");  // Change to the actual page you're redirecting to
        exit();
    } else {
        $_SESSION['message'] = "Failed to update profile. Please try again." . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
}

// Include footer
include("footer.php");
?>
