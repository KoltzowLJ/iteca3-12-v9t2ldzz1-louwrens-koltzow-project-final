<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../assets/css/admin_styles.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">
   <h1 class="heading">Add Product</h1>
   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Product Name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>Product Price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="Enter product price" name="price">
         </div>
         <div class="inputBox">
            <span>Image 01 (required)</span>
            <input type="file" name="image_01" accept="image/*" class="box" required>
         </div>
         <div class="inputBox">
            <span>Image 02 (required)</span>
            <input type="file" name="image_02" accept="image/*" class="box" required>
         </div>
         <div class="inputBox">
            <span>Image 03 (required)</span>
            <input type="file" name="image_03" accept="image/*" class="box" required>
         </div>
         <div class="inputBox">
            <span>Product Details (required)</span>
            <textarea name="details" placeholder="Enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      <input type="submit" value="Add Product" class="btn" name="add_product">
   </form>
</section>

<section class="show-products">
   <h1 class="heading">Products Added</h1>
   <div class="box-container">
      <div class="box">
         <img src="../assets/images/product-1.jpg" alt="Product Image">
         <div class="name">Example Product 1</div>
         <div class="price">$100</div>
         <div class="details">Example details about product 1</div>
         <div class="flex-btn">
            <a href="update_product.php?update=1" class="option-btn">Update</a>
            <a href="products.php?delete=1" class="delete-btn" onclick="return confirm('delete this product?');">Delete</a>
         </div>
      </div>
      <div class="box">
         <img src="../assets/images/product-2.jpg" alt="Product Image">
         <div class="name">Example Product 2</div>
         <div class="price">$200</div>
         <div class="details">Example details about product 2</div>
         <div class="flex-btn">
            <a href="update_product.php?update=2" class="option-btn">Update</a>
            <a href="products.php?delete=2" class="delete-btn" onclick="return confirm('delete this product?');">Delete</a>
         </div>
      </div>
      <div class="box">
         <img src="../assets/images/product-3.jpg" alt="Product Image">
         <div class="name">Example Product 3</div>
         <div class="price">$300</div>
         <div class="details">Example details about product 3</div>
         <div class="flex-btn">
            <a href="update_product.php?update=3" class="option-btn">Update</a>
            <a href="products.php?delete=3" class="delete-btn" onclick="return confirm('delete this product?');">Delete</a>
         </div>
      </div>
   </div>
</section>

<script src="../assets/js/admin_script.js"></script>

<script>
document.getElementById('user-btn').addEventListener('click', function() {
   document.querySelector('.profile').classList.toggle('active');
});
</script>

</body>
</html>