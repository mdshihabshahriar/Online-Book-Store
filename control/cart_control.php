<?php

include "../model/db.php";

$mydb = new mydb();

$conobj = $mydb->openConn();

// ADD TO CART

if (isset($_POST["add_to_cart"])) {

    $book_id = (int)$_POST["book_id"];
    $quantity = (int)$_POST["quantity"];


    if ($quantity <= 0) {

        die("Quantity must be greater than 0.");

    }

    // Check book exists

    $result = $mydb->getBookById(
        $conobj,
        $book_id
    );


    if (!$result || $result->num_rows == 0) {

        die("Book does not exist.");

    }

    $book = $result->fetch_assoc();

    // Check stock

    if ($quantity > $book["stock"]) {

        die("Not enough stock available.");

    }

    // Add

    if (
        $mydb->addToCart(
            $conobj,
            $book_id,
            $quantity
        )
    ) {

        header("Location: ../view/cart.php");
        exit;

    } else {

        die("Failed to add book to cart.");

    }

}

// UPDATE CART

if (isset($_POST["update_cart"])) {

    $cart_id = (int)$_POST["cart_id"];
    $quantity = (int)$_POST["quantity"];


    if ($quantity <= 0) {

        die("Quantity must be greater than 0.");

    }

    if (
        $mydb->updateCart(
            $conobj,
            $cart_id,
            $quantity
        )
    ) {

        header("Location: ../view/cart.php");
        exit;

    } else {

        die("Failed to update cart.");

    }

}

// REMOVE FROM CART

if (isset($_GET["remove"])) {

    $cart_id = (int)$_GET["remove"];

    if (
        $mydb->removeFromCart(
            $conobj,
            $cart_id
        )
    ) {

        header("Location: ../view/cart.php");
        exit;

    } else {

        die("Failed to remove item.");

    }

}

?>