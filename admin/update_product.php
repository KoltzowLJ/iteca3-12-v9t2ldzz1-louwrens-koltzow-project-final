<?php
include '../components/connect.php';
session_start();

if(!isset($_SESSION['admin_id'])){
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

if(isset($_GET['update'])){
   $update_id = $_GET['update'];
   $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $select_products->execute([$update_id]);
   if($select_products->rowCount() > 0){
      $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
   }else{
      header('location:products.php');
   }
}else{
   header('location:products.php');
}

// Handle update request
if(isset($_POST['update'])){
   $pid = $_POST['pid'];
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
   $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
   $update_product->execute([$name, $price, $details, $pid]);

   $old_image_01 = $_POST['old_image_01'];
   $old_image_02 = $_POST['old_image_02'];
   $old_image_03 = $_POST['old_image_03'];

   if(isset($_FILES['image_01']['name']) && !empty($_FILES['image_01']['name'])){
      $image_01 = $_FILES['image_01']['name'];
      $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
      $image_01_folder = '../assets/uploaded_images/'.$image_01;
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      unlink('../assets/uploaded_images/'.$old_image_01);
      $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
      $update_image_01->execute([$image_01, $pid]);
   }

   if(isset($_FILES['image_02']['name']) && !empty($_FILES['image_02']['name'])){
      $image_02 = $_FILES['image_02']['name'];
      $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
      $image_02_folder = '../assets/uploaded_images/'.$image_02;
      move_uploaded_file($image_02_tmp_name, $image_02_folder);
      unlink('../assets/uploaded_images/'.$old_image_02);
      $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
      $update_image_02->execute([$image_02, $pid]);
   }

   if(isset($_FILES['image_03']['name']) && !empty($_FILES['image_03']['name'])){
      $image_03 = $_FILES['image_03']['name'];
      $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
      $image_03_folder = '../assets/uploaded_images/'.$image_03;
      move_uploaded_file($image_03_tmp_name, $image_03_folder);
      unlink('../assets/uploaded_images/'.$old_image_03);
      $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
      $update_image_03->execute([$image_03, $pid]);
   }

   $message[] = 'Product updated successfully!';
}
?>

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

   <?php
   if(isset($message)){
      foreach($message as $msg){
         echo '<p class="message">'.$msg.'</p>';
      }
   }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
      
      <div class="image-container">
         <div class="main-image">
            <img src="../assets/uploaded_images/<?= $fetch_products['image_01']; ?>" alt="Main Image">
         </div>
         <div class="sub-image">
            <img src="../assets/uploaded_images/<?= $fetch_products['image_01']; ?>" alt="Image 1">
            <img src="../assets/uploaded_images/<?= $fetch_products['image_02']; ?>" alt="Image 2">
            <img src="../assets/uploaded_images/<?= $fetch_products['image_03']; ?>" alt="Image 3">
         </div>
      </div>
      
      <span>Update Name</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="Enter product name" value="<?= $fetch_products['name']; ?>">
      
      <span>Update Price</span>
      <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="Enter product price" value="<?= $fetch_products['price']; ?>">
      
      <span>Update Details</span>
      <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
      
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
