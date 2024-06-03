<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">
   <h1 class="heading">Latest Products</h1>
   <div class="box-container">
      <!-- Example Product 1 -->
      <form action="" method="post" class="box">
         <img src="assets/images/product-1.jpg" alt="Product 1">
         <div class="name">Product 1</div>
         <div class="flex">
            <div class="price"><span>R</span>111.99<span>/-</span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1">
         </div>
         <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
      </form>
      <!-- Example Product 2 -->
      <form action="" method="post" class="box">
         <img src="assets/images/product-2.jpg" alt="Product 2">
         <div class="name">Product 2</div>
         <div class="flex">
            <div class="price"><span>R</span>111.99<span>/-</span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1">
         </div>
         <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
      </form>
      <!-- Example Product 3 -->
      <form action="" method="post" class="box">
         <img src="assets/images/product-3.jpg" alt="Product 3">
         <div class="name">Product 3</div>
         <div class="flex">
            <div class="price"><span>R</span>111.99<span>/-</span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1">
         </div>
         <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
      </form>
      <!-- Example Product 4 -->
      <form action="" method="post" class="box">
         <img src="assets/images/product-4.jpg" alt="Product 4">
         <div class="name">Product 4</div>
         <div class="flex">
            <div class="price"><span>R</span>111.99<span>/-</span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1">
         </div>
         <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
      </form>
   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>
