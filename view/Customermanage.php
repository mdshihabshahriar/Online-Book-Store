<?php
// session_start();
require_once '../model/db.php';

// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header("Location: /OnlineBookStore/view/login.php");
//     exit();
// }

$dbobj = new db();
$conn = $dbobj->openconn();
$customers = $dbobj->getAllUsers('customer', $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Management</title>
    <link rel="stylesheet" href="../css/Customermanage.css">
    <script src="../js/validation.js"></script>
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
    </div>

    <h2>Registered Customers</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php 
        if ($customers && $customers->num_rows > 0) {
            while($c = $customers->fetch_assoc()) { 
        ?>
            <tr id="row-<?php echo $c['id']; ?>">
                <td><?php echo $c['id']; ?></td>
                <td><?php echo htmlspecialchars($c['name']); ?></td>
                <td><?php echo htmlspecialchars($c['email']); ?></td>
                <td><?php echo htmlspecialchars($c['phone'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($c['role']); ?></td>
                <td>
                    <button onclick="removeCustomer(<?php echo $c['id']; ?>)">Remove</button>
                </td>
            </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>No customers registered yet.</td></tr>";
        }
        ?>
    </table>
</body>
</html>