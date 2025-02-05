<?php
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>

<!-- Create a container for the centered layout -->
<div
    style="width:60%; margin:auto; margin-top:50px; margin-bottom:50px; padding:30px; background-color:#f9ece6; border-radius:10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <!-- Display Page Header -->
    <div class="row mb-4 text-center"> <!-- Centered header row -->
        <div class="col-12">
            <h2 class="page-title">About Little Wonders</h2>
            <p class="text-muted">Online shop that offers a wide range of baby products designed to meet the needs of both parents and their little ones. From soft, comfortable baby clothing to essential bathing and grooming items, the store ensures that every product is gentle on your baby's skin and practical for daily use. In addition, a variety of strollers are available, offering comfort, safety, and convenience for parents.</p>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>