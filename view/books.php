<?php
include("../control/books_control.php");
?>

<!DOCTYPE html>
<html>

<head>

<title>Online Book Store</title>

<link rel="stylesheet" href="../css/books.css">

</head>

<body>

<header class="navbar">

    <div class="logo">
        Online Book Store
    </div>

    <div>

        <a href="books.php">Home</a>

        <a href="cart.php">
            Cart(<?php echo $cart_count; ?>)
        </a>

    </div>

</header>


<section class="search-section">

    <h1>Find Your Next Book</h1>

    <div class="search-box">

        <input
            type="text"
            id="mydata"
            placeholder="Search books..."
            onkeyup="myajax()"
        >


        <select id="filter" onchange="myajax()">

            <option value="title">
                Book Name
            </option>

            <option value="author">
                Author
            </option>

            <option value="category">
                Genre
            </option>

        </select>

    </div>

</section>

<section class="books-section">

    <h2>Available Books</h2>

    <div class="book-grid" id="myprint">

        <?php

        while($row=$result->fetch_assoc()){

        ?>

        <div class="book-card">

            <img src="../<?php echo $row["image_path"]; ?>">

            <h3>
                <?php
                echo htmlspecialchars($row["title"]);
                ?>
            </h3>

            <p>
                By
                <?php echo htmlspecialchars($row["author"]); ?>
            </p>

            <p>
                <?php
                echo htmlspecialchars($row["category_name"]);
                ?>
            </p>

            <p class="price">
                ৳<?php echo $row["price"]; ?>
            </p>

            <a
                href="book_details.php?id=<?php echo $row["id"]; ?>"
                class="details-btn"
            >
                Details
            </a>

        </div>

        <?php
        }
        ?>

    </div>

</section>

<script src="../js/myjs.js"></script>

</body>
</html>