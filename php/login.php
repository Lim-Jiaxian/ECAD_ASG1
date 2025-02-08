<?php
// Detect the current session
session_start();
// Include the Page Layout header 
include("header.php");
?>

<!-- Main Content Wrapper -->
<div class="container-fluid d-flex flex-column" style="min-height: 100vh; background-color: #fcfcfc; padding: 0;">
    <!-- Centered Content -->
    <div class="content-area flex-grow-1 d-flex justify-content-center align-items-center" style="padding: 100px 0;">
        <!-- Increased padding for more spacing -->
        <div class="login-form"
            style="width: 80%; max-width: 600px; margin: auto; background: #ffffff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <!-- Create a HTML Form within the container -->
            <form action="checkLogin.php" method="post">
                <!-- 1st row - Header Row -->
                <div class="mb-3 row">
                    <div class="col-sm-12 text-center">
                        <span class="page-title">Member Login</span>
                    </div>
                </div>
                <!-- 2nd row - Entry of email address -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="email" style="color: #8d695b;">
                        Email Address:
                    </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="email" name="email" id="email" required />
                    </div>
                </div>
                <!-- 3rd row - Entry of password -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="password" style="color: #8d695b;">
                        Password:
                    </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="password" name="password" id="password" required />
                    </div>
                </div>
                <!-- 4th row - Login button -->
                <div class='mb-3 row'>
                    <div class='col-sm-12 text-center'>
                        <button class="submit-btn" type='submit'>Login</button>
                        <p style="margin-top: 1rem;">Please sign up if you do not have an account.</p>
                        <p><a href="forgetPassword.php">Forget Password</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <?php include("footer.php"); ?>
</div>