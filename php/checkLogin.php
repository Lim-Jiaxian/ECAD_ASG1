<?php
// Detect the current session
session_start();

// Reading inputs entered in the previous page
$email = $_POST["email"];
$pwd = $_POST["password"];

// Validate login credentials with database
include_once("./mysql_conn.php");
$qry = "SELECT * FROM shopper WHERE Email = ?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Save user's info in session variables
    while ($row = $result->fetch_array()) {
        $hashed_pwd = $row["Password"];
        if (strlen($hashed_pwd) < 60) { // Non-hashed password
            if ($pwd == $hashed_pwd) {
                // Hash the password and update the database
                $new_hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
                $updateQry = "UPDATE shopper SET Password = ? WHERE Email = ?";
                $updateStmt = $conn->prepare($updateQry);
                $updateStmt->bind_param("ss", $new_hashed_pwd, $email);
                $updateStmt->execute();
            }
        } else if (password_verify($pwd, $hashed_pwd)) { // Hashed password
            $_SESSION["ShopperName"] = $row["Name"];
            $_SESSION["ShopperID"] = $row["ShopperID"];

            // Initialize cart details
            $shopperID = $row["ShopperID"];
            $cartQry = "SELECT ShopCartID FROM ShopCart WHERE ShopperID = ? AND OrderPlaced = 0";
            $cartStmt = $conn->prepare($cartQry);
            $cartStmt->bind_param("i", $shopperID);
            $cartStmt->execute();
            $cartStmt->bind_result($shopCartID);
            $cartStmt->fetch();
            $cartStmt->close();

            if ($shopCartID) {
                $_SESSION["Cart"] = $shopCartID;

                // Get the number of items in the cart
                $itemQry = "SELECT SUM(Quantity) AS TotalItems FROM ShopCartItem WHERE ShopCartID = ?";
                $itemStmt = $conn->prepare($itemQry);
                $itemStmt->bind_param("i", $shopCartID);
                $itemStmt->execute();
                $itemStmt->bind_result($totalItems);
                $itemStmt->fetch();
                $itemStmt->close();

                $_SESSION["NumCartItem"] = $totalItems ?: 0; // Default to 0 if no items
            } else {
                $_SESSION["Cart"] = null;
                $_SESSION["NumCartItem"] = 0;
            }

            // Redirect to the home page
            header("Location: ../index.php");
            exit;
        }
    }
}

// Invalid login
include("header.php");
echo "
    <div class='error-statement'>
        <h3 style='color:red'>Invalid Login Credentials</h3>
        <a href='login.php'><button class='retry-login'>Retry</button></a>
    </div>
";
include("footer.php");
?>
