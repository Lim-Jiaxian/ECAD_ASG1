<?php 
// Display guest welcome message, Login and Registration links
// when shopper has yet to login,
$content1 = "<span style='color:#EDC9AF;'>Welcome Guest</span><br />";
$content2 = "<li class='nav-item'>
		     <a class='nav-link' href='./php/register.php'>Sign Up</a></li>
			 <li class='nav-item'>
		     <a class='nav-link' href='./php/login.php'>Login</a></li>";

if(isset($_SESSION["ShopperName"])) { 
	// To Do 1 (Practical 2) - 
    // Display a greeting message, Change Password and logout links 
    // after shopper has logged in.
	
    $content1 = "Welcome <b>$_SESSION[ShopperName]</b>"; 
    $content2 = "<li class='nav-item'>
                <a class='nav-link' href='./php/changePassword.php'>Change Password</a></li> 
                <li class='nav-item'>
                <a class='nav-link' href='./php/logout.php'>Logout</a></li>";
	// To Do 2 (Practical 4) - 
    // Display number of item in cart
	if (isset($_SESSION["NumCartItem"]))
    {
        $content1 .= ",$_SESSION[NumCartItem] item(s) in shopping cart";
    }
}
?>

<style>
    <?php
        // Link CSS
        include("../css/site.css");
    ?>
</style>

<!-- To Do 3 (Practical 1) - Display a navbar which is visible before or after collapsing -->
<div class="bg-custom">
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container-fluid">
            <!-- Dynamic Text Display -->
            <span class="navbar-text ms-md-2" style="color:#F7BE81; max-width: 80%;">
                <?php echo $content1; ?>
            </span>
            <!-- Toggler/Collapsibe Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</div>
 
<!-- To Do 4 (Practical 1) - Define a collapsible navbar -->

<div class="bg-custom">
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container-fluid">
            <!-- Collapsible part of navbar -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar"> 
                <!-- Left-justified menu items -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item" >
                        <a class="nav-link" href="category.php">Product Categories</a> 
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" href="search.php">Product Search</a> 
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" href="shoppingCart.php">Shopping Cart</a> 
                    </li>
                </ul>
                <!-- Right-justified menu items -->
                <ul class="navbar-nav ms-auto">
                    <?php echo $content2; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>