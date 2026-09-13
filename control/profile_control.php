<?php
include "../model/db.php";
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: ../view/login.php");
    exit;
}

$db = new mydb();
$conobj = $db->openConn();

$userResult = $db->findUserById("users", $_SESSION["user_id"], $conobj);
$user = $userResult->fetch_assoc();

// ---- purchase history (Task 4 output) ----
$ordersResult = $db->getOrdersByUser($conobj, $_SESSION["user_id"]);
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
