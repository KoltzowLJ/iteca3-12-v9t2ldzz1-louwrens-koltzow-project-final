<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products shopping-cart">

   <h3 class="heading">Shopping Cart</h3>

   <div class="box-container">

      <!-- Example Product 1 -->
      <form action="" method="post" class="box">
         <img src="assets/images/product-1.jpg" alt="Product 1">
         <div class="name">Product 1</div>
         <div class="flex">
            <div class="price">R111.99</div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1">
         </div>
         <div class="sub-total">Sub Total: <span>R111.99</span></div>
         <input type="submit" value="Delete Item" class="delete-btn" name="delete">
      </form>

      <!-- Example Product 2 -->
      <form action="" method="post" class="box">
         <img src="assets/images/product-2.jpg" alt="Product 2">
         <div class="name">Product 2</div>
         <div class="flex">
            <div class="price">R111.99</div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="2">
         </div>
         <div class="sub-total">Sub Total: <span>R223.98</span></div>
         <input type="submit" value="Delete Item" class="delete-btn" name="delete">
      </form>

      <!-- Example Product 3 -->
      <form action="" method="post" class="box">
         <img src="assets/images/product-3.jpg" alt="Product 3">
         <div class="name">Product 3</div>
         <div class="flex">
            <div class="price">R111.99</div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1">
         </div>
         <div class="sub-total">Sub Total: <span>R111.99</span></div>
         <input type="submit" value="Delete Item" class="delete-btn" name="delete">
      </form>

   </div>

   <div class="cart-total">
      <p>Grand Total: <span>R447.96</span></p>
      <a href="shop.php" class="option-btn">Continue Shopping</a>
      <a href="#" class="delete-btn">Delete All Items</a>
      <a href="checkout.php" class="btn">Proceed to Checkout</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>