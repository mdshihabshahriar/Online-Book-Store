<?php

include "../control/books_control.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <title>Online Book Store</title>
    <link rel="stylesheet" href="../css/books.css">

</head>

<body>


<!-- Navbar -->

<header class="navbar">

    <div class="logo">
        Online Book Store
    </div>

    <div>

        <a href="books.php">
            Home
        </a>

        <a href="cart.php" class="cart">
            🛒 Cart (<?php echo $cart_count; ?>)
        </a>

    </div>

</header>


<!-- Search -->

<section class="search-section">

    <h1>Find Your Next Book</h1>

    <form method="GET">

        <div class="search-box">

            <input
                type="text"
                name="search"
                placeholder="Search books..."
                value="<?php
                    if (isset($_GET["search"])) {
                        echo htmlspecialchars($_GET["search"]);
                    }
                ?>"
            >

            <select name="filter">

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

            <button type="submit">
                Search
            </button>

        </div>

    </form>

</section>


<!-- Books -->

<section class="books-section">

    <h2>Available Books</h2>

    <div class="book-grid">

        <?php

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

        ?>

        <div class="book-card">

            <img
                src="../<?php echo $row["image_path"]; ?>"
                alt="<?php echo htmlspecialchars($row["title"]); ?>"
            >

            <h3>
                <?php echo htmlspecialchars($row["title"]); ?>
            </h3>

            <p class="author">
                By <?php echo htmlspecialchars($row["author"]); ?>
            </p>

            <p class="category">
                <?php echo htmlspecialchars($row["category_name"]); ?>
            </p>

            <p class="price">
                ৳<?php echo number_format($row["price"], 2); ?>
            </p>

            <p class="stock">

                <?php

                if ($row["stock"] > 0) {

                    echo "In Stock: " . $row["stock"];

                } else {

                    echo "Out of Stock";

                }

                ?>

            </p>


            <a
                class="details-btn"
                href="book_details.php?id=<?php echo $row["id"]; ?>"
            >
                Details
            </a>


            <?php if ($row["stock"] > 0) { ?>

                <form
                    action="../control/cart_control.php"
                    method="POST"
                    style="display:inline;"
                >

                    <input
                        type="hidden"
                        name="book_id"
                        value="<?php echo $row["id"]; ?>"
                    >

                    <input
                        type="hidden"
                        name="quantity"
                        value="1"
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

        <?php

            }

        } else {

        ?>

            <div class="no-books">

                <h3>
                    No books found.
                </h3>

            </div>

        <?php } ?>

    </div>

</section>


</body>

</html>