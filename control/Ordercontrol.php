<?php
require_once '../model/db.php';

if (isset($_GET['action']) && $_GET['action'] === 'update_status') {
    if (isset($_GET['id']) && isset($_GET['status'])) {
        $id = intval($_GET['id']);
        $status = $_GET['status'];

        $dbobj = new db();
        $conn = $dbobj->openconn();

        $result = $dbobj->updateOrderStatus($id, $status, $conn);
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