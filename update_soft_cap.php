<?php

include 'init.php';

$id = $_GET['id'];
$new_val = $_GET['soft_cap_new_val'];


$response = $product_controller->updateSoftCap($id, $new_val);

