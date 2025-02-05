<?php
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Create a container, 80% width of viewport -->
<div class="container-fluid d-flex flex-column" style="min-height: 100vh;">
	<!-- Centered Content with Enhanced Spacing -->
	<div class="content-area flex-grow-1" style="width:80%; margin:auto; margin-top:80px; margin-bottom:80px; background-color:#f9ece6; padding:30px; border-radius:10px;">
		<!-- Display Page Header - Category's name -->
		<div class="row text-center mb-5">
			<div class="col-12">
				<h2 class="page-title" style="font-size: 24px; font-weight: bold;"><?php echo "$_GET[catName]"; ?></h2>
				<p class="text-muted">Select an item listed below to view more</p>
			</div>
		</div>

		<?php
		// Include the PHP file that establishes database connection handle: $conn
		include_once("mysql_conn.php");

		$cid = $_GET["cid"]; // Read Category ID from query string
		// SQL to retrieve list of products associated with the Category ID sorted by ProductTitle
		$qry = "SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity 
                FROM CatProduct cp 
                INNER JOIN product p ON cp.ProductID = p.ProductID 
                WHERE cp.CategoryID = ? ORDER BY p.ProductTitle ASC";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("i", $cid); // "i" - integer
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		// Start product grid
		echo "<div class='row row-cols-1 row-cols-md-3 g-4'>";

		// Display each product as a card
		while ($row = $result->fetch_array()) {
			$product = "productDetails.php?pid=$row[ProductID]";
			$formattedPrice = number_format($row["Price"], 2);
			$img = "../Images/Products/$row[ProductImage]";

			echo "<div class='col'>"; // Start of card column
			echo "  <a href='$product' style='text-decoration: none; color: inherit;'>";
			echo "      <div class='card h-100' style='box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
			echo "          <img src='$img' class='card-img-top' alt='$row[ProductTitle]' style='height: 200px; object-fit: contain;'>";
			echo "          <div class='card-body text-center'>";
			echo "              <h5 class='card-title' style='font-size: 18px; font-weight: bold; color:#8d695b;'>$row[ProductTitle]</h5>";
			echo "              <p class='card-text' style='font-weight:bold; color:black;'>S$ $formattedPrice</p>";
			echo "          </div>";
			echo "      </div>"; // End of card
			echo "  </a>";
			echo "</div>"; // End of card column
		}

		echo "</div>"; // End of product grid
		
		// Closing database connection will be in footer.php
		?>
	</div>
	<!-- Footer -->
	<?php include("footer.php"); ?>
</div>