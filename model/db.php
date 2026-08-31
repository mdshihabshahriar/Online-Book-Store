<?php
class db {
    function openconn() {
        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "onlinebookstore";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    
    function insertBook($title, $author, $description, $price, $category, $stock, $image_path, $conn) {
        $sql = "INSERT INTO books (title, author, description, price, category, stock, image_path, role) 
                VALUES ('$title', '$author', '$description', '$price', '$category', '$stock', '$image_path', 'book')";
        return $conn->query($sql);
    }

    function getAllBooks($conn) {
        $sql = "SELECT * FROM books WHERE title IS NOT NULL AND title != ''";
        return $conn->query($sql);
    }

    function getBookById($id, $conn) {
        $sql = "SELECT * FROM books WHERE id = '$id'";
        return $conn->query($sql)->fetch_assoc();
    }

    function updateBook($id, $title, $author, $description, $price, $category, $stock, $image_path, $conn) {
        $sql = "UPDATE books SET title='$title', author='$author', description='$description', price='$price', category='$category', stock='$stock', image_path='$image_path' WHERE id='$id'";
        return $conn->query($sql);
    }

    function deleteBook($id, $conn) {
        $sql = "DELETE FROM books WHERE id = '$id'";
        return $conn->query($sql);
    }

   
    function getAllUsers($roleFilter, $conn) {
        if (!empty($roleFilter)) {
            $sql = "SELECT * FROM users_info WHERE role = '$roleFilter'";
        } else {
            $sql = "SELECT * FROM users_info";
        }
        return $conn->query($sql);
    }

    function deleteUser($id, $conn) {
        $sql = "DELETE FROM users_info WHERE id = '$id'";
        return $conn->query($sql);
    }

    function updateUserRole($id, $role, $conn) {
        $sql = "UPDATE users_info SET role = '$role' WHERE id = '$id'";
        return $conn->query($sql);
    }

    
    function getDashboardStats($conn) {
        $stats = [];
        
        $booksRes = $conn->query("SELECT COUNT(*) as count FROM books");
        $stats['total_books'] = $booksRes ? $booksRes->fetch_assoc()['count'] : 0;
        
        $custRes = $conn->query("SELECT COUNT(*) as count FROM users_info");
        $stats['total_customers'] = $custRes ? $custRes->fetch_assoc()['count'] : 0;

        $ordersCheck = $conn->query("SHOW TABLES LIKE 'orders'");
        if ($ordersCheck && $ordersCheck->num_rows > 0) {
            $ordRes = $conn->query("SELECT COUNT(*) as count FROM orders");
            $stats['total_orders'] = $ordRes ? $ordRes->fetch_assoc()['count'] : 0;
            
            $res = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'");
            $stats['total_revenue'] = $res ? ($res->fetch_assoc()['total'] ?? 0) : 0;
        } else {
            $stats['total_orders'] = 0;
            $stats['total_revenue'] = 0;
        }

        return $stats;
    }

   
    function getAllOrders($statusFilter, $dateFilter, $conn) {
        $sql = "SELECT * FROM orders WHERE 1=1";

        if (!empty($statusFilter)) {
            $statusFilter = $conn->real_escape_string($statusFilter);
            $sql .= " AND status = '$statusFilter'";
        }

        if (!empty($dateFilter)) {
            $dateFilter = $conn->real_escape_string($dateFilter);
            $sql .= " AND DATE(order_date) = '$dateFilter'";
        }

        $sql .= " ORDER BY id DESC";
        return $conn->query($sql);
    }

    function updateOrderStatus($orderId, $status, $conn) {
        $orderId = intval($orderId);
        $status = $conn->real_escape_string($status);
        $sql = "UPDATE orders SET status = '$status' WHERE id = '$orderId'";
        return $conn->query($sql);
    }
   
    function insertCategory($name, $conn) {
        $name = $conn->real_escape_string($name);
        $sql = "INSERT INTO categories (name) VALUES ('$name')";
        return $conn->query($sql);
    }

    function getAllCategories($conn) {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $conn->query($sql);
    }

    function deleteCategory($id, $conn) {
        $id = intval($id);
        $sql = "DELETE FROM categories WHERE id = '$id'";
        return $conn->query($sql);
    }

    function closeconn($conn) {
        $conn->close();
    }
}
?>