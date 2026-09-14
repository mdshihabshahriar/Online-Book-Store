<?php
// Cart add/remove is Task 3's job. Since this project only demos Task 4,
// the checkout page lets the customer pick books straight from the
// catalog here, so there's always something to purchase for a demo.

include "../model/db.php";
session_start();

if (empty($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    header("Location: ../view/login.php");
    exit;
}

$db = new mydb();
$conobj = $db->openConn();

$userResult = $db->findUserById("users", $_SESSION["user_id"], $conobj);
$user = $userResult->fetch_assoc();

$booksResult = $db->getAvailableBooks($conobj);
$books = array();
if ($booksResult->num_rows > 0) {
    while ($row = $booksResult->fetch_assoc()) {
        $books[] = $row;
    }
}

$DELIVERY_FEE_INSIDE_DHAKA = 60;
$DELIVERY_FEE_OUTSIDE_DHAKA = 120;
?>
