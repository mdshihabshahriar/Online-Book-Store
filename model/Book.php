<?php

require_once "db.php";

function getAllBooks($conn)
{
    $sql = "SELECT * FROM books ORDER BY id DESC";
    return $conn->query($sql);
}

?>