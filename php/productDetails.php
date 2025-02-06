<?php
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
            if($row["Offered"] == 1){
                // Products with offer prices
                echo "
                    <div style='
                        background-color: #ffe6e6;
                        border: 2px solid #ff4d4d;
                        color: #ff4d4d;
                        font-family: Poppins;
                        font-weight: bold;
                        font-size: 24px;
                        text-align: center;
                        padding: 10px 20px;
                        margin-top: 20px;
                        border-radius: 10px;
                        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                    '>
                        <i class='fa-solid fa-fire'></i>
                        Product currently on offer
                        <i class='fa-solid fa-fire'></i>
                    </div>
                ";
            }else if ($row["Quantity"] < 1){
                // Products unavailable and out of stock
                echo "
                    <div style='
                        background-color: #ffe6e6;
                        border: 2px solid #ff4d4d;
                        color: #ff4d4d;
                        font-family: Poppins;
                        font-weight: bold;
                        font-size: 24px;
                        text-align: center;
                        padding: 10px 20px;
                        margin-top: 20px;
                        border-radius: 10px;
                        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                    '>
                        <i class='fa-solid fa-ban'></i>
                        Product Unavailable
                    </div>
                ";
            }else{
                // Normal products available for purchase
                echo "
                    <div style='
                        background-color: #d4edda; 
                        border: 2px solid #155724; 
                        color: #155724; 
                        font-family: Poppins;
                        font-weight: bold;
                        font-size: 24px;
                        text-align: center;
                        padding: 10px 20px;
                        margin-top: 20px;
                        border-radius: 10px;
                        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                    '>
                        <i class='fas fa-check-circle'></i>
                        Product Available
                    </div>
                ";
            }
            echo "    <br><p style='font-size: 18px; line-height: 1.8; color: #8d695b;'>Product Description:</p>";
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
            // Product Offer Price
            $offerPrice = $row["OfferedPrice"];

            // Check if the the product is currently on offer
            if($row["Offered"] == 1){
                // Products on offer
                echo "    <form action='cartFunctions.php' method='post' class='mt-4'>";
                echo "        <input type='hidden' name='action' value='add' />";
                echo "        <input type='hidden' name='product_id' value='$pid' />";
                echo "    <h4 style='color: black; font-weight: bold; font-size: 22px; font-family: Poppins; margin-top: 20px;'>Previous Price: <del>S$ $formattedPrice</del></h4>";
                echo '    
                    <h4 style="color: red; font-weight: bold; font-size: 22px; font-family: Poppins; margin-top: 20px;">
                        <i class="fa-solid fa-fire"></i>
                            (<span class="promo-badge">-' . round((1 - $row["OfferedPrice"] / $row["Price"]) * 100) . '%</span>) Offer Price: S$ ' . $offerPrice . ' 
                        <i class="fa-solid fa-fire"></i>
                    </h4><br>';
                echo "        <label for='quantity' style='font-weight: bold; font-size: 18px; font-family: Poppins;'>Quantity:</label>";
                echo "        <input type='number' name='quantity' value='1' min='1' max='10' style='width: 60px; margin-left: 10px; margin-right: 20px;' required />";
                echo "        <button class='btn btn-primary' type='submit' style='background-color: #8d695b; font-size: 16px; font-family: Poppins; border: none;'>Add to Cart <i class='fa-solid fa-cart-arrow-down'></i></button>";
                echo "    </form>";
                echo "</div>"; // End of Right Column
                echo "</div>"; // End of Row

            }else if ($row["Quantity"] < 1){
                // Check for the product's quantity
                // Products unavailable due to out of stock
                echo "    <form action='cartFunctions.php' method='post' class='mt-4'>";
                echo "        <input type='hidden' name='action' value='add' />";
                echo "        <input type='hidden' name='product_id' value='$pid' />";
                echo "    <h4 style='color: black; font-weight: bold; font-size: 22px; font-family: Poppins; margin-top: 20px;'>Price: S$ $formattedPrice</h4>";
                echo "        <h4 style='color: red; font-weight: bold; font-size: 22px; font-family: Poppins; margin-top: 20px;'>Product currently out of stock</h4>";
                echo "    </form>";
                echo "</div>"; // End of Right Column
                echo "</div>"; // End of Row
            }else{
                // Products available
                echo "    <form action='cartFunctions.php' method='post' class='mt-4'>";
                echo "        <input type='hidden' name='action' value='add' />";
                echo "        <input type='hidden' name='product_id' value='$pid' />";
                echo "    <h4 style='color: black; font-weight: bold; font-size: 22px; font-family: Poppins; margin-top: 20px;'>Price: S$ $formattedPrice</h4><br>";
                echo "        <label for='quantity' style='font-weight: bold; font-size: 18px; font-family: Poppins;'>Quantity:</label>";
                echo "        <input type='number' name='quantity' value='1' min='1' max='10' style='width: 60px; margin-left: 10px; margin-right: 20px;' required />";
                echo "        <button class='btn btn-primary' type='submit' style='background-color: #8d695b; font-size: 16px; font-family: Poppins; border: none;'>Add to Cart <i class='fa-solid fa-cart-arrow-down'></i></button>";
                echo "    </form>";
                echo "</div>"; // End of Right Column
                echo "</div>"; // End of Row
            }

        }

        // Closing database connection will be in footer.php
        ?>
    </div>
    <!-- Footer -->
    <?php include("footer.php"); ?>
</div>