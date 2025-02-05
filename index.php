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
                                                LITTLE WONDERS
                                            </h1>
                                            <p>
                                                Enjoy up to 33% off on all your favorites – shop now and make every
                                                moment magical!
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
                                                background="transparent" speed="1" style="width: 300px; height: 300px"
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
                                                Check out the new products we have!
                                            </p>
                                            <a href="./php/register.php">
                                                Sign up
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="img-box">
                                            <dotlottie-player
                                                src="https://lottie.host/2440f5bf-edc2-40c6-b4f7-d5d291a92829/OQzfHHWQpO.lottie"
                                                background="transparent" speed="1" style="width: 300px; height: 300px"
                                                loop autoplay></dotlottie-player>
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


        <!-- start of promotional products -->

        <!-- end of promotional products -->


        <!-- start of product category section -->
        <section class="categories_section" style="margin: 40px 0;"> <!-- Added margin for spacing -->
            <div class="container">
                <div class="heading_container">
                    <h2 class="section-title"> <!-- Added class for font consistency -->
                        Our Categories
                    </h2>
                </div>
                <div class="row text-center categories">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="category-card"
                            style="background-image: url('https://www.bambini.nz/user/files/babyGrowncutiesforBlogpost.jpg?t=2310121855');">
                            <a href="php/catProduct.php?cid=1&catName=Baby+Clothing">
                                <div class="category-content">
                                    <h6>Baby Clothing</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="category-card"
                            style="background-image: url('https://imgix.theurbanlist.com/content/article/Best-Prams-And-Strollers-Australia_1.jpg?auto=format,compress&w=520&h=390&fit=crop');">
                            <a href="php/catProduct.php?cid=2&catName=Baby+Gear">
                                <div class="category-content">
                                    <h6>Baby Gear</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="category-card"
                            style="background-image: url('https://billieandbyron.com/cdn/shop/files/baby-gifts-brush-comb-set-wooden-unisex-nursery-decor-billie-byron-1.jpg?v=1724289840');">
                            <a href="php/catProduct.php?cid=3&catName=Bathing+and+Grooming">
                                <div class="category-content">
                                    <h6>Bathing and Grooming</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- end of product category section -->

        <!-- start of reviews/feedback -->
        <section class="client_section layout_padding">
            <div class="container">
                <div class="heading_container heading_left">
                    <h2 style="font-weight: bold;">Customer Reviews</h2>
                </div>
            </div>
            <div class="container px-0">
                <div id="customCarousel2" class="carousel carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Include the database connection
                        include_once("php/mysql_conn.php");

                        // Check if connection exists
                        if (!isset($conn)) {
                            die("Database connection not established.");
                        }

                        // Fetch reviews from the database
                        $qry = "SELECT f.*, s.Name FROM Feedback f INNER JOIN Shopper s ON f.ShopperID = s.ShopperID";
                        $result = $conn->query($qry);

                        if ($result->num_rows > 0) {
                            $i = 0;
                            while ($row = $result->fetch_assoc()) {
                                $rank = $row["Rank"];
                                $date = $row["DateTimeCreated"];
                                $dateTime = new DateTime($date);
                                $formattedDate = $dateTime->format("M Y");

                                // Generate stars for the rating
                                $review = str_repeat('<i class="fas fa-star" style="color: yellow;"></i>', $rank);

                                // Display reviews
                                $activeClass = ($i === 0) ? "active" : "";
                                echo '
                                <div class="carousel-item ' . $activeClass . '">
                                    <div class="box">
                                        <div class="client_info">
                                            <div class="client_name">
                                                <h5>' . htmlspecialchars($row["Name"]) . '</h5>
                                                <h6>' . $review . '</h6>
                                            </div>
                                            <i class="fas fa-thumbs-up"></i>
                                        </div>
                                        <p>' . htmlspecialchars($row["Content"]) . '</p>
                                        <p class="fw-bold opacity-50">' . $formattedDate . '</p>
                                    </div>
                                </div>';
                                $i++;
                            }
                        } else {
                            echo '<p>No reviews found.</p>';
                        }
                        ?>
                    </div>

                    <div class="carousel_btn-box">
                        <a class="carousel-control-prev" href="#customCarousel2" role="button" data-slide="prev">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#customCarousel2" role="button" data-slide="next">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- end of reviews/feedback -->
    </div>
    <?php
    // Footer
    include("php/footer.php");
    ?>
</div>