<?php
include "../model/db.php";
session_start();

if (empty($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../view/login.php");
    exit;
}

$db = new mydb();
$conobj = $db->openConn();

$ordersResult = $db->getAllOrders($conobj);
$orders = array();

if ($ordersResult->num_rows > 0) {
    while ($order = $ordersResult->fetch_assoc()) {
        $itemsResult = $db->getOrderItems($conobj, $order["id"]);
        $items = array();
        while ($item = $itemsResult->fetch_assoc()) {
            $items[] = $item;
        }
        $order["items"] = $items;
        $orders[] = $order;
    }
}
?>
