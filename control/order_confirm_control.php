<?php
include "../model/db.php";
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: ../view/login.php");
    exit;
}

$order_id = $_GET["order_id"] ?? "";

$db = new mydb();
$conobj = $db->openConn();

$orderResult = $db->getOrderById($conobj, $order_id);

if ($orderResult->num_rows === 0) {
    header("Location: ../view/checkout.php");
    exit;
}

$order = $orderResult->fetch_assoc();

// make sure a customer can only see their own order
if ($order["user_id"] != $_SESSION["user_id"] && $_SESSION["role"] !== "admin") {
    header("Location: ../view/checkout.php");
    exit;
}

$itemsResult = $db->getOrderItems($conobj, $order_id);
$orderItems = array();
if ($itemsResult->num_rows > 0) {
    while ($row = $itemsResult->fetch_assoc()) {
        $orderItems[] = $row;
    }
}
?>
