<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>

<!-- HTML Form to collect search keyword and submit it to the same page in server -->
<div style="width:80%; margin:auto;"> <!-- Container -->
<form name="frmSearch" method="get" action="">
    <div class="mb-3 row"> <!-- 1st row -->
        <div class="col-sm-9 offset-sm-3">
            <span class="page-title">Product Search</span>
        </div>
    </div> <!-- End of 1st row -->
    <div class="mb-3 row"> <!-- 2nd row -->
        <label for="keywords" 
               class="col-sm-3 col-form-label">Product Title:</label>
        <div class="col-sm-6">
            <input class="form-control" name="keywords" id="keywords" 
                   type="search" />
        </div>
        <div class="col-sm-3">
            <button class='btn btn-primary btn-sm' type="submit">Search</button>
        </div>
    </div>  <!-- End of 2nd row -->
</form>

<?php
// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 
// The non-empty search keyword is sent to server
if (isset($_GET["keywords"]) && trim($_GET['keywords']) != "") { 
    // Retrieve list of product records with "ProductTitle" 
	// contains the keyword entered by shopper, and display them in a table.

    $keyword = $_GET['keywords'];
    // SQL statement with a LIKE query to find user input search
    $qry = "SELECT ProductID, ProductTitle FROM product WHERE ProductTitle LIKE ? OR ProductDesc LIKE ? ORDER BY ProductTitle";
    $stmt = $conn->prepare($qry);
    $likeKeyword = '%'.$keyword.'%';
    $stmt->bind_param("ss", $likeKeyword, $likeKeyword);
    $stmt->execute();
    $result = $stmt->get_result(); 
    // Close statement and connection
    $stmt->close();
    $conn->close();

    if ($result->num_rows > 0) {
        // Display results in table
        echo "<table class='table'>";
        // Move the search result header above the loop
        echo "<tr><th>Showing list of products with " . htmlspecialchars($keyword) . " in the product name or description</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $product = "productDetails.php?pid=" . $row['ProductID']; 
            echo "<tr>";
            // Display search result product titles
            echo "<td><a href='$product'>" . htmlspecialchars($row['ProductTitle']) . "</a></td>"; 
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No products found with '" . htmlspecialchars($keyword) . "' in the product name or description</p>";
    }
}

echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>