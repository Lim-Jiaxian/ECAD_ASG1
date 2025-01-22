<?php
// Include config file
$config = include(__DIR__ . "/../config.php");
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> -</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?= $config->SITE_ROOT ?>/css/bootstrap.min.css">
    <!-- Link to compiled Bootstrap JavaScript downloaded -->
    <script src="<?= $config->SITE_ROOT ?>/js/bootstrap.bundle.min.js"></script>
    <!-- Site specific Cascading Stylesheet -->
    <link rel="stylesheet" href="<?= $config->SITE_ROOT ?>/css/site.css">

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/footer.css" />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <!-- 1st Row -->
        <div class="row">
            <div class="col-sm-12">
                <a href="<?= $config->SITE_ROOT ?>/index.php"><img
                        src="<?= $config->SITE_ROOT ?>\Images\Littlewonders_Logo.png" alt="Logo" class="img-fluid"
                        style="height: 125px; width: 125px" /></a>
            </div>
        </div>
        <!-- 2nd Row -->
        <div class="row">
            <div class="col-sm-12">
                <?php include("navbar.php"); ?>
            </div>
        </div>
        <!-- 3rd Row -->
        <div class="row">
            <div class="col-sm-12" style="padding:15px;">
                <!-- define customised content here -->
                <!-- closing of this column and row is in footer.php -->
            </div> <!-- close the column in 3rd Row -->
        </div> <!-- close the 3rd Row -->
    </div> <!-- Close the bootstrap container -->
</body>

</html>