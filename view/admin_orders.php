<?php
include "../control/admin_orders_control.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Processing - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/mycss.css">
</head>
<body>
<?php include "navbar.php"; ?>
<div class="page">
    <h1 class="page-title">Order Processing</h1>

    <?php if (count($orders) === 0): ?>
        <p>No orders placed yet.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-card" data-order-id="<?php echo (int)$order["id"]; ?>">
                <div class="order-card-header">
                    <strong>Order #<?php echo (int)$order["id"]; ?></strong>
                    — <?php echo htmlspecialchars($order["customer_name"]); ?>
                    (<?php echo htmlspecialchars($order["email"]); ?>)
                    — <?php echo htmlspecialchars($order["order_date"]); ?>
                </div>
                <table class="cart-table">
                    <tr><th>Book</th><th>Qty</th><th>Unit Price</th></tr>
                    <?php foreach ($order["items"] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item["title"]); ?></td>
                        <td><?php echo (int)$item["quantity"]; ?></td>
                        <td>৳<?php echo number_format($item["unit_price"], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <p><strong>Total: ৳<?php echo number_format($order["total_amount"], 2); ?></strong>
                — Payment: <?php echo htmlspecialchars($order["payment_method"]); ?></p>

                <label>Status:
                    <select class="status-select">
                        <?php foreach (array("pending", "confirmed", "shipped", "delivered") as $s): ?>
                            <option value="<?php echo $s; ?>" <?php echo $s === $order["status"] ? "selected" : ""; ?>>
                                <?php echo ucfirst($s); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button class="update-status-btn">Update Status</button>
                <span class="status-msg"></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script src="../js/myjs.js"></script>
</body>
</html>
