<?php
// NOTE: minimal demo login so Task 4 (checkout) can be shown end-to-end.
// Full auth/registration is Task 1's responsibility.

include "../model/db.php";
session_start();

if (!empty($_SESSION["user_id"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: ../view/admin_orders.php");
    } else {
        header("Location: ../view/checkout.php");
    }
    exit;
}

$loginError = "";

if (isset($_POST["login"])) {

    $mydb = new mydb();
    $conobj = $mydb->openConn();
    $result = $mydb->checkLogin($conobj, "users", $_POST["email"]);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($_POST["password"], $row["password_hash"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["role"] = $row["role"];

            if ($row["role"] === "admin") {
                header("Location: ../view/admin_orders.php");
            } else {
                header("Location: ../view/checkout.php");
            }
            exit;
        } else {
            $loginError = "Incorrect password";
        }
    } else {
        $loginError = "User does not exist";
    }
}
?>
