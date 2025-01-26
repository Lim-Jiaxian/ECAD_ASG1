<?php
// Detect the current session
session_start();
// Include config file
$config = include("config.php");
// Include the Page Layout header
include("php/header.php");
?>

<div class="container-fluid d-flex flex-column" style="min-height: 100vh; padding: 0;">
    <!-- Main Content Area -->
    <div class="main-content flex-grow-1" style="padding: 20px;">
        <!--Slider section-->
        <section class="slider_section">
            <div class="slider_container">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="detail-box">
                                            <h1>
                                                Welcome To <br>
                                                GIFTED TREAURES
                                            </h1>
                                            <p>
                                                We are having sales from 1 Feb to 21 Feb!
                                            </p>
                                            <a href="./php/category.php">
                                                Browse shop
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="img-box">
                                            <dotlottie-player
                                                src="https://lottie.host/0391e071-8801-46d8-bbfc-56209cdf7004/HLSdIvxojR.lottie"
                                                background="transparent" speed="1" style="width: auto; height: 500px"
                                                loop autoplay></dotlottie-player>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="detail-box">
                                            <h1>
                                                Not a member yet? <br>
                                                Sign up now!
                                            </h1>
                                            <p>
                                                New item has arrived!
                                            </p>
                                            <a href="register.php">
                                                Sign up
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="img-box">
                                            <img src="https://cdni.iconscout.com/illustration/premium/thumb/sign-up-6333618-5230178.png?f=webp"
                                                alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="carousel_btn-box">
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                            data-slide="prev">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        <img src="images/line.png" alt="" />
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                            data-slide="next">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- end slider section -->
    </div>
    <?php
		// Include the PHP file that establishes database connection handle: $conn
		include_once("./php/mysql_conn.php");

		// SQL statement to retrieve list of offered products
		$qry = "SELECT ProductID, ProductTitle, ProductImage, Price, OfferedPrice, Quantity FROM product WHERE Offered = 1";
		$stmt = $conn->prepare($qry);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

        // Products with offer prices
        echo "
        <div style='
            background-color: #ffe6e6;
            border: 2px solid #ff4d4d;
            color: #ff4d4d;
            font-weight: bold;
            font-size: 24px;
            text-align: center;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        '>
            <i class='fa-solid fa-fire'></i>
            Promotional Products
            <i class='fa-solid fa-fire'></i>
        </div>";
		// Start product grid
		echo "<br><br><div class='row row-cols-1 row-cols-md-3 g-4'>";
		// Display each product as a card
		while ($row = $result->fetch_array()) {
			$product = "./php/productDetails.php?pid=$row[ProductID]";
			$formattedPrice = number_format($row["Price"], 2);
			$img = "./Images/Products/$row[ProductImage]";

			echo "<div class='col'>"; // Start of card column
			echo "  <a href='$product' style='text-decoration: none; color: inherit;'>";
			echo "      <div class='card h-100' style='box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
			echo "          <img src='$img' class='card-img-top' alt='$row[ProductTitle]' style='height: 200px; object-fit: contain;'>";
			echo "          <div class='card-body text-center'>";
			echo "              <h5 class='card-title' style='font-size: 18px; font-weight: bold; color:#8d695b;'>$row[ProductTitle]</h5>";
			echo "              <p class='card-text' style='font-weight:bold; color:black;'><del>S$ $formattedPrice</del></p>";
            echo "              <p class='card-text' style='font-weight:bold; color:red;'>S$ $row[OfferedPrice]</p>";
			echo "          </div>";
			echo "      </div>"; // End of card
			echo "  </a>";
			echo "</div>"; // End of card column
		}
		echo "</div>"; // End of product grid
		$conn->close(); // Close database connection
        echo "<br>";
        // Footer
        include("php/footer.php"); 
	?>
</div>