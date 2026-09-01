<?php

class mydb
{
    function openConn()
    {
        return new mysqli("localhost", "root", "", "online_book_store");
    }

    function getAllBooks($conn)
    {
        $sql = "SELECT books.*, categories.name AS category_name
                FROM books
                INNER JOIN categories
                ON books.category_id = categories.id
                ORDER BY books.id DESC";

        return $conn->query($sql);
    }


    function getBookById($conn, $id)
    {
        $id = (int)$id;

        $sql = "SELECT books.*, categories.name AS category_name
                FROM books
                LEFT JOIN categories
                ON books.category_id = categories.id
                WHERE books.id = $id";

        return $conn->query($sql);
    }

    function searchBooks($conn,$search,$filter)
{
    $search = $conn->real_escape_string($search);

    if($filter=="title"){

        $sql="SELECT books.*, categories.name AS category_name
              FROM books
              INNER JOIN categories
              ON books.category_id = categories.id
              WHERE books.title LIKE '%$search%'
              ORDER BY books.id DESC";
    }

    elseif($filter=="author"){

        $sql="SELECT books.*, categories.name AS category_name
              FROM books
              INNER JOIN categories
              ON books.category_id = categories.id
              WHERE books.author LIKE '%$search%'
              ORDER BY books.id DESC";
    }

    else{

        $sql="SELECT books.*, categories.name AS category_name
              FROM books
              INNER JOIN categories
              ON books.category_id = categories.id
              WHERE categories.name LIKE '%$search%'
              ORDER BY books.id DESC";
    }

    return $conn->query($sql);
}

    // Add to cart
    function addToCart($conn, $book_id, $quantity)
    {
        $book_id = (int)$book_id;
        $quantity = (int)$quantity;

        $check = "SELECT * FROM cart WHERE book_id = $book_id";
        $result = $conn->query($check);

        if ($result->num_rows > 0) {

            $sql = "UPDATE cart
                    SET quantity = quantity + $quantity
                    WHERE book_id = $book_id";

        } else {

            $sql = "INSERT INTO cart (book_id, quantity)
                    VALUES ($book_id, $quantity)";
        }

        return $conn->query($sql);
    }


    // Get cart items
    function getCartItems($conn)
    {
        $sql = "SELECT 
                    cart.id AS cart_id,
                    cart.book_id,
                    cart.quantity,
                    cart.added_at,
                    books.title,
                    books.price,
                    books.image_path,
                    books.stock
                FROM cart
                INNER JOIN books
                ON cart.book_id = books.id
                ORDER BY cart.id DESC";

        return $conn->query($sql);
    }

    // Get total cart value
    function getCartCount($conn)
    {
        $sql = "SELECT SUM(quantity) AS total
                FROM cart";

        $result = $conn->query($sql);

        $row = $result->fetch_assoc();

        return $row["total"] ?? 0;
    }


    // Update quantity
    function updateCart($conn, $cart_id, $quantity)
    {
        $cart_id = (int)$cart_id;
        $quantity = (int)$quantity;

        if ($quantity <= 0) {
            return false;
        }

        $sql = "UPDATE cart
                SET quantity = $quantity
                WHERE id = $cart_id";

        return $conn->query($sql);
    }


    // Remove item
    function removeFromCart($conn, $cart_id)
    {
        $cart_id = (int)$cart_id;

        $sql = "DELETE FROM cart
                WHERE id = $cart_id";

        return $conn->query($sql);
    }
}

?>