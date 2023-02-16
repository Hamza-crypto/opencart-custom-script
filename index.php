<?php
include 'init.php';

if(!empty($_GET['status'])){
    $status = $_GET['status'];

    if($status == 'success') {
        ?>

        <div class="alert alert-success text-center" role="alert">
            Product deleted successfully
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
            integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
            crossorigin="anonymous"></script>
    <title>Admin Panel</title>
</head>


<body>

<div class="container">
    <div class="row">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4">Admin Panel</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Products</a></li>
                <li class="nav-item"><a href="add.php" class="nav-link">Add new product</a></li>
                <li class="nav-item"><a href="scrape.php" target="_blank" class="nav-link">Scrape</a></li>
            </ul>
        </header>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Current Price</th>
                        <th>Soft Cap</th>
                        <th>Ignore</th>
                        <th>URL</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $products = $product_controller->getProducts();
                    foreach ($products as $product) {

                        $status = $product['ignored'] == 1 ? 'checked' : '';
                        $product_id = $product['id'];
                        $delete_url = "delete.php?id=$product_id";

                        echo '<tr>';
                        echo '<td>' . $product['eshop_id'] . '</td>';
                        echo '<td>' . $product['price'] . '</td>';
                        echo '<td><input type="text" class="form-control soft_cap" value="' . $product['soft_cap'] . '" data-id="' . $product['id'] . '"></td>';
                        echo '<td><input type="checkbox" name="ignore_status" class="form-check-input ignore_status" data-id="' . $product['id'] . '" ' . $status . '> 
                                <span class="form-check-label">Ignore</span>
                              </td>';
                        echo '<td>' . $product['url'] . '</td>';
                        echo '<td>
                                    <form method="post" action="' .$delete_url . '" style="display: inline" onsubmit="confirm(this, "Are you sure ? ")">
            
                                 <button type="submit" class="btn btn-danger">Delete
                                   <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"></path>
                                 </button>
                             </form>
                            </td>';
                                  echo '</tr>';

                            }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.3.min.js" ></script>

<script>
    $(document).on('change', '.soft_cap', function () {
        var id = $(this).attr('data-id');
        var soft_cap = $(this).val();
        $.ajax({
            url: "update_soft_cap.php?id=" + id + "&soft_cap_new_val=" + soft_cap,
            method: "GET",
            success: function (data) {
                alert('Soft cap updated successfully')
            }
        });
    });

    $(document).on('change', '.ignore_status', function () {
        let ignore = 0;
        if ($(this)[0].checked) {
            ignore = 1;
        }
        console.log(ignore);
        var id = $(this).attr('data-id');
        $.ajax({
            url: "update_ignore_status.php?id=" + id + "&ignore=" + ignore,
            method: "GET",
            success: function (data) {
                // alert('Status updated successfully')
            }
        });
    });
</script>

</body>