﻿<?php
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Container for the product details -->
<div class="container-fluid d-flex flex-column" style="min-height: 100vh; font-family: 'Poppins', sans-serif;">
    <div class="container" style="margin-top: 80px; margin-bottom: 80px;">
        <?php
        $pid = $_GET["pid"]; // Read Product ID from query string
        
        // Include the PHP file that establishes database connection handle: $conn
        include_once("mysql_conn.php");
        $qry = "SELECT * FROM product WHERE ProductID=?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("i", $pid); // "i" - integer
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        // Display Product information
        while ($row = $result->fetch_array()) {
            // Product Title
            echo "<div class='row text-center mb-5'>";
            echo "    <div class='col-12'>";
            echo "        <h2 style='font-size: 36px; font-weight: bold; color: #8d695b;'>$row[ProductTitle]</h2>";
            echo "    </div>";
            echo "</div>";

            echo "<div class='row align-items-center justify-content-center'>"; // Start a new row
        
            // Left Column - Product Image
            $img = "../Images/Products/$row[ProductImage]";
            echo "<div class='col-lg-5 col-md-6 text-center mb-4'>";
            echo "    <img src='$img' style='width: 100%; max-width: 450px; height: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);' alt='$row[ProductTitle]' />";
            echo "</div>";

            // Right Column - Product Details
            echo "<div class='col-lg-6 col-md-6'>";
            echo "    <p style='font-size: 18px; line-height: 1.8; color: #8d695b;'>$row[ProductDesc]</p>";

            // Product Specifications
            $qry = "SELECT s.SpecName, ps.SpecVal FROM productspec ps 
                    INNER JOIN specification s ON ps.SpecID = s.SpecID 
                    WHERE ps.ProductID=? ORDER BY ps.priority";
            $stmt = $conn->prepare($qry);
            $stmt->bind_param("i", $pid); // "i" - integer
            $stmt->execute();
            $result2 = $stmt->get_result();
            $stmt->close();

            echo "    <ul style='list-style: none; padding: 0; font-size: 18px; color: #8d695b;'>";
            while ($row2 = $result2->fetch_array()) {
                echo "        <li><strong>{$row2["SpecName"]}:</strong> {$row2["SpecVal"]}</li>";
            }
            echo "    </ul>";

            // Product Price
            $formattedPrice = number_format($row["Price"], 2);
            echo "    <h4 style='color: red; font-weight: bold; font-size: 24px; margin-top: 20px;'>Price: S$ $formattedPrice</h4>";

            // Add to Cart Form
            echo "    <form action='cartFunctions.php' method='post' class='mt-4'>";
            echo "        <input type='hidden' name='action' value='add' />";
            echo "        <input type='hidden' name='product_id' value='$pid' />";
            echo "        <label for='quantity' style='font-size: 16px;'>Quantity:</label>";
            echo "        <input type='number' name='quantity' value='1' min='1' max='10' style='width: 60px; margin-left: 10px; margin-right: 20px;' required />";
            echo "        <button class='btn btn-primary' type='submit' style='background-color: #8d695b; border: none;'>Add to Cart</button>";
            echo "    </form>";
            echo "</div>"; // End of Right Column
        
            echo "</div>"; // End of Row
        }

        $conn->close(); // Close database connection
        ?>
    </div>
    <!-- Footer -->
    <?php include("footer.php"); ?>
</div>