<?php
// Detect the current session
session_start(); 

// Display Page Layout header with updated session state and links.
include("header.php");

// Read the data input from previous page
$shopperID = $_SESSION["ShopperID"];
//$_SESSION["ShopperID"] = $row["ShopperID"];

// Include the PHP file that establishes database connection handle: $conn 
include_once("mysql_conn.php");

// Define the INSERT SQL statement
$qry = "SELECT * FROM Shopper WHERE ShopperID = ?";
$stmt = $conn->prepare($qry);
// Bind and execute statement
$stmt->bind_param("i", $shopperID);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
// Closing database connection will be in footer.php

// Fetch shopper information
while ($row = $result->fetch_array()) {
    $shopperName = $row["Name"];
    $shopperDOB = $row["BirthDate"];
    $shopperAdrs = $row["Address"];
    $shopperCountry = $row["Country"];
    $shopperPhone = $row["Phone"];
    $shopperEmail = $row["Email"];
    $shopperJoinDate = $row["DateEntered"];
}
?>

<!-- Profile Form -->
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #fcfcfc; padding: 50px 0;">
    <div class="profilee-form p-4" style="background: #ffffff; width: 90%; max-width: 900px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h3 class="text-center mb-4" style="color: #8d695b; font-weight: bold;">Profile Information</h3>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success text-center"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <form name="profileUpdate" action="updateProfile.php" method="POST">
            <div class="row">
                <!-- Join Date -->
                <div class="col-md-6 mb-3">
                    <label for="joindate" class="form-label" style="color: #8d695b;">Shopper Join Date:</label>
                    <input type="text" name="joindate" id="joindate" class="form-control" value="<?= htmlspecialchars($shopperJoinDate) ?>" readonly />
                </div>
                <!-- Date of Birth -->
                <div class="col-md-6 mb-3">
                    <label for="dob" class="form-label" style="color: #8d695b;">Date of Birth:</label>
                    <input type="text" name="dob" id="dob" class="form-control" value="<?= htmlspecialchars($shopperDOB) ?>" readonly />
                </div>
            </div>
            <div class="row">
                <!-- Shopper ID -->
                <div class="col-md-6 mb-3">
                    <label for="shopperID" class="form-label" style="color: #8d695b;">Shopper ID:</label>
                    <input type="text" name="shopperID" id="shopperID" class="form-control" value="<?= htmlspecialchars($shopperID) ?>" readonly />
                </div>
                <!-- Name -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label" style="color: #8d695b;">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="<?= htmlspecialchars($shopperName) ?>" required />
                    <small class="form-text text-muted">(required*)</small>
                </div>
            </div>
            <div class="row">
                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label" style="color: #8d695b;">Email Address:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="<?= htmlspecialchars($shopperEmail) ?>" required />
                    <small class="form-text text-muted">(required*)</small>
                </div>
                <!-- Phone -->
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label" style="color: #8d695b;">Phone:</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="<?= htmlspecialchars($shopperPhone) ?>" required />
                    <small class="form-text text-muted">(required*)</small>
                </div>
            </div>
            <div class="row">
                <!-- Country -->
                <div class="col-md-6 mb-3">
                    <label for="country" class="form-label" style="color: #8d695b;">Country:</label>
                    <input type="text" name="country" id="country" class="form-control" placeholder="<?= htmlspecialchars($shopperCountry) ?>" required />
                    <small class="form-text text-muted">(required*)</small>
                </div>
                <!-- Address -->
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label" style="color: #8d695b;">Address:</label>
                    <textarea name="address" id="address" class="form-control" rows="2" required placeholder="<?= htmlspecialchars($shopperAdrs) ?>"></textarea>
                    <small class="form-text text-muted">(required*)</small>
                </div>
            </div>
            <!-- Update Button -->
            <div class="text-center mt-3">
                <button type="submit" class="btn" style="background-color: #8d695b; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Update</button>
            </div>
        </form>
    </div>
</div>



<?php
// Display Page Layout footer
include("footer.php");
?>