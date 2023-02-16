<?php

include 'init.php';

$id = $_GET['id'];

$response = $product_controller->deleteProduct($id);

//redirect to index page with success message
header("Location: index.php?status=success");

