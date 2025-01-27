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



    </div>
    <?php
    // Footer
    include("php/footer.php");
    ?>
</div>