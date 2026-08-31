<?php
require_once '../model/db.php';
$dbobj = new db();
$conn = $dbobj->openconn();
$books = $dbobj->getAllBooks($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Books - BookHaven</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

    <div class="navbar">
        <div class="logo">📖 BookHaven</div>
        <div class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="browse.php">Browse Books</a>
            <a href="customermanage.php">Manage Customers</a>
        </div>
        <div class="auth-btns">
            <a href="login.php" class="btn-outline">Login</a>
            <a href="register.php" class="btn-filled">Register</a>
        </div>
    </div>

    <div class="featured" style="padding: 40px;">
        <h2>All Available Books</h2>
        <div class="book-grid">
            <?php if ($books && $books->num_rows > 0): ?>
                <?php while($b = $books->fetch_assoc()): ?>
                    <div class="book-card">
                        <?php 
                            $rawImage = $b['image_path'] ?? ''; 
                            $imageName = basename($rawImage);
                            $imageSrc = (!empty($imageName) && file_exists('../Images/' . $imageName)) ? '../Images/' . $imageName : 'https://via.placeholder.com/150x220?text=No+Cover';
                        ?>
                        <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Book">
                        <h4><?php echo htmlspecialchars($b['title'] ?? 'Untitled'); ?></h4>
                        <p><?php echo htmlspecialchars($b['author'] ?? 'Unknown'); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No books available.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
<?php $dbobj->closeconn($conn); ?>