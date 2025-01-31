<!-- Elizabeth Tan - S10242919C -->
<?php
session_start();
include_once("myPayPal.php");
include_once("mysql_conn.php");
$config = include("../config.php");
if ($_POST) {
    $hasError = false;
    echo $hasError;
    $cartErrorHtml = "";
    foreach ($_SESSION['Items'] as $key => $item) {
        $qry = "SELECT Quantity FROM product WHERE ProductID=?";
        $stmt = $conn->prepare(query: $qry);
        $stmt->bind_param("i", $item["productId"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                if ($row["Quantity"] < $item["quantity"]) {
                    $hasError = true;
                    $cartErrorHtml .= "
                    <div class='cart-error-item'>
                    <p class='cart-error-item-name'>$item[name]</p>
                    <p>Product ID: $item[productId]</p>
                    <p>Ordered: $item[quantity]</p>
                    <p>Remaining: $row[Quantity]</p>
                    <hr>
                    </div>";
                }
            }
        }
    }

    if ($hasError == true) {
        include("header.php");
        echo "
        <div id='cart-error'>
            <p>The following items are out of stock:</p>
            $cartErrorHtml
            <p>Please edit your order.</p>
            <a href='$config->SITE_URL/$config->SITE_ROOT/php/shoppingCart.php' class='redirect-link'>⬅ Return to shopping cart</a>
        </div>
        ";
        include("footer.php");
        $hasError = false;
        exit;
    };

    $paypal_data = '';
    foreach ($_SESSION['Items'] as $key => $item) {
        $paypal_data .= '&L_PAYMENTREQUEST_0_QTY' . $key . '=' . urlencode($item["quantity"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT' . $key . '=' . urlencode($item["price"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME' . $key . '=' . urlencode($item["name"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER' . $key . '=' . urlencode($item["productId"]);
    }

    //Data to be sent to PayPal
    $padata = '&CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
        '&PAYMENTACTION=Sale' .
        '&ALLOWNOTE=1' .
        '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
        '&PAYMENTREQUEST_0_AMT=' . urlencode($_SESSION["SubTotal"] +
            $_SESSION["Tax"] +
            $_SESSION["ShipCharge"]) .
        '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($_SESSION["SubTotal"]) .
        '&PAYMENTREQUEST_0_SHIPPINGAMT=' . urlencode($_SESSION["ShipCharge"]) .
        '&PAYMENTREQUEST_0_TAXAMT=' . urlencode($_SESSION["Tax"]) .
        '&BRANDNAME=' . urlencode($config->SITE_NAME) .
        $paypal_data .
        '&RETURNURL=' . urlencode($PayPalReturnURL) .
        '&CANCELURL=' . urlencode($PayPalCancelURL);

    $httpParsedResponseAr = PPHttpPost(
        'SetExpressCheckout',
        $padata,
        $PayPalApiUsername,
        $PayPalApiPassword,
        $PayPalApiSignature,
        $PayPalMode
    );

    //Respond according to received from Paypal
    if (
        "SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) ||
        "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])
    ) {
        if ($PayPalMode == 'sandbox')
            $paypalmode = '.sandbox';
        else
            $paypalmode = '';

        //Redirect user to PayPal store with Token received.
        $paypalurl = 'https://www' . $paypalmode .
            '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' .
            $httpParsedResponseAr["TOKEN"] . '';
        header('Location: ' . $paypalurl);
    } else {
        //Show error message
        echo "<div style='color:red'><b>SetExpressCheckOut failed : </b>" .
            urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . "</div>";
        echo "<pre>" . print_r($httpParsedResponseAr) . "</pre>";
        echo "<p>AMT: $_SESSION[SubTotal] +
            $_SESSION[Tax] +
            $_SESSION[ShipCharge]</p>";
        echo "<p>SubTotal: $_SESSION[SubTotal]</p>";
        echo "<p>Tax: $_SESSION[Tax]</p>";
        echo "<p>Ship: $_SESSION[ShipCharge]</p>";
    }
}

if (isset($_GET["token"]) && isset($_GET["PayerID"])) {
    $token = $_GET["token"];
    $playerid = $_GET["PayerID"];
    $paypal_data = '';

    foreach ($_SESSION['Items'] as $key => $item) {
        $paypal_data .= '&L_PAYMENTREQUEST_0_QTY' . $key . '=' . urlencode($item["quantity"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT' . $key . '=' . urlencode($item["price"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME' . $key . '=' . urlencode($item["name"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER' . $key . '=' . urlencode($item["productId"]);
    }

    //Data to be sent to PayPal
    $padata = '&TOKEN=' . urlencode($token) .
        '&PAYERID=' . urlencode($playerid) .
        '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
        $paypal_data .
        '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($_SESSION["SubTotal"]) .
        '&PAYMENTREQUEST_0_TAXAMT=' . urlencode($_SESSION["Tax"]) .
        '&PAYMENTREQUEST_0_SHIPPINGAMT=' . urlencode($_SESSION["ShipCharge"]) .
        '&PAYMENTREQUEST_0_AMT=' . urlencode($_SESSION["SubTotal"] +
            $_SESSION["Tax"] +
            $_SESSION["ShipCharge"]) .
        '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode);

    $httpParsedResponseAr = PPHttpPost(
        'DoExpressCheckoutPayment',
        $padata,
        $PayPalApiUsername,
        $PayPalApiPassword,
        $PayPalApiSignature,
        $PayPalMode
    );

    if (
        "SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) ||
        "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])
    ) {
        foreach ($_SESSION['Items'] as $key => $item) {
            $qry = "UPDATE product SET Quantity=GREATEST(Quantity-?, 0) WHERE ProductID=?";
            $stmt = $conn->prepare($qry);
            $stmt->bind_param("ii", $item["quantity"], $item["productId"]);
            $stmt->execute();
            $stmt->close();
        }

        $_SESSION["Total"] = $_SESSION["SubTotal"] + $_SESSION["Tax"] + $_SESSION["ShipCharge"];
        $qry = "UPDATE shopcart SET OrderPlaced=1, Quantity=?, SubTotal=?, ShipCharge=?, Tax=?, Total=? WHERE ShopCartID=?";
        $stmt = $conn->prepare(query: $qry);
        $stmt->bind_param(
            "iddddi",
            $_SESSION["NumCartItem"],
            $_SESSION["SubTotal"],
            $_SESSION["ShipCharge"],
            $_SESSION["Tax"],
            $_SESSION["Total"],
            $_SESSION["Cart"],
        );
        $stmt->execute();
        $stmt->close();

        // Get customer's PayPal information
        $transactionID = urlencode(
            $httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]
        );
        $nvpStr = "&TRANSACTIONID=" . $transactionID;
        $httpParsedResponseAr = PPHttpPost(
            'GetTransactionDetails',
            $nvpStr,
            $PayPalApiUsername,
            $PayPalApiPassword,
            $PayPalApiSignature,
            $PayPalMode
        );

        if (
            "SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) ||
            "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])
        ) {
            $ShipName = addslashes(urldecode($httpParsedResponseAr["SHIPTONAME"]));

            $ShipAddress = urldecode($httpParsedResponseAr["SHIPTOSTREET"]);
            if (isset($httpParsedResponseAr["SHIPTOSTREET2"]))
                $ShipAddress .= ' ' . urldecode($httpParsedResponseAr["SHIPTOSTREET2"]);
            if (isset($httpParsedResponseAr["SHIPTOCITY"]))
                $ShipAddress .= ' ' . urldecode($httpParsedResponseAr["SHIPTOCITY"]);
            if (isset($httpParsedResponseAr["SHIPTOSTATE"]))
                $ShipAddress .= ' ' . urldecode($httpParsedResponseAr["SHIPTOSTATE"]);
            $ShipAddress .= ' ' . urldecode($httpParsedResponseAr["SHIPTOCOUNTRYNAME"]) .
                ' ' . urldecode($httpParsedResponseAr["SHIPTOZIP"]);

            $ShipCountry = urldecode(
                $httpParsedResponseAr["SHIPTOCOUNTRYNAME"]
            );

            $ShipEmail = urldecode($httpParsedResponseAr["EMAIL"]);

            $qry = "INSERT INTO orderdata (ShipName, ShipAddress, ShipCountry, ShipEmail, ShopCartID, DeliveryMode) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($qry);
            $stmt->bind_param(
                "ssssis",
                $ShipName,
                $ShipAddress,
                $ShipCountry,
                $ShipEmail,
                $_SESSION["Cart"],
                $_SESSION["DeliveryMode"]
            );
            $stmt->execute();
            $stmt->close();
            $qry = "SELECT LAST_INSERT_ID() AS OrderID";
            $result = $conn->query($qry);
            $row = $result->fetch_array();
            $_SESSION["OrderID"] = $row["OrderID"];

            $conn->close();

            $_SESSION["NumCartItem"] = 0;

            unset($_SESSION["Cart"]);
            unset($_SESSION["Tax"]);
            unset($_SESSION["ShipCharge"]);
            unset($_SESSION["SubTotal"]);
            unset($_SESSION["Total"]);
            unset($_SESSION["DeliveryMode"]);

            header("Location: orderConfirmed.php");
            exit;
        } else {
            echo "<div style='color:red'><b>GetTransactionDetails failed:</b>" .
                urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
            echo "<pre>" . print_r($httpParsedResponseAr) . "</pre>";
            $conn->close();
        }
    } else {
        echo "<div style='color:red'><b>DoExpressCheckoutPayment failed : </b>" .
            urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
        echo "<pre>" . print_r($httpParsedResponseAr) . "</pre>";
    }
}

include("footer.php");
