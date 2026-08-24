<?php

include "../control/cart_page_control.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/cart.css">

</head>


<body>

<!-- Navbar -->

<header class="navbar">

    <div>
        <strong>Online Book Store</strong>
    </div>

    <div>

        <a href="books.php">
            Books
        </a>

        <a href="cart.php">
            🛒 Cart (<?php echo $cart_count; ?>)
        </a>

    </div>

</header>


<div class="cart-container">

    <h1>Your Shopping Cart</h1>


    <?php

    $total = 0;


    if ($result && $result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $subtotal =
                $row["price"] * $row["quantity"];

            $total += $subtotal;

    ?>


        <div class="cart-item">


            <!-- Book Image -->

            <img
                src="../<?php echo htmlspecialchars($row["image_path"]); ?>"
                alt="<?php echo htmlspecialchars($row["title"]); ?>"
            >


            <!-- Book Information -->

            <div class="book-info">

                <h3>
                    <?php
                    echo htmlspecialchars($row["title"]);
                    ?>
                </h3>

                <p class="price">

                    ৳<?php
                    echo number_format(
                        $row["price"],
                        2
                    );
                    ?>

                </p>

            </div>


            <!-- Quantity -->

            <form
                class="quantity-form"
                action="../control/cart_control.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="cart_id"
                    value="<?php echo $row["cart_id"]; ?>"
                >

                <input
                    type="number"
                    name="quantity"
                    value="<?php echo $row["quantity"]; ?>"
                    min="1"
                    max="<?php echo $row["stock"]; ?>"
                >

                <button
                    type="submit"
                    name="update_cart"
                    class="update-btn"
                >
                    Update
                </button>

            </form>


            <!-- Subtotal -->

            <div class="subtotal">

                ৳<?php
                echo number_format(
                    $subtotal,
                    2
                );
                ?>

            </div>


            <!-- Remove -->

            <a
                href="../control/cart_control.php?remove=<?php echo $row["cart_id"]; ?>"
                class="remove-btn"
            >
                Remove
            </a>


        </div>


    <?php

        }

    ?>

        <div class="total">

            Total:
            ৳<?php
            echo number_format($total, 2);
            ?>

        </div>


    <?php

    } else {

    ?>

        <div class="empty-cart">

            <h2>
                Your cart is empty
            </h2>

            <p>
                Add some books to your cart first.
            </p>

            <a
                href="books.php"
                class="continue-btn"
            >
                Browse Books
            </a>

        </div>

    <?php

    }

    ?>


</div>


</body>

</html>