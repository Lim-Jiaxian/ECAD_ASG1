<?php
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>

<!-- Create a container for the centered layout -->
<div
    style="width:60%; margin:auto; margin-top:50px; margin-bottom:50px; padding:30px; background-color:#ffffff; border-radius:10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <!-- Display Page Header -->
    <div class="row mb-4 text-center"> <!-- Centered header row -->
        <div class="col-12">
            <h2 class="page-title">Product Categories</h2>
            <p class="text-muted">Select a category listed below:</p>
        </div>
    </div>

    <?php
    // Include the PHP file that establishes database connection handle: $conn
    include_once("mysql_conn.php");

    $qry = "SELECT * FROM Category"; // Form SQL to select all categories 
    $result = $conn->query($qry); // Execute the SQL and get the result
    
    // Display each category in a row
    while ($row = $result->fetch_array()) {
        echo "<div class='row mb-4 align-items-center' style='padding:5px;'>"; // Start a new row
    
        // Left column - display a text link showing the category's name, 
        //               display category's description in a new paragraph
        $catname = urlencode($row["CatName"]);
        $catproduct = "catProduct.php?cid=$row[CategoryID]&catName=$catname";
        echo "<div class='col-md-8'>"; // Text section (67% width)
        echo "<h5><a href='$catproduct' style='color:#8d695b; text-decoration:none;'>$row[CatName]</a></h5>";
        echo "<p class='text-muted'>$row[CatDesc]</p>";
        echo "</div>";

        // Right column - display the category's image 
        $img = "..//Images/Category/$row[CatImage]";
        echo "<div class='col-md-4 text-center'>"; // Image section (33% width)
        echo "<img src='$img' style='max-height:100px; max-width:100%;' alt='$row[CatName]' />";
        echo "</div>";

        echo "</div>"; // End of a row
    }

    $conn->close(); // Close database connection
    ?>
</div>

<?php include("footer.php"); ?>