<?php

include "../model/db.php";

$mydb = new mydb();

$conobj = $mydb->openConn();

$cart_count = $mydb->getCartCount($conobj);

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $result = $mydb->getBookById(
        $conobj,
        $id
    );

    if ($result->num_rows > 0) {

        $book = $result->fetch_assoc();

    } else {

        die("Book not found.");

    }

} else {

    die("Book ID is missing.");

}

?>