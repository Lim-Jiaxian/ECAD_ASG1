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
        <h1>Welcome to Little Wonders</h1>
        <p>This is your homepage content.</p>
    </div>

    <!-- Footer -->
    <?php include("php/footer.php"); ?>
</div>