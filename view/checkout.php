<?php
include "../control/checkout_control.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Book Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/mycss.css">
</head>
<body>
<?php include "navbar.php"; ?>

<div class="page">
    <h1 class="page-title">Checkout</h1>

    <div class="checkout-layout">

        <div class="panel books-panel">
            <h2>Choose Books</h2>
            <?php if (count($books) === 0): ?>
                <p>No books in stock right now.</p>
            <?php else: ?>
                <div class="book-list">
                    <?php foreach ($books as $index => $book): ?>
                        <div class="book-row" data-book-id="<?php echo (int)$book['id']; ?>" data-price="<?php echo (float)$book['price']; ?>">
                            <div class="book-info">
                                <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
                                <div class="book-author">by <?php echo htmlspecialchars($book['author']); ?></div>
                                <div class="book-price">৳<?php echo number_format($book['price'], 2); ?> <span class="stock">(<?php echo (int)$book['stock']; ?> in stock)</span></div>
                            </div>
                            <div class="qty-control">
                                <button type="button" class="qty-btn qty-minus">−</button>
                                <input type="number" class="qty-input" value="<?php echo $index === 0 ? 1 : 0; ?>" min="0" max="<?php echo (int)$book['stock']; ?>">
                                <button type="button" class="qty-btn qty-plus">+</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="panel payment-panel">
            <h2>Delivery & Payment</h2>
            <form id="checkoutForm">
                <label for="address">Delivery Address</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($user["address"] ?? ""); ?></textarea>
                <p id="address-error" class="error"></p>

                <label>Delivery Location</label>
                <div class="option-row">
                    <label class="pill-label">
                        <input type="radio" name="delivery_location" value="inside" checked> Inside Dhaka (+৳<?php echo $DELIVERY_FEE_INSIDE_DHAKA; ?>)
                    </label>
                    <label class="pill-label">
                        <input type="radio" name="delivery_location" value="outside"> Outside Dhaka (+৳<?php echo $DELIVERY_FEE_OUTSIDE_DHAKA; ?>)
                    </label>
                </div>

                <label>Payment Method</label>
                <div class="option-row">
                    <label class="pill-label"><input type="radio" name="payment_method" value="Credit Card" checked> Credit Card</label>
                    <label class="pill-label"><input type="radio" name="payment_method" value="bKash"> bKash</label>
                    <label class="pill-label"><input type="radio" name="payment_method" value="Rocket"> Rocket</label>
                    <label class="pill-label"><input type="radio" name="payment_method" value="Bank Transfer"> Bank Transfer</label>
                    <label class="pill-label"><input type="radio" name="payment_method" value="Cash on Delivery"> Cash on Delivery</label>
                </div>
                <p id="payment-error" class="error"></p>

                <div id="cardFields" class="payment-fields">
                    <label for="card_number">Card Number (16 digits)</label>
                    <input type="text" id="card_number" name="card_number" maxlength="19" placeholder="1234 5678 9012 3456">
                    <p id="card-error" class="error"></p>
                </div>

                <div id="mobileFields" class="payment-fields" style="display:none;">
                    <label for="mobile_number">Mobile Number (11 digits, e.g. 01XXXXXXXXX)</label>
                    <input type="text" id="mobile_number" name="mobile_number" maxlength="11" placeholder="01XXXXXXXXX">
                    <label for="mobile_pin">PIN (6 digits)</label>
                    <input type="password" id="mobile_pin" name="mobile_pin" maxlength="6" placeholder="••••••">
                    <p id="mobile-error" class="error"></p>
                </div>

                <div class="summary-box">
                    <div class="summary-line"><span>Subtotal</span><span>৳<span id="subtotalDisplay">0.00</span></span></div>
                    <div class="summary-line"><span>Delivery Fee</span><span>৳<span id="deliveryDisplay"><?php echo number_format($DELIVERY_FEE_INSIDE_DHAKA, 2); ?></span></span></div>
                    <div class="summary-line total-line"><span>Total</span><span>৳<span id="totalDisplay"><?php echo number_format($DELIVERY_FEE_INSIDE_DHAKA, 2); ?></span></span></div>
                </div>

                <p id="items-error" class="error"></p>
                <p id="formError" class="error"></p>
                <button type="submit" id="placeOrderBtn">Place Order</button>
            </form>
        </div>

    </div>
</div>

<script>
    const DELIVERY_FEES = { inside: <?php echo $DELIVERY_FEE_INSIDE_DHAKA; ?>, outside: <?php echo $DELIVERY_FEE_OUTSIDE_DHAKA; ?> };
</script>
<script src="../js/myjs.js"></script>
</body>
</html>
