<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title> -</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Link to compiled Bootstrap JavaScript downloaded -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- Site specific Cascading Stylesheet -->
<link rel="stylesheet" href="css/site.css"> 
</head>
<body>
    <div class="container">
        <!-- 1st Row -->
        <div class="row">
            <div class="col-sm-12">
                <a href="index.php"><img src="Images/" alt="Logo" class="img-fluid" style="width: 100%"/></a>
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
            </div>  <!-- close the column in 3rd Row -->   
        </div>   <!-- close the 3rd Row -->
    </div>   <!-- Close the bootstrap container -->
</body>
</html>