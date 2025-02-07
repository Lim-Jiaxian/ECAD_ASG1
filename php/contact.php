<?php
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST["message"]) && !empty($_POST["email"])) {
        $_SESSION["alert"] = "<div class='d-flex align-items-center alert alert-success alert-dismissible' role='alert' style='margin: 16px 0 0 0; height: 64px; padding: 0.75rem 1rem;'>
            <div style='align:middle;'>Form has been submitted successfully!</div>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
}

if (isset($_SESSION["alert"])) {
    $alert = $_SESSION["alert"];
} else {
    $alert = "";
}
unset($_SESSION["alert"]);
?>

<!-- Create a container for the centered layout -->
<div
    style="width:fit-content; max-width:800px; margin:auto; margin-top:50px; margin-bottom:50px; padding:3rem 8rem; background-color:#f9ece6; border-radius:10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <!-- Display Page Header -->
    <div class="row text-center"> <!-- Centered header row -->
        <div class="col-12">
            <h2 class="page-title">Contact Little Wonders Support</h2>
            <p class="text-muted">You can reach out to us via the following:</p>
            <p>Phone: +65 6155 4555</p>
            <p>Email: littlewonders@gmail.com</p>
            <p class="text-muted">OR</p>
            <form class="contact-form" method="POST">
                <label for="form-input" class="form-label">Send us a message!</label>
                <input type="text" name="email" class="form-control" placeholder="Your email" style="margin-bottom:5px">
                <textarea id="form-input" name="message" class="form-control" rows="3" cols="10" placeholder="Your message"></textarea>
                <button type="submit" class="submit-btn" id="liveAlertBtn">Submit</button>
            </form>
            <?= $alert ?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>