<div class="navbar">
    <a href="<?php echo !empty($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'admin_orders.php' : 'checkout.php'; ?>" class="brand">📚 Book Store</a>
    <div class="nav-links">
        <?php if (!empty($_SESSION["role"]) && $_SESSION["role"] === "customer"): ?>
            <a href="checkout.php">Checkout</a>
            <a href="profile.php">My Profile</a>
        <?php endif; ?>
        <?php if (!empty($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
            <a href="admin_orders.php">Order Processing</a>
        <?php endif; ?>
        <?php if (!empty($_SESSION["name"])): ?>
            <span class="who">Hi, <?php echo htmlspecialchars($_SESSION["name"]); ?></span>
            <a href="../control/logout.php" class="logout-link">Logout</a>
        <?php endif; ?>
    </div>
</div>
