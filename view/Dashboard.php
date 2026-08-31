<?php
// session_start();
require_once '../model/db.php';

$dbobj = new db();
$conn = $dbobj->openconn();

$books = $dbobj->getAllBooks($conn);
$stats = $dbobj->getDashboardStats($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BookHaven - Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="../js/validation.js"></script>
</head>
<body>

    <div class="navbar">
        <div class="logo">📖 BookHaven</div>
        <div class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="browse.php">Browse Books</a>
            <a href="customermanage.php">Manage Customers</a>
            <a href="book.php">Add Books</a>
        </div>
        <div class="auth-btns">
            <a href="login.php" class="btn-outline">Login</a>
            <a href="register.php" class="btn-filled">Register</a>
        </div>
    </div>

    <div class="hero">
        <div class="hero-text">
            <span class="hero-tag">WELCOME TO BOOKHAVEN</span>
            <h1>Find Your Next Great Read</h1>
            <p>Explore thousands of books across all genres.</p>
            <a href="browse.php" class="btn-filled">Browse Books ➔</a>
        </div>
        <div class="hero-img">
            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400" alt="Books" style="width: 350px; border-radius: 12px;">
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <h3><?php echo $stats['total_books'] ?? 0; ?></h3>
            <p>Total Books</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $stats['total_customers'] ?? 0; ?></h3>
            <p>Active Readers</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $stats['total_orders'] ?? 0; ?></h3>
            <p>Orders Placed</p>
        </div>
        <div class="stat-card">
            <h3><?php echo number_format($stats['total_revenue'] ?? 0, 2); ?></h3>
            <p>Total Revenue</p>
        </div>
    </div>

    <div class="featured">
    <h2>Featured Books</h2>
    <div class="book-grid">
        <?php if ($books && $books->num_rows > 0): ?>
            <?php while($b = $books->fetch_assoc()): ?>
                <div class="book-card">
                    <?php 
                       
                        $rawImage = $b['image_path'] ?? ''; 
                        $imageName = basename($rawImage);

                        if (!empty($imageName) && file_exists('../Images/' . $imageName)) {
                            $imageSrc = '../Images/' . $imageName;
                        } else {
                            $imageSrc = 'https://via.placeholder.com/150x220?text=No+Cover';
                        }
                    ?>
                    <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Book">
                    <h4><?php echo htmlspecialchars($b['title'] ?? 'Untitled'); ?></h4>
                    <p><?php echo htmlspecialchars($b['author'] ?? 'Unknown'); ?></p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

   
</div>

    <footer>
        <div>
            <h4>📖 BookHaven</h4>
            <p>Your ultimate online bookstore.</p>
        </div>
        <div class="copyright">
            © 2026 BookHaven. All rights reserved.
        </div>
    </footer>

</body>
</html>
<?php $dbobj->closeconn($conn); ?>