<?php
include "../model/db.php";
session_start();
header("Content-Type: application/json");

$response = array("success" => false, "message" => "");

// ---- auth gate ----
if (empty($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    http_response_code(401);
    $response["message"] = "Please log in as a customer to place an order.";
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION["user_id"];
$address = trim($_POST["address"] ?? "");
$delivery_location = $_POST["delivery_location"] ?? "";
$payment_method = trim($_POST["payment_method"] ?? "");
$items_json = $_POST["items"] ?? "[]";

$allowedPayments = array("Credit Card", "bKash", "Rocket", "Bank Transfer", "Cash on Delivery");
$deliveryFees = array("inside" => 60, "outside" => 120);

// ---- basic validation ----
if ($address === "") {
    $response["message"] = "Address cannot be empty.";
    echo json_encode($response);
    exit;
}

if (!array_key_exists($delivery_location, $deliveryFees)) {
    $response["message"] = "Please select a delivery location.";
    echo json_encode($response);
    exit;
}

if (!in_array($payment_method, $allowedPayments)) {
    $response["message"] = "Please select a valid payment method.";
    echo json_encode($response);
    exit;
}

// ---- payment-method specific validation ----
$paymentDetail = "";

if ($payment_method === "Credit Card") {
    $card_number = preg_replace('/\D/', '', $_POST["card_number"] ?? "");
    if (strlen($card_number) !== 16) {
        $response["message"] = "Card number must be exactly 16 digits.";
        echo json_encode($response);
        exit;
    }
    $paymentDetail = "CARD-" . substr($card_number, -4); // never store the full card number
} elseif ($payment_method === "bKash" || $payment_method === "Rocket") {
    $mobile_number = trim($_POST["mobile_number"] ?? "");
    $mobile_pin = trim($_POST["mobile_pin"] ?? "");
    if (!preg_match('/^01[0-9]{9}$/', $mobile_number)) {
        $response["message"] = "Enter a valid 11-digit BD mobile number (starts with 01).";
        echo json_encode($response);
        exit;
    }
    if (!preg_match('/^[0-9]{6}$/', $mobile_pin)) {
        $response["message"] = "PIN must be exactly 6 digits.";
        echo json_encode($response);
        exit;
    }
    $paymentDetail = strtoupper($payment_method) . "-" . substr($mobile_number, -4); // never store the PIN
} else {
    $paymentDetail = $payment_method;
}

// ---- items ----
$items = json_decode($items_json, true);

if (!is_array($items) || count($items) === 0) {
    $response["message"] = "Please select at least one book.";
    echo json_encode($response);
    exit;
}

$db = new mydb();
$conobj = $db->openConn();

$orderItems = array();
$subtotal = 0;

foreach ($items as $book_id => $quantity) {
    $book_id = (int)$book_id;
    $quantity = (int)$quantity;

    if ($quantity <= 0) {
        continue;
    }

    $bookResult = $db->getBookById($conobj, $book_id);
    if ($bookResult->num_rows === 0) {
        $response["message"] = "One of the selected books no longer exists.";
        echo json_encode($response);
        exit;
    }

    $book = $bookResult->fetch_assoc();

    if ($quantity > $book["stock"]) {
        $response["message"] = "\"" . $book["title"] . "\" only has " . $book["stock"] . " left in stock.";
        echo json_encode($response);
        exit;
    }

    $subtotal += $book["price"] * $quantity;
    $orderItems[] = array(
        "book_id" => $book_id,
        "quantity" => $quantity,
        "unit_price" => $book["price"]
    );
}

if (count($orderItems) === 0) {
    $response["message"] = "Please select at least one book with a quantity.";
    echo json_encode($response);
    exit;
}

$deliveryFee = $deliveryFees[$delivery_location];
$total = $subtotal + $deliveryFee;

// ---- create order ----
$order_id = $db->createOrder($conobj, $user_id, $total, $payment_method);

if (!$order_id) {
    $response["message"] = "Could not create order. Please try again.";
    echo json_encode($response);
    exit;
}

foreach ($orderItems as $item) {
    $db->createOrderItem($conobj, $order_id, $item["book_id"], $item["quantity"], $item["unit_price"]);
    $db->reduceStock($conobj, $item["book_id"], $item["quantity"]);
}

// ---- payment record (simulated gateway; card number / PIN are never stored) ----
$transaction_id = $paymentDetail . "-" . strtoupper(substr(uniqid(), -6));
$db->createPayment($conobj, $order_id, $total, $payment_method, $transaction_id);

$response["success"] = true;
$response["order_id"] = $order_id;
$response["message"] = "Order placed successfully.";
echo json_encode($response);
?>
