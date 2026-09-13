<?php
include "../control/profile_control.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile - Book Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/mycss.css">
</head>
<body>
<?php include "navbar.php"; ?>
<div class="page">
    <h1 class="page-title">My Profile</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user["name"]); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($user["address"]); ?></p>

    <h2>Purchase History</h2>

    <?php if (count($orders) === 0): ?>
        <p>No orders yet.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <div class="order-card-header">
                    <strong>Order #<?php echo (int)$order["id"]; ?></strong>
                    — <span class="status status-<?php echo htmlspecialchars($order["status"]); ?>">
                        <?php echo htmlspecialchars(ucfirst($order["status"])); ?>
                    </span>
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
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
