<?php
session_start();
require_once '../model/db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // header("Location: /OnlineBookStore/view/login.php");
    // exit();
}

$roleFilter = $_GET['role'] ?? '';

$dbobj = new db();
$conn = $dbobj->openconn();
$users = $dbobj->getAllUsers($roleFilter, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - BookHaven</title>
    <link rel="stylesheet" href="../css/Dashboard.css">
    <script src="../js/validation.js"></script>
</head>
<body>


    <div class="navbar">
        <div class="logo">📖 BookHaven</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="book.php">Manage Books</a>
            <a href="userlist.php">User Management</a>
            <a href="purchasehistory.php">Orders</a>
        </div>
        <div class="auth-btns">
            <a href="login.php" class="btn-outline">Logout</a>
        </div>
    </div>

    <div class="container">
        <h2>User Management</h2>

        <div class="table-wrapper">
           
            <form method="GET" class="filter-form">
                <label>Filter Role: </label>
                <select name="role">
                    <option value="">All Users</option>
                    <option value="admin" <?php if($roleFilter=='admin') echo 'selected'; ?>>Admin</option>
                    <option value="customer" <?php if($roleFilter=='customer') echo 'selected'; ?>>Customer</option>
                </select>
                <button type="submit" class="btn-filled">Filter</button>
            </form>

           
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username / Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Change Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users && $users->num_rows > 0): ?>
                        <?php while($u = $users->fetch_assoc()): ?>
                        <tr id="user-row-<?php echo $u['id']; ?>">
                            <td>#<?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['username'] ?? $u['name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($u['email'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="role-badge" id="role-badge-<?php echo $u['id']; ?>">
                                    <?php echo strtoupper($u['role'] ?? 'CUSTOMER'); ?>
                                </span>
                            </td>
                            <td>
                                <select onchange="changeUserRole(<?php echo $u['id']; ?>, this.value)">
                                    <option value="customer" <?php if(($u['role']??'')=='customer') echo 'selected'; ?>>Customer</option>
                                    <option value="admin" <?php if(($u['role']??'')=='admin') echo 'selected'; ?>>Admin</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn-delete" onclick="deleteUserRow(<?php echo $u['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
<?php $dbobj->closeconn($conn); ?>