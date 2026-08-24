<?php

include "../control/cart_page_control.php";

$total = 0;

?>

<!DOCTYPE html>

<html>

<head>

    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/cart.css">

</head>

<body>


<div class="cart-container">

    <h1>Your Cart</h1>


    <?php

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $subtotal =
                $row["price"] * $row["quantity"];

            $total += $subtotal;

    ?>

    <div class="cart-item">

        <img
            src="../<?php echo $row["image_path"]; ?>"
        >

        <div>

            <h3>
                <?php echo htmlspecialchars($row["title"]); ?>
            </h3>

            <p>
                Price:
                ৳<?php echo number_format($row["price"], 2); ?>
            </p>

        </div>


        <div>

            Quantity:

            <input
                type="number"
                class="quantity"
                value="<?php echo $row["quantity"]; ?>"
                min="1"
            >

        </div>


        <div>

            Subtotal:
            ৳<?php echo number_format($subtotal, 2); ?>

        </div>


        <a
            class="remove"
            href="../control/cart_control.php?remove=<?php echo $row["id"]; ?>"
        >
            Remove
        </a>

    </div>


    <?php

        }

    } else {

        echo "<p>Your cart is empty.</p>";

    }

    ?>


    <div class="total">

        Total:
        ৳<?php echo number_format($total, 2); ?>

    </div>


</div>


</body>

</html>