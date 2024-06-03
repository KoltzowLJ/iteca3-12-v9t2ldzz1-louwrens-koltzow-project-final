<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $image = $_POST['image'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$name, $user_id]);

    if ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'Already added to cart!';
    } else {
        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
        $message[] = 'Added to cart!';
    }
}
?>

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
      <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= htmlspecialchars($fetch_product['id']); ?>">
         <input type="hidden" name="name" value="<?= htmlspecialchars($fetch_product['name']); ?>">
         <input type="hidden" name="price" value="<?= htmlspecialchars($fetch_product['price']); ?>">
         <input type="hidden" name="image" value="<?= htmlspecialchars($fetch_product['image_01']); ?>">
         <img src="assets/uploaded_images/<?= htmlspecialchars($fetch_product['image_01']); ?>" alt="">
         <div class="name"><?= htmlspecialchars($fetch_product['name']); ?></div>
         <div class="flex">
            <div class="price"><span>R</span><?= htmlspecialchars($fetch_product['price']); ?><span>/-</span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1">
         </div>
         <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No products available</p>';
      }
      ?>
   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>
