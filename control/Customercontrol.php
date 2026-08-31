<?php
require_once '../model/db.php';

if (isset($_GET['action'])) {
    $dbobj = new db();
    $conn = $dbobj->openconn();

  
    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = $dbobj->deleteUser($id, $conn);
        $dbobj->closeconn($conn);

        if ($result) {
            http_response_code(200);
            echo "Success";
        } else {
            http_response_code(500);
            echo "Error";
        }
        exit();
    }

   
    if ($_GET['action'] === 'update_role' && isset($_GET['id']) && isset($_GET['role'])) {
        $id = intval($_GET['id']);
        $role = $_GET['role'];
        $result = $dbobj->updateUserRole($id, $role, $conn);
        $dbobj->closeconn($conn);

        if ($result) {
            http_response_code(200);
            echo "Success";
        } else {
            http_response_code(500);
            echo "Error";
        }
        exit();
    }
}
?>