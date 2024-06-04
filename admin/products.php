<?php
include '../components/connect.php';
session_start();

if(!isset($_SESSION['admin_id'])){
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

// Handle add product request
if(isset($_POST['add_product'])){
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
   $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_folder = '../assets/uploaded_images/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
   $image_02_folder = '../assets/uploaded_images/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
   $image_03_folder = '../assets/uploaded_images/'.$image_03;

   if($name == '' || $price == '' || $details == '' || $image_01 == '' || $image_02 == '' || $image_03 == ''){
      $message[] = 'please fill out all!';
   }else{
      $insert_product = $conn->prepare("INSERT INTO `products`(name, price, details, image_01, image_02, image_03) VALUES(?,?,?,?,?,?)");
      $insert_product->execute([$name, $price, $details, $image_01, $image_02, $image_03]);

      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      move_uploaded_file($image_02_tmp_name, $image_02_folder);
      move_uploaded_file($image_03_tmp_name, $image_03_folder);

      $message[] = 'new product added!';
   }
}

// Handle delete request
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../assets/uploaded_images/'.$fetch_delete_image['image_01']);
   unlink('../assets/uploaded_images/'.$fetch_delete_image['image_02']);
   unlink('../assets/uploaded_images/'.$fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   header('location:products.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

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
      <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <img src="../assets/uploaded_images/<?= $fetch_products['image_01']; ?>" alt="Product Image">
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="price">R<?= $fetch_products['price']; ?></div>
         <div class="details"><?= $fetch_products['details']; ?></div>
         <div class="flex-btn">
            <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
            <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">Delete</a>
         </div>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No products available!</p>';
      }
      ?>
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
