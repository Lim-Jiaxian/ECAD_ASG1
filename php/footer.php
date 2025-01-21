<?php
// Include config file
$config = include(__DIR__ . "/../config.php");
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mamaya e-BookStore</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?= $config->SITE_ROOT ?>/css/bootstrap.min.css">
    <!-- Link to compiled Bootstrap JavaScript downloaded -->
    <script src="<?= $config->SITE_ROOT ?>/js/bootstrap.bundle.min.js"></script>
    <!-- Site specific Cascading Stylesheet -->
    <link rel="stylesheet" href="<?= $config->SITE_ROOT ?>/css/site.css">
</head>

<body>
    <!-- 4th Row -->
    <div class="row">
        <div class="col-sm-12" style="text-align: right; ">
            <hr />
            Do you need help? Please email to:
            <a href="mailto:mamaya@np.edu.sg">mamaya@np.edu.sg</a>
            <p style="font-size:12px">&copy; Copyright by Mamaya Group</p>
        </div>
    </div>
</body>

</html>