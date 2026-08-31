<?php
session_start();
require_once '../model/db.php';


//if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  //  header("Location: /OnlineBookStore/view/login.php");
    //exit();
//}

$titleError = $authorError = $descriptionError = $priceError = $categoryError = $stockError = $imageError = "";
$hasError = "";


if (isset($_POST["mysubmit"])) {
    $book_id     = $_POST["book_id"] ?? "";
    $title       = trim($_POST["title"]);
    $author      = trim($_POST["author"]);
    $description = trim($_POST["description"]);
    $price       = $_POST["price"];
    $category    = $_POST["category"];
    $stock       = $_POST["stock"];

    if (empty($title)) { $titleError = "Title must not be empty"; $hasError = "1"; }
    if (empty($author)) { $authorError = "Author must not be empty"; $hasError = "1"; }
    if (empty($description)) { $descriptionError = "Description must not be empty"; $hasError = "1"; }
    if (empty($price) || $price <= 0) { $priceError = "Price must be greater than 0"; $hasError = "1"; }
    if (empty($category)) { $categoryError = "Please select a category"; $hasError = "1"; }
    if ($stock === "" || $stock < 0) { $stockError = "Stock cannot be negative"; $hasError = "1"; }

   
    $image_path = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $imageError = "Only JPG, JPEG & PNG files allowed";
            $hasError = "1";
        } else if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $imageError = "Image must be under 2MB";
            $hasError = "1";
        } else {
            $target_dir = "../public/uploads/books/";
            if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
            $filename = time() . "_" . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $filename);
            $image_path = "public/uploads/books/" . $filename;
        }
    }

    if ($hasError == "1") {
        header("Location: /OnlineBookStore/view/book.php?titleError=" . urlencode($titleError) . "&authorError=" . urlencode($authorError) . "&descriptionError=" . urlencode($descriptionError) . "&priceError=" . urlencode($priceError) . "&categoryError=" . urlencode($categoryError) . "&stockError=" . urlencode($stockError) . "&imageError=" . urlencode($imageError));
        exit();
    } else {
        $dbobj = new db();
        $conn = $dbobj->openconn();

        if (!empty($book_id)) {
            $dbobj->updateBook($book_id, $title, $author, $description, $price, $category, $stock, $image_path, $conn);
        } else {
            $dbobj->insertBook($title, $author, $description, $price, $category, $stock, $image_path, $conn);
        }
        $dbobj->closeconn($conn);
        header("Location: /OnlineBookStore/view/book.php?msg=success");
        exit();
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $dbobj = new db();
    $conn = $dbobj->openconn();
    $dbobj->deleteBook($_GET['id'], $conn);
    $dbobj->closeconn($conn);
    header("Location: /OnlineBookStore/view/book.php?msg=deleted");
    exit();
}
?>