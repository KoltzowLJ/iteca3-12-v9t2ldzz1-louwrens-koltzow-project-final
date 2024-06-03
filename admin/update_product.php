<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">
   <h1 class="heading">Update Product</h1>

   <!-- Example product form -->
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="1">
      <input type="hidden" name="old_image_01" value="old_image1.jpg">
      <input type="hidden" name="old_image_02" value="old_image2.jpg">
      <input type="hidden" name="old_image_03" value="old_image3.jpg">
      
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/old_image1.jpg" alt="Main Image">
         </div>
         <div class="sub-image">
            <img src="../uploaded_img/old_image1.jpg" alt="Image 1">
            <img src="../uploaded_img/old_image2.jpg" alt="Image 2">
            <img src="../uploaded_img/old_image3.jpg" alt="Image 3">
         </div>
      </div>
      
      <span>Update Name</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="Enter product name" value="Sample Product Name">
      
      <span>Update Price</span>
      <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="Enter product price" value="100">
      
      <span>Update Details</span>
      <textarea name="details" class="box" required cols="30" rows="10">Sample product details...</textarea>
      
      <span>Update Image 01</span>
      <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      
      <span>Update Image 02</span>
      <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      
      <span>Update Image 03</span>
      <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="Update">
         <a href="products.php" class="option-btn">Go Back</a>
      </div>
   </form>
</section>

<script src="../assets/js/admin_script.js"></script>

<script>
document.getElementById('user-btn').addEventListener('click', function() {
   document.querySelector('.profile').classList.toggle('active');
});
</script>
   
</body>
</html>
