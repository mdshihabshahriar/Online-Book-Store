<?php
include "../control/order_confirm_control.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmed - Book Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/mycss.css">
</head>
<body>
<?php include "navbar.php"; ?>
<div class="page page-narrow">
    <div class="confirmation-box">
        <h1>✅ Order Placed Successfully</h1>
        <p>Order ID: <strong>#<?php echo (int)$order["id"]; ?></strong></p>
        <p>Status: <strong><?php echo htmlspecialchars(ucfirst($order["status"])); ?></strong></p>
        <p>Payment Method: <strong><?php echo htmlspecialchars($order["payment_method"]); ?></strong></p>
        <p>Order Date: <?php echo htmlspecialchars($order["order_date"]); ?></p>

        <table class="cart-table">
            <tr><th>Book</th><th>Qty</th><th>Unit Price</th></tr>
            <?php foreach ($orderItems as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item["title"]); ?></td>
                <td><?php echo (int)$item["quantity"]; ?></td>
                <td>৳<?php echo number_format($item["unit_price"], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3>Total Paid: ৳<?php echo number_format($order["total_amount"], 2); ?></h3>

        <a href="profile.php" class="btn">View Purchase History</a>
    </div>
</div>
</body>
</html>
