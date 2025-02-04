<?php
// Include config file
$config = include(__DIR__ . "/../config.php");

// Display guest welcome message, Login and Registration links when the shopper has yet to login
$content1 = "<span style='color:#8d695b; padding-right: 20px;'>Welcome Guest</span><br />";
// $content2 = "
//              <a class='nav-link' href='" . $config->SITE_ROOT . "/php/register.php'>Sign Up</a>
//              <a class='nav-link' href='" . $config->SITE_ROOT . "/php/login.php'>Login</a>";

$content2 = '
    <ul class="navbar-nav me-auto">
        <li class="nav-item ' . ((basename($_SERVER['PHP_SELF']) == 'register.php') ? 'active' : '') . '">
            <a class="nav-link" href="' . $config->SITE_ROOT . '/php/register.php">Sign Up</a>
        </li>
    </ul>
    <ul class="navbar-nav me-auto">
        <li class="nav-item ' . ((basename($_SERVER['PHP_SELF']) == 'login.php') ? 'active' : '') . '">
            <a class="nav-link" href="' . $config->SITE_ROOT . '/php/login.php">Login</a>
        </li>
    </ul>';
$profile = "";
$cart = "";
$search = "";
$contactus = "";


if (isset($_SESSION["ShopperName"])) {
    // Display a greeting message and logout link after the shopper logs in
    $content1 = "Welcome back, <b>{$_SESSION['ShopperName']}</b>";
    $content2 = '
        <ul class="navbar-nav me-auto"> 
            <li class="nav-item ' . ((basename($_SERVER['PHP_SELF']) == 'logout.php') ? 'active' : '') . '">
                <a class="nav-link" href="' . $config->SITE_ROOT . '/php/logout.php"><i class="fa fa-sign-out-alt" aria-hidden="true"></i></a>
            </li>
        </ul>';

    // Display the number of items in the cart
    if (isset($_SESSION["NumCartItem"])) {
        $cart .= "<a href='" . $config->SITE_ROOT . "/php/shoppingCart.php' style='margin: 0 20px;'>
                    <i class='fa fa-shopping-bag position-relative' aria-hidden='true'>
                        <span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'>
                            {$_SESSION['NumCartItem']}
                        </span>
                    </i>
                  </a>";
    }

    // $search = "<a href='" . $config->SITE_ROOT . "/php/search.php' style='margin: 0 10px;'>
    //             <i class='fa fa-search' aria-hidden='true'></i>
    //        </a>";

    $profile = '
        <ul class="navbar-nav me-auto"> 
            <li class="nav-item ' . ((basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : '') . '">
                <a class="nav-link" href="' . $config->SITE_ROOT . '/php/profile.php"><i class="fa fa-user" aria-hidden="true"></i></a>
            </li>
        </ul>';

    $contactus = "<a class='nav-link' href='" . $config->SITE_ROOT . "/php/contact.php'>Contact us</a>";

}
?>

<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars(dirname($_SERVER['PHP_SELF']) . '/../css/site.php'); ?>">


<header class="header_section">
    <nav class="navbar navbar-expand-lg custom_nav-container" style="padding:0; font-family: Poppins;">
        <div class="container-fluid" style="padding:0;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?= $config->SITE_ROOT ?>/index.php">Home</a>
                    </li>
                    <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?= $config->SITE_ROOT ?>/php/about.php">About us</a>
                    </li>
                    <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'category.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?= $config->SITE_ROOT ?>/php/category.php">Product Categories</a>
                    </li>   
                    <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'search.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?= $config->SITE_ROOT ?>/php/search.php"><i class='fa fa-search' aria-hidden='true'></i></a>
                    </li>        
                </ul>
                <ul class="navbar-nav me-auto">
                    <a class="navbar-brand mx-auto" href="<?= $config->SITE_ROOT ?>/index.php">
                        <img src="<?= $config->SITE_ROOT ?>/Images/Littlewonders_Logo_png.png" alt="Logo"
                            style="height: 100px; width: auto;">
                    </a>
                </ul>

                
                <ul class="navbar-nav me-auto">
                    <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?= $config->SITE_ROOT ?>/php/contact.php">Contact Us</a>
                    </li>
                </ul>                    
                </span>
                <ul class="navbar-nav me-auto">
                    <span class="mr-4 text-center" style="color: #514f4f;"><?= $content1; ?></span>
                </ul>
                <?= $cart; ?>
                <?= $profile; ?>
                <?= $content2; ?>
            </div>
        </div>
    </nav>
</header>