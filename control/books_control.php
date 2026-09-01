<?php

include("../model/db.php");

$mydb=new mydb();

$conobj=$mydb->openConn();

$result=$mydb->getAllBooks($conobj);

$cart_count=$mydb->getCartCount($conobj);

?>