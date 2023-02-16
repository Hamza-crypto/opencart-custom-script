<?php

include 'init.php';

$id = $_GET['id'];
$ignore = $_GET['ignore'];


$response = $product_controller->updateIgnoreStatus($id, $ignore);

