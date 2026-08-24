<?php

include "../model/db.php";

$mydb = new mydb();

$conobj = $mydb->openConn();

$cart_count = $mydb->getCartCount($conobj);

// Search
if (isset($_GET["search"]) && !empty($_GET["search"])) {

    $search = $_GET["search"];

    if (isset($_GET["filter"])) {
        $filter = $_GET["filter"];
    } else {
        $filter = "title";
    }

    $result = $mydb->searchBooks(
        $conobj,
        $search,
        $filter
    );

// Show all books
} else {

    $result = $mydb->getAllBooks($conobj);
}

?>