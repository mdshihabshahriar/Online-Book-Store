<?php
session_start();
require_once '../model/db.php';

//if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  //  header("Location: /OnlineBookStore/view/login.php");
    //exit();
//}

$dbobj = new db();
$conn = $dbobj->openconn();
$books= $dbobj->getAllBooks($conn);

$edit_book = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $edit_book = $dbobj->getBookById($_GET['id'], $conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Management</title>
    <link rel="stylesheet" href="../css/book.css">
    <script src="../js/book.js"></script>
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a> | <a href="book.php">Manage Books</a>
    </div>

    <h2><?php echo $edit_book ? "Edit Book" : "Add New Book"; ?></h2>
    
 <form action="/OnlineBookStore/control/bookcontrol.php" method="POST" enctype="multipart/form-data" onsubmit="return validateBookForm()">
        <input type="hidden" name="book_id" value="<?php echo $edit_book['id'] ?? ''; ?>">
        
        <label>Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $edit_book['title'] ?? ''; ?>"><br>
        <span class="error"><?php echo $_GET['titleError'] ?? ''; ?></span><br>

        <label>Author:</label><br>
        <input type="text" id="author" name="author" value="<?php echo $edit_book['author'] ?? ''; ?>"><br>
        <span class="error"><?php echo $_GET['authorError'] ?? ''; ?></span><br>

        <label>Description:</label><br>
        <textarea id="description" name="description"><?php echo $edit_book['description'] ?? ''; ?></textarea><br>
        <span class="error"><?php echo $_GET['descriptionError'] ?? ''; ?></span><br>

        <label>Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $edit_book['price'] ?? ''; ?>"><br>
        <span class="error"><?php echo $_GET['priceError'] ?? ''; ?></span><br>

    <div class="from-group">
        <label for="category">Category:</label><br>
        <select name="category" id="category" class="from-control" required>
           <option value="">Select Category</option>
           <option value="Novel">Novel</option>
           <option value="Literature">Literature</option>
           <option value="Sci-Fi">Sci-Fi</option>
        </select>
    </div><br>

        <label>Stock:</label><br>
        <input type="number" id="stock" name="stock" value="<?php echo $edit_book['stock'] ?? ''; ?>"><br>
        <span class="error"><?php echo $_GET['stockError'] ?? ''; ?></span><br>

        <label>Book Cover Image:</label><br>
        <input type="file" id="image" name="image"><br>
        <span class="error"><?php echo $_GET['imageError'] ?? ''; ?></span><br><br>

        <input type="submit" name="mysubmit" value="<?php echo $edit_book ? "Update Book" : "Add Book"; ?>">
    </form>

    <h2>Book Inventory List</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Title</th><th>Author</th><th>Price</th><th>Stock</th><th>Actions</th>
        </tr>
        <?php while($row = $books->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['stock']; ?></td>
            <td>
                <a href="book.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a> | 
                <a href="/OnlineBookStore/control/bookcontrol.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this book?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>