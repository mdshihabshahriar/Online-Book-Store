<?php

class mydb
{
    function openConn()
    {
        return new mysqli("localhost", "root", "", "online_book_store");
    }

    // Get all books
    function getAllBooks($conn)
    {
        $sql = "SELECT books.*, categories.name AS category_name
                FROM books
                LEFT JOIN categories
                ON books.category_id = categories.id
                ORDER BY books.id DESC";

        return $conn->query($sql);
    }

    // Get single book by ID
    function getBookById($conn, $id)
    {
        $sql = "SELECT books.*, categories.name AS category_name
                FROM books
                LEFT JOIN categories
                ON books.category_id = categories.id
                WHERE books.id = '$id'";

        return $conn->query($sql);
    }

    // Search books
    function searchBooks($conn, $search, $filter)
    {
        $search = $conn->real_escape_string($search);

        if ($filter == "author") {

            $sql = "SELECT books.*, categories.name AS category_name
                    FROM books
                    LEFT JOIN categories
                    ON books.category_id = categories.id
                    WHERE books.author LIKE '%$search%'";

        } elseif ($filter == "category") {

            $sql = "SELECT books.*, categories.name AS category_name
                    FROM books
                    LEFT JOIN categories
                    ON books.category_id = categories.id
                    WHERE categories.name LIKE '%$search%'";

        } else {

            $sql = "SELECT books.*, categories.name AS category_name
                    FROM books
                    LEFT JOIN categories
                    ON books.category_id = categories.id
                    WHERE books.title LIKE '%$search%'";
        }

        return $conn->query($sql);
    }


    // Add book to cart
    function addToCart($conn, $book_id, $quantity)
    {
        // Check whether book already exists in cart
        $check = "SELECT * FROM cart WHERE book_id = '$book_id'";
        $result = $conn->query($check);

        if ($result->num_rows > 0) {

            $sql = "UPDATE cart
                    SET quantity = quantity + $quantity
                    WHERE book_id = '$book_id'";

        } else {

            $sql = "INSERT INTO cart (book_id, quantity)
                    VALUES ('$book_id', '$quantity')";
        }

        return $conn->query($sql);
    }


    // Get cart items
    function getCartItems($conn)
    {
        $sql = "SELECT cart.*, books.title, books.price, books.image_path
                FROM cart
                INNER JOIN books
                ON cart.book_id = books.id
                ORDER BY cart.id DESC";

        return $conn->query($sql);
    }


    // Remove cart item
    function removeFromCart($conn, $id)
    {
        $sql = "DELETE FROM cart WHERE id = '$id'";

        return $conn->query($sql);
    }


    // Update cart quantity
    function updateCart($conn, $id, $quantity)
    {
        $sql = "UPDATE cart
                SET quantity = '$quantity'
                WHERE id = '$id'";

        return $conn->query($sql);
    }
}

?>