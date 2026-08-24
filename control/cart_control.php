<?php

include "../model/db.php";

$mydb = new mydb();

$conobj = $mydb->openConn();


if (isset($_POST["add_to_cart"])) {

    $book_id = $_POST["book_id"];

    $quantity = $_POST["quantity"];


    if (!is_numeric($book_id) || !is_numeric($quantity)) {

        die("Invalid input.");

    }


    if ($quantity <= 0) {

        die("Quantity must be positive.");

    }


    $result = $mydb->getBookById(
        $conobj,
        $book_id
    );


    if ($result->num_rows == 0) {

        die("Book does not exist.");

    }


    $book = $result->fetch_assoc();


    if ($quantity > $book["stock"]) {

        die("Not enough stock available.");

    }


    // Add to cart

    if (
        $mydb->addToCart(
            $conobj,
            $book_id,
            $quantity
        )
    ) {

        header("Location: ../view/cart.php");

    } else {

        echo "Failed to add book to cart.";

    }

}

?>