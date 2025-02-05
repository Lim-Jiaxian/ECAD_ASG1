<?php
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>

<!-- Create a container for the centered layout -->
<div
    style="width:60%; font-family: Poppins; margin:auto; margin-top:50px; margin-bottom:50px; padding:30px; background-color:#f9ece6; border-radius:10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <!-- Display Page Header -->
    <div class="row mb-4 text-center"> <!-- Centered header row -->
        <div class="col-12">
            <h2 class="page-title">Product Categories</h2>
            <p class="text-muted">Select a category listed below to view more</p>
        </div>
    </div>

    <?php
    // Include the PHP file that establishes database connection handle: $conn
    include_once("mysql_conn.php");

    $qry = "SELECT * FROM Category ORDER BY catName ASC"; // SQL to select all categories sorted by category name
    $result = $conn->query($qry); // Execute the SQL and get the result
    
    // Display each category in a row
    while ($row = $result->fetch_array()) {
        echo "<div class='row mb-4 align-items-center' style='padding:5px;'>"; // Start a new row

        $catname = urlencode($row["CatName"]);
        $catproduct = "catProduct.php?cid=$row[CategoryID]&catName=$catname";
        $img = "..//Images/Category/$row[CatImage]";

        echo "<div class='col'>"; // Start of card column
        echo "  <a href='$catproduct' style='text-decoration: none; color: inherit;'>";
        echo "      <div class='card h-100' style='box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
        echo "          <img src='$img' class='card-img-top' alt='$row[CatName]' style='height: 200px; object-fit: contain;'>";
        echo "          <div class='card-body text-center'>";
        echo "              <h5 class='card-title' style='font-size: 18px; font-weight: bold; color:#8d695b;'>$row[CatName]</h5>";
        echo "              <h5 class='card-title' style='font-size: 18px; font-weight: bold; color:#8d695b;'>$row[CatDesc]</h5>";
        echo "          </div>";
        echo "      </div>"; // End of card
        echo "  </a>";
        echo "</div>"; // End of card column
        echo "</div>";
    }

    // Closing database connection will be in footer.php
    ?>
</div>

<?php include("footer.php"); ?>