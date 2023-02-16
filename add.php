<?php

if(!empty($_GET['status'])){
    $status = $_GET['status'];

    if($status == 'success') {
    ?>

    <div class="alert alert-success text-center" role="alert">
        Product added successfully
</div>
<?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <title>Admin Panel</title>
  </head>


  <body>
   
   <div class="container">
     <div class="row">
       <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
         <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
           <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
           <span class="fs-4">Admin Panel</span>
         </a>

         <ul class="nav nav-pills">
           <li class="nav-item"><a href="./" class="nav-link">Products</a></li>
           <li class="nav-item"><a href="add.php" class="nav-link active" aria-current="page">Add new product</a></li>
         </ul>
       </header>
     </div>

     <div class="row">
       <div class="col">
         <div id="add-fields">
           <h2 class="text-center">Add New Product</h2>
           <form action="store.php" method="post">
             <div class="form-group">
               <label for="link">Skroutz link</label>
               <input
                       type="url"
                       class="form-control"
                       id="link"
                       name="link"
                       required
                       placeholder="Enter Skroutz link to scrape"
               />
             </div>
             <div class="form-group mt-3">
               <label for="product_id">Product ID</label>
               <input
                       type="number"
                       class="form-control"
                       id="product_id"
                       name="product_id"
                       required
                       placeholder="Enter product ID in E-shop"
               />
             </div>
             <div class="form-group mt-3">
               <label for="soft_cap">Price Cap</label>
               <input
                       type="text"
                       class="form-control"
                       id="soft_cap"
                       name="soft_cap"
                       placeholder="Enter price cap"
               />
             </div>
             <button type="submit" class="btn btn-primary mt-3">Save</button>
           </form>
         </div>
       </div>

     </div>

  </div>


  </body>