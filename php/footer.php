<?php
// Include config file
$config = include(__DIR__ . "/../config.php");
?>

<!-- Footer -->
<footer class="text-center text-lg-start bg-body-tertiary text-muted" style="padding:0;">

    <!-- Section: Links  -->
    <section class="footer-color" style="font-family: Poppins;">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <img src="<?= $config->SITE_ROOT ?>/Images/Littlewonders_Logo_png.png" alt="Logo"
                        style="height: 100px; width: auto;">

                    <p>
                        Because Every Baby Is a Little Wonder.
                    </p>
                </div>
                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Product Category
                    </h6>

                

                <!-- Product category links -->
                    <?php
                    // Include the PHP file that establishes database connection handle: $conn
                    include_once("mysql_conn.php");

                    $qry = "SELECT * FROM Category ORDER BY catName ASC"; // SQL to select all categories sorted by category name
                    $result = $conn->query($qry); // Execute the SQL and get the result
                    
                    // Display each category in a row
                    while ($row = $result->fetch_array()) {
                        $catname = urlencode($row["CatName"]);
                        $catproduct = "/ECAD_ASG1/php/catProduct.php?cid=$row[CategoryID]&catName=$catname";
                        $img = "..//Images/Category/$row[CatImage]";

                        echo "<p>"; // Start of card column
                        echo '  <a href="' . $catproduct . '" class="text-reset" style="text-decoration: none;">' . $row["CatName"] . '</a>';
                        echo "  </a>";
                        echo "</p>";
                    }

                    $conn->close(); // Close database connection
                    ?>
                </div>
                <!-- Product category links -->

                

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Useful links
                    </h6>
                    <p>
                        <a href="#!" class="text-reset" style="text-decoration: none;">Shipping</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset" style="text-decoration: none;">Delivery & Returns</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset" style="text-decoration: none;">Help</a>
                    </p>
                    <p>
                        <a href="#!" class="text-reset" style="text-decoration: none;">Privacy Policy</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                    <p><i class="fas fa-home me-3"></i> Singapore, SG 123456, SG</p>
                    <p>
                        <i class="fas fa-envelope me-3"></i>
                        littlewonders@gmail.com
                    </p>
                    <p><i class="fas fa-phone me-3"></i> + 65 6155 4555</p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: #8c685c;
    color: white; font-family: Poppins;">
        littlewonders © 2025. All Rights Reserved.
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->