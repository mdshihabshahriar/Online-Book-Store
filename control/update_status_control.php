<?php
include "../model/db.php";
session_start();
header("Content-Type: application/json");

$response = array("success" => false, "message" => "");

if (empty($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    http_response_code(403);
    $response["message"] = "Admins only.";
    echo json_encode($response);
    exit;
}

$order_id = $_POST["order_id"] ?? "";
$status = $_POST["status"] ?? "";

$allowedStatuses = array("pending", "confirmed", "shipped", "delivered");

if ($order_id === "" || !in_array($status, $allowedStatuses)) {
    $response["message"] = "Invalid order or status.";
    echo json_encode($response);
    exit;
}

$db = new mydb();
$conobj = $db->openConn();

if ($db->updateOrderStatus($conobj, $order_id, $status)) {
    $response["success"] = true;
    $response["message"] = "Order status updated.";
} else {
    $response["message"] = "Could not update status.";
}

echo json_encode($response);
?>
