<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>

<!-- HTML Form to collect search keyword and submit it to the same page in server -->
<div style="width:80%; margin:auto;"> <!-- Container -->
<form name="frmSearch" method="get" action="">
    <br>
    <div class="mb-3 row"> <!-- 1st row -->
        <div class="col-12 col-md-6 offset-md-3 text-center">
            <span class="page-title">Product Search</span>
        </div>
    </div> <!-- End of 1st row -->
    <div class="mb-3 row"> <!-- 2nd row -->
        <label for="keywords" class="col-sm-3 col-form-label"></label>
        <div class="col-sm-6">
            <input class="form-control" name="keywords" id="keywords" type="search" placeholder="Enter details to search for products" required/>
            <input type="radio" id="productCategory" name="searchFilter" value="productCategory" checked="checked" style="accent-color: #8d695b;">
            <label for="productCategory">Product category</label><br>
            <input type="radio" id="productTitleDesc" name="searchFilter" value="productTitleDesc" style="accent-color: #8d695b;">
            <label for="productTitleDesc">Product name or description</label><br>
            <input type="radio" id="productOffer" name="searchFilter" value="productOffer" style="accent-color: #8d695b;">
            <label for="productOffer">Product name or description with offers</label><br>
            <input type="radio" id="productPrice" name="searchFilter" value="productPrice" style="accent-color: #8d695b;">
            <label for="productPrice">Product price lower or equal to</label><br>
            <input type="radio" id="babyGender" name="searchFilter" value="babyGender" style="accent-color: #8d695b;">
            <label for="babyGender">Baby gender (Boy, Girl, Unisex)</label><br>
        </div>
        <div class="col-sm-3">
            <button 
                class="btn btn-sm" 
                type="submit" 
                style="
                    background-color: #8d695b; /* Button background color */
                    color: #f9ece6; /* Button text color */
                    border: 1px solid #8d695b; /* Optional: matching border */
                    padding: 8px 16px; /* Adjust padding for better appearance */
                    font-size: 14px; /* Adjust font size for small button */
                    border-radius: 5px; /* Rounded corners */
                    cursor: pointer; /* Pointer cursor on hover */
                    transition: all 0.3s ease; /* Smooth hover effect */"
                onmouseover="this.style.backgroundColor='#f9ece6'; this.style.color='#8d695b';"
                onmouseout="this.style.backgroundColor='#8d695b'; this.style.color='#f9ece6';">
                Search
            </button>
        </div>
    </div>  <!-- End of 2nd row -->
</form>

<?php
// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 

if (isset($_GET['searchFilter'])) {
    // Get the value of the selected radio button
    $selectedFilter = $_GET['searchFilter'];
    // Search flag to search products
    $searchFlag = false;
    // Search offer flag for offer products
    $searchOfferFlag = false;
    // Check if the product categrory radiobutton is selected
    if ($selectedFilter == 'productCategory'){
        // Contains the keyword entered by shopper, and display them in a table
        $keyword = $_GET['keywords'];
        // SQL statement with a LIKE query to find user input search
        $qry = "SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Offered, p.OfferedPrice FROM product p INNER JOIN catproduct cp ON cp.ProductID = p.ProductID INNER JOIN category c on c.CategoryID = cp.CategoryID WHERE c.CatName LIKE ? ORDER BY c.CatName ASC";
        $stmt = $conn->prepare($qry);
        $likeKeyword = '%'.$keyword.'%';
        $stmt->bind_param("s", $likeKeyword);
        $stmt->execute();
        $result = $stmt->get_result(); 
        // Close statement and connection
        $stmt->close();
        // Closing database connection will be in footer.php

        // Check if there are any results from query
        if ($result->num_rows > 0){
            // Set search flag to true
            $searchFlag = true;
            // Move the search result header above the loop
            echo "<p class='text-center'><b>Showing list of products in " . htmlspecialchars($keyword) . " category</b></p>";
            echo "<br>";
        }else{
            echo "<p class='text-center'><b>No products found in '" . htmlspecialchars($keyword) . "' category</b></p>";
        }
        
    // Check if the product title and description radiobutton is selected
    }else if ($selectedFilter == 'productTitleDesc') {
        // Contains the keyword entered by shopper, and display them in a table
        $keyword = $_GET['keywords'];
        // SQL statement with a LIKE query to find user input search
        $qry = "SELECT ProductID, ProductTitle, ProductImage, Price, Offered, OfferedPrice FROM product WHERE ProductTitle LIKE ? OR ProductDesc LIKE ? ORDER BY ProductTitle ASC";
        //p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity, p.Offered, p.OfferedPrice 
        $stmt = $conn->prepare($qry);
        $likeKeyword = '%'.$keyword.'%';
        $stmt->bind_param("ss", $likeKeyword, $likeKeyword);
        $stmt->execute();
        $result = $stmt->get_result(); 
        // Close statement and connection
        $stmt->close();
        // Closing database connection will be in footer.php

        // Check if there are any results from query
        if ($result->num_rows > 0){
            // Set search flag to true
            $searchFlag = true;
            // Move the search result header above the loop
            echo "<p class='text-center'><b>Showing list of products with " . htmlspecialchars($keyword) . " in the product name or description</b></p>";
            echo "<br>";
        }else{
            echo "<p class='text-center'><b>No products found with '" . htmlspecialchars($keyword) . "' in the product name or description</b></p>";
        }
        
    // Check if the product offer radiobutton is selected
    } else if ($selectedFilter == 'productOffer') {
        // Contains the keyword entered by shopper, and display them in a table
        $keyword = $_GET['keywords'];
        // SQL statement with a LIKE query to find user input search
        $qry = "SELECT ProductID, ProductTitle, ProductImage, Price, Offered, OfferedPrice FROM product WHERE Offered = 1 AND (ProductTitle LIKE ? OR ProductDesc LIKE ?) ORDER BY ProductTitle";
        $stmt = $conn->prepare($qry);
        $likeKeyword = '%'.$keyword.'%';
        $stmt->bind_param("ss", $likeKeyword, $likeKeyword);
        $stmt->execute();
        $result = $stmt->get_result(); 
        // Close statement and connection
        $stmt->close();
        // Closing database connection will be in footer.php

        // Check if there are any results from query
        if ($result->num_rows > 0){
            // Set search flag to true
            $searchFlag = true;
            $searchOfferFlag = true;
            // Move the search result header above the loop
            echo "<p class='text-center'><b>Showing list of offered products with " . htmlspecialchars($keyword) . " in the product name or description</b></p>";
            echo "<br>";
        }else{
            echo "<p class='text-center'><b>No offered products found with '" . htmlspecialchars($keyword) . "' in the product name or description</b></p>";
        }

    // Check if product price radiobutton is selected for search
    } else if ($selectedFilter == 'productPrice') {
        // Check if the product price radiobutton is selected
        // Contains the keyword entered by shopper
        $keyword = $_GET['keywords'];
        // SQL statement to pricees lower or equals to user input search
        $qry = "SELECT ProductID, ProductTitle, ProductImage, Price, Offered, OfferedPrice FROM product WHERE (Price IS NOT NULL AND Price <= ?) OR (OfferedPrice IS NOT NULL AND OfferedPrice <= ?) ORDER BY ProductTitle";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("ii", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result(); 
        // Close statement and connection
        $stmt->close();
        // Closing database connection will be in footer.php

        // Check if the user keyword input is numeric
        if (isset($_GET['keywords']) && is_numeric($_GET['keywords'])){
            // Check if there are any results from query
            if ($result->num_rows > 0){
                // Set search flag to true
                $searchFlag = true;
                // Search result header
                echo "<p class='text-center'><b>Showing list of products less than or equal to price of S$ " . htmlspecialchars($keyword) . "</b></p>";
                echo "<br>";
            }else{
                // No products found that is less than or equal to price keyword
                echo "<p class='text-center'><b>No products found with less than or equal to price of S$ '" . htmlspecialchars($keyword) . "' in the product name or description</b></p>";
            }
        }else{
            // Error message indicating that numeric values were not in keyword
            echo "<p class='text-center'><b>Please enter a numeric price as '" . htmlspecialchars($keyword) . "' is not numeric</b></p>";
        }

    // Check if baby gender radiobutton is selected
    } else if($selectedFilter == 'babyGender'){
        // Check gender keywords and change to match value in database
        if (isset($_GET['keywords']) && in_array(strtolower($_GET['keywords']), ['male', 'boy', 'm'])) {
            $_GET['keywords'] = 'Boy';
        }else if(isset($_GET['keywords']) && in_array(strtolower($_GET['keywords']), ['female', 'girl', 'f'])){
            $_GET['keywords'] = 'Girl';
        }else if(isset($_GET['keywords']) && in_array(strtolower($_GET['keywords']), ['mixed', 'mix', 'both', 'unisex', 'u'])){
            $_GET['keywords'] = 'Unisex';
        }
        // Contains the keyword entered by shopper, and display them in a table
        $keyword = $_GET['keywords'];
        // SQL statement with a LIKE query to find user input search
        $qry = "SELECT * FROM product p INNER JOIN productspec ps on p.ProductID = ps.ProductID WHERE ps.SpecVal LIKE ?";
        $stmt = $conn->prepare($qry);
        $likeKeyword = '%'.$keyword.'%';
        $stmt->bind_param("s", $likeKeyword);
        $stmt->execute();
        $result = $stmt->get_result(); 
        // Close statement and connection
        $stmt->close();
        // Closing database connection will be in footer.php

        // Check if the user keyword input is numeric
        if (isset($_GET['keywords']) && is_numeric($_GET['keywords'])){
            // Error message indicating that numeric values were found in keyword
            echo "<p class='text-center'><b>Please enter a gender (Boy, Girl, Unisex) to search for baby products, input '" . htmlspecialchars($keyword) . "' is not a gender</b></p>";
        }else if (isset($_GET['keywords']) && in_array($_GET['keywords'], ['Boy', 'Girl', 'Unisex'])){
            // Check if the gender keywords were entered above
            if ($result->num_rows > 0){
                // Set search flag to true
                $searchFlag = true;
                // Search result header
                echo "<p class='text-center'><b>Showing list of products with gender ' " . htmlspecialchars($keyword) . "'</b></p>";
                echo "<br>";
            }else{
                // No products found that available for gender
                echo "<p class='text-center'><b>No products available specifically only for gender '" . htmlspecialchars($keyword) . "' at the moment</b></p>";
            }
        }else{
            echo "<p class='text-center'><b>Please enter a gender (Boy, Girl, Unisex) to search for baby products, input '" . htmlspecialchars($keyword) . "' is not a gender</b></p>";
        }
    }

    // Check if search flag is true and dislay products
    if($searchFlag == true && $searchOfferFlag == true){
        // Display only offer products
        // Start product grid
        echo "<div class='row row-cols-1 row-cols-md-3 g-4 row justify-content-center'>";
        // Display results
        while ($row = $result->fetch_array()) {
            if ($result->num_rows > 0) {
                $product = "productDetails.php?pid=$row[ProductID]";
                $formattedPrice = number_format($row["Price"], 2);
                $offerPrice = number_format($row["OfferedPrice"], 2);
                $img = "../Images/Products/$row[ProductImage]";

                echo "
                    <style>
                        .card-hover-effect {
                            transition: all 0.3s ease-in-out; /* Smooth transition */
                        }
                        .card-hover-effect:hover {
                            transform: scale(1.05); /* Expands the card */
                            box-shadow: 0 8px 16px rgba(0,0,0,0.2); /* Adds a stronger shadow */
                        }
                    </style>";

                echo "<div class='col'>"; // Start of card column
                echo "  <a href='$product' style='text-decoration: none; color: inherit;'>";
                echo "      <div class='card h-100 card-hover-effect' style='box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
                echo "          <div class='promo-image'>";
                echo "              <img src='$img' class='card-img-top' alt='$row[ProductTitle]' style='height: 200px; object-fit: contain;'>";
                echo '              <span class="promo-badge">-' . round((1 - $row["OfferedPrice"] / $row["Price"]) * 100) . '%</span>';
                echo "          </div>";
                echo "          <div class='card-body text-center'>";
                echo "              <h5 class='card-title' style='font-size: 18px; font-weight: bold; color:#8d695b; height: 50px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;'>$row[ProductTitle]</h5>";
                echo "              <div style='display: flex; justify-content: center; gap: 10px; align-items: center; min-height: 30px;'>";
                echo "                  <p class='card-text' style='font-family: Poppins; font-weight:bold; color:red; margin: 0;'>S$ $offerPrice</p>";
                echo "                  <p class='card-text' style='font-family: Poppins; font-weight:bold; color:black; margin: 0;'>S$<del> $formattedPrice</del></p>";
                echo "              </div>";
                echo "          </div>";
                echo "      </div>"; // End of card
                echo "  </a>";
                echo "</div>"; // End of card column
            }
        }
    }else if($searchFlag == true){
        // Display both offered and non-offered products
        // Start product grid
        echo "<div class='row row-cols-1 row-cols-md-3 g-4 row justify-content-center'>";
        // Display results
        while ($row = $result->fetch_array()) {
            if ($result->num_rows > 0) {
                // Check if the product has offer
                if($row["Offered"] == 1){
                    $product = "productDetails.php?pid=$row[ProductID]";
                    $formattedPrice = number_format($row["Price"], 2);
                    $offerPrice = number_format($row["OfferedPrice"], 2);
                    $img = "../Images/Products/$row[ProductImage]";

                    echo "
                        <style>
                            .card-hover-effect {
                                transition: all 0.3s ease-in-out; /* Smooth transition */
                            }
                            .card-hover-effect:hover {
                                transform: scale(1.05); /* Expands the card */
                                box-shadow: 0 8px 16px rgba(0,0,0,0.2); /* Adds a stronger shadow */
                            }
                        </style>";

                    echo "<div class='col'>"; // Start of card column
                    echo "  <a href='$product' style='text-decoration: none; color: inherit;'>";
                    echo "      <div class='card h-100 card-hover-effect' style='box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
                    echo "          <div class='promo-image'>";
                    echo "              <img src='$img' class='card-img-top' alt='$row[ProductTitle]' style='height: 200px; object-fit: contain;'>";
                    echo '              <span class="promo-badge">-' . round((1 - $row["OfferedPrice"] / $row["Price"]) * 100) . '%</span>';
                    echo "          </div>";
                    echo "          <div class='card-body text-center'>";
                    echo "              <h5 class='card-title' style='font-size: 18px; font-weight: bold; color:#8d695b; height: 50px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;'>$row[ProductTitle]</h5>";
                    echo "              <div style='display: flex; justify-content: center; gap: 10px; align-items: center; min-height: 30px;'>";
                    echo "                  <p class='card-text' style='font-family: Poppins; font-weight:bold; color:red; margin: 0;'>S$ $offerPrice</p>";
                    echo "                  <p class='card-text' style='font-family: Poppins; font-weight:bold; color:black; margin: 0;'>S$<del> $formattedPrice</del></p>";
                    echo "              </div>";
                    echo "          </div>";
                    echo "      </div>"; // End of card
                    echo "  </a>";
                    echo "</div>"; // End of card column
                }else{
                    // Products with no offer
                    $product = "productDetails.php?pid=$row[ProductID]";
                    $formattedPrice = number_format($row["Price"], 2);
                    $img = "../Images/Products/$row[ProductImage]";

                    echo "
                        <style>
                            .card-hover {
                                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Smooth transition */
                            }
                            .card-hover:hover {
                                transform: scale(1.05); /* Slightly expands the card */
                                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Adds a stronger shadow */
                            }
                        </style>";

                    echo "<div class='col'>"; // Start of card column
                    echo "  <a href='$product' style='text-decoration: none; color: inherit;'>";
                    echo "      <div class='card h-100 card-hover' style='box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
                    echo "          <img src='$img' class='card-img-top' alt='$row[ProductTitle]' style='height: 200px; object-fit: contain;'>";
                    echo "          <div class='card-body text-center'>";
                    echo "              <h5 class='card-title' style='font-size: 18px; font-weight: bold; color:#8d695b; height: 50px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;'>$row[ProductTitle]</h5>";
                    echo "              <div style='display: flex; justify-content: center; gap: 10px; align-items: center; min-height: 30px;'>";
                    echo "                  <p class='card-text' style='font-family: Poppins; font-weight:bold; color:black; margin: 0;'>S$ $formattedPrice</p>";
                    echo "              </div>";
                    echo "          </div>";
                    echo "      </div>"; // End of card
                    echo "  </a>";
                    echo "</div>"; // End of card column
                }
            }
        }
    }
}


echo "</div>"; // End of container
echo "<br><br><br>";
include("footer.php"); // Include the Page Layout footer
?>