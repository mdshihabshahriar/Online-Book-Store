<?php

include "../model/db.php";

$mydb = new mydb();

$conobj = $mydb->openConn();

$result = $mydb->getCartItems($conobj);

$cart_count = $mydb->getCartCount($conobj);

?>