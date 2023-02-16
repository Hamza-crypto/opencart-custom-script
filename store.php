<?php

include 'init.php';
$soft_cap = $_POST['soft_cap'];
$product_id = $_POST['product_id'] ?? null;
$link = $_POST['link'] ?? null;

$response = $product_controller->storeProduct( $soft_cap, $product_id, $link);

header("Location: add.php?status=success");

