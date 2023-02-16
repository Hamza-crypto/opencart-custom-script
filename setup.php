<?php

include '../config.php';

$conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$sql = "CREATE TABLE custom_products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    price VARCHAR(255),
    soft_cap VARCHAR(255) default null,
    eshop_id INT(6) UNSIGNED,
    ignored BOOLEAN default 0,
    url VARCHAR(255)
    )";


//create table
if (mysqli_query($conn, $sql)) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
