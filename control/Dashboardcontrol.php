<?php
require_once '../model/db.php';

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $dbobj = new db();
    $conn = $dbobj->openconn();
    
    $result = $dbobj->deleteCustomer($id, $conn);
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
?>