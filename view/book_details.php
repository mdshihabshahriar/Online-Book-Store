<?php

include "../control/book_details_control.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <title>
        <?php echo htmlspecialchars($book["title"]); ?>
    </title>
    <link rel="stylesheet" href="../css/book_details.css">

</head>

<body>


<header class="navbar">

    <div>
        <strong>
            Online Book Store
        </strong>
    </div>

    <div>

        <a href="books.php">
            Books
        </a>

        <a href="cart.php">
            🛒 Cart
        </a>

    </div>

</header>


<div class="details-container">


    <!-- Image -->

    <div class="book-image">

        <img
            src="../<?php echo $book["image_path"]; ?>"
            alt="<?php echo htmlspecialchars($book["title"]); ?>"
        >

    </div>


    <!-- Information -->

    <div class="book-info">

        <h1>
            <?php echo htmlspecialchars($book["title"]); ?>
        </h1>

        <p class="author">

            By
            <?php echo htmlspecialchars($book["author"]); ?>

        </p>

        <p>

            Category:
            <strong>
                <?php echo htmlspecialchars($book["category_name"]); ?>
            </strong>

        </p>


        <p class="description">

            <?php
                echo nl2br(
                    htmlspecialchars($book["description"])
                );
            ?>

        </p>


        <p class="price">

            ৳<?php echo number_format($book["price"], 2); ?>

        </p>


        <p class="stock">

            <?php

            if ($book["stock"] > 0) {

                echo "Available: " . $book["stock"] . " copies";

            } else {

                echo "Out of Stock";

            }

            ?>

        </p>


        <?php if ($book["stock"] > 0) { ?>

        <form
            action="../control/cart_control.php"
            method="POST"
        >

            <input
                type="hidden"
                name="book_id"
                value="<?php echo $book["id"]; ?>"
            >

            <input
                type="number"
                name="quantity"
                value="1"
                min="1"
                max="<?php echo $book["stock"]; ?>"
                class="quantity"
            >

            <button
                type="submit"
                name="add_to_cart"
                class="cart-btn"
            >
                Add to Cart
            </button>

        </form>

        <?php } ?>


    </div>

</div>


</body>

</html>