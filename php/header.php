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
    <link rel="stylesheet" href="../css/site.css">

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="<?= $config->SITE_ROOT ?>/css/bootstrap.css" />
    <!-- No css/footer.css file -->
    <!-- <link rel="stylesheet" type="text/css" href="<?= $config->SITE_ROOT ?>/css/footer.css" /> -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet" />
    <!-- MDB -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- 1st Row -->
    <!-- 2nd Row -->
    <div class="row">
        <div class="col-sm-12">
            <?php include("navbar.php"); ?>
        </div>
    </div>
</body>