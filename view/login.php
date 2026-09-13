<?php
include "../control/login_control.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Book Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/mycss.css">
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card">
        <h1>📚 Online Book Store</h1>

        <?php if ($loginError !== ""): ?>
            <p class="error"><?php echo htmlspecialchars($loginError); ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" name="login" value="Login">
        </form>

        <div class="demo-box">
            <strong>Demo accounts</strong> (password: <code>password123</code>)
            <ul>
                <li>Customer: customer@bookstore.com</li>
                <li>Admin: admin@bookstore.com</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
