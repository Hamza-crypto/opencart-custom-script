<?php

include '../config.php';

$con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $product_id = $_GET['product_id'];
    $price = getPrice($product_id);
    echo $price;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    setPrice($_POST['product_id'], $_POST['price']);
}

function getPrice($product_id)
{
    global $con;
    $query = sprintf("SELECT price FROM %sproduct WHERE product_id = %d LIMIT 1", DB_PREFIX, $product_id);
    $result = mysqli_query($con, $query);
    return mysqli_fetch_array($result)[0];
}

function setPrice($product_id, $price)
{
    global $con;
    $query = sprintf("UPDATE %sproduct SET price = %s WHERE product_id = %d", DB_PREFIX, $price, $product_id);
    $result = mysqli_query($con, $query);
    if ($result) {
        echo "Price updated successfully";
    } else {
        echo "Error updating price";
    }
}




