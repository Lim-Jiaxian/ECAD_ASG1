<!-- Elizabeth Tan - S10242919C -->
<?php
session_start();
include("header.php");
include("mysql_conn.php");

if (isset($_SESSION["OrderID"])) {
    // Get Order data from Order ID
    $qry = "SELECT * FROM orderdata WHERE OrderID=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $_SESSION["OrderID"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $order = $result->fetch_array();

    // Calculate estimated date of delivery
    $daysToDeliver = $order["DeliveryMode"] == "Normal" ? 2 : 1;
    $estimatedDeliveryDate = date_format(date_add(
        date_create($order["DateOrdered"]),
        date_interval_create_from_date_string($daysToDeliver . "days")
    ), "d/m/Y");

    // Phone number
    $phoneNo = $order["ShipPhone"] != null ? $order["ShipPhone"] : "Not available";

    // Email
    $email = $order["ShipEmail"] != null ? $order["ShipEmail"] : "Not available";

    // Get ordered items
    $qry = "SELECT * FROM shopcartitem WHERE ShopCartID=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $order["ShopCartID"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    // Put ordered items into table
    $orderDetails = '';
    while ($shopCartItem = $result->fetch_array()) {
        $orderDetails .= "
        <tr>
            <td>$shopCartItem[Name]</td>
            <td>$shopCartItem[Quantity]</td>
        </tr>
        ";
    }

    // Get message if available
    $message = "";
    if ($order["Message"] != null) {
        $message .= "
        <p>Requested message: $order[Message]</p>
        ";
    }

    // Get total
    $qry = "SELECT Total FROM shopcart WHERE ShopCartID=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $order["ShopCartID"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $total = $result->fetch_array()[0];

    echo "<div id='order-confirmation'>
        <h3>Order Number $order[OrderID] Confirmed!</h3>
        <p>Your order details are as follows:</p>
        <div id='order-details'>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    $orderDetails
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total price:</td>
                        <td>$$total</td>
                    </tr>
                </tfoot>
            </table>
            <br />
            $message
        </div>
        <hr />
        <div id='shipping-details'>
            <p><strong>Shipping details:</strong></p

            <!-- Name -->
            <p>Name: $order[ShipName]</p>

            <!-- Address -->
            <p>Address: $order[ShipAddress]</p>
            
            <!-- Phone number -->
            <p>Phone number: $phoneNo</p>

            <!-- Email -->
            <p>Email: $email</p>
            
            <!-- Delivery mode -->
            <p>Delivery mode: $order[DeliveryMode]</p>

            <!-- Estimated date -->
            <p>Order will be delivered by: $estimatedDeliveryDate</p>
        </div>
        <hr />
        <div id='order-confirmation-message'>
            <p>Thank you for shopping with $config->SITE_NAME!</p>
            <a href='$config->SITE_URL/$config->SITE_ROOT' class='redirect-link'>Back to home</a>
        </div>
    </div>";
}

include("footer.php");
?>