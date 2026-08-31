<?php
// session_start();
require_once '../model/db.php';

// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: /OnlineBookStore/view/login.php");
//     exit();
// }

$status = $_GET['status'] ?? '';
$date = $_GET['date'] ?? '';

$dbobj = new db();
$conn = $dbobj->openconn();
$orders = $dbobj->getAllOrders($status, $date, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History - BookHaven</title>
    <link rel="stylesheet" href="../css/Dashboard.css">
    <script src="../js/validation.js"></script>
</head>
<body>

    
    <div class="navbar">
        <div class="logo">📖 BookHaven</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="book.php">Manage Books</a>
            <a href="customermanage.php">Remove Customers</a>
            <a href="userlist.php">User Management</a>
            <a href="purchasehistory.php">Purchase History</a>
        </div>
        <div class="auth-btns">
            <a href="login.php" class="btn-outline">Logout</a>
        </div>
    </div>

    <div class="container">
        <h2 class="page-title">Purchase History & Order Processing</h2>

       
        <form method="GET" class="filter-card">
            <label>Filter Status: </label>
            <select name="status">
                <option value="">All Statuses</option>
                <option value="pending" <?php if($status=='pending') echo 'selected'; ?>>Pending</option>
                <option value="confirmed" <?php if($status=='confirmed') echo 'selected'; ?>>Confirmed</option>
                <option value="shipped" <?php if($status=='shipped') echo 'selected'; ?>>Shipped</option>
                <option value="delivered" <?php if($status=='delivered') echo 'selected'; ?>>Delivered</option>
            </select>

            <label>Date: </label>
            <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>">

            <button type="submit" class="btn-filled">Filter</button>
        </form>

       
        <div class="table-card">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orders && $orders->num_rows > 0): ?>
                        <?php while($o = $orders->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $o['id']; ?></td>
                            <td><?php echo htmlspecialchars($o['customer_name'] ?? 'N/A'); ?></td>
                            <td><?php echo number_format($o['total_amount'] ?? 0, 2); ?></td>
                            <td>
                                <strong class="status-badge" id="status-<?php echo $o['id']; ?>">
                                    <?php echo strtoupper($o['status'] ?? 'PENDING'); ?>
                                </strong>
                            </td>
                            <td><?php echo htmlspecialchars($o['payment_method'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($o['order_date'] ?? 'N/A'); ?></td>
                            <td>
                                <select class="styled-select" onchange="changeOrderStatus(<?php echo $o['id']; ?>, this.value)">
                                    <option value="pending" <?php if(($o['status']??'')=='pending') echo 'selected'; ?>>Pending</option>
                                    <option value="confirmed" <?php if(($o['status']??'')=='confirmed') echo 'selected'; ?>>Confirmed</option>
                                    <option value="shipped" <?php if(($o['status']??'')=='shipped') echo 'selected'; ?>>Shipped</option>
                                    <option value="delivered" <?php if(($o['status']??'')=='delivered') echo 'selected'; ?>>Delivered</option>
                                </select>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align:center;">No purchase history found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
<?php $dbobj->closeconn($conn); ?>