<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['unique_user_id'])){
   $unique_user_id = $_SESSION['unique_user_id'];
} else {
   $unique_user_id = '';
}

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $unique_pid = $_POST['pid'];
    $unique_pid = filter_var($unique_pid, FILTER_SANITIZE_STRING);
    $unique_name = $_POST['name'];
    $unique_name = filter_var($unique_name, FILTER_SANITIZE_STRING);
    $unique_price = $_POST['price'];
    $unique_price = filter_var($unique_price, FILTER_SANITIZE_STRING);
    $unique_image = $_POST['image'];
    $unique_image = filter_var($unique_image, FILTER_SANITIZE_STRING);
    $unique_qty = $_POST['qty'];
    $unique_qty = filter_var($unique_qty, FILTER_SANITIZE_NUMBER_INT);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$unique_name, $unique_user_id]);

    if ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'Already added to cart!';
    } else {
        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$unique_user_id, $unique_pid, $unique_name, $unique_price, $unique_qty, $unique_image]);
        $message[] = 'Added to cart!';
    }
}

// Handle adding to wishlist
if (isset($_POST['add_to_wishlist'])) {
    $unique_pid = $_POST['pid'];
    $unique_pid = filter_var($unique_pid, FILTER_SANITIZE_STRING);
    $unique_name = $_POST['name'];
    $unique_name = filter_var($unique_name, FILTER_SANITIZE_STRING);
    $unique_price = $_POST['price'];
    $unique_price = filter_var($unique_price, FILTER_SANITIZE_STRING);
    $unique_image = $_POST['image'];
    $unique_image = filter_var($unique_image, FILTER_SANITIZE_STRING);

    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
    $check_wishlist_numbers->execute([$unique_name, $unique_user_id]);

    if ($check_wishlist_numbers->rowCount() > 0) {
        $message[] = 'Already added to wishlist!';
    } else {
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
        $insert_wishlist->execute([$unique_user_id, $unique_pid, $unique_name, $unique_price, $unique_image]);
        $message[] = 'Added to wishlist!';
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

<section class="home-products">
   <h1 class="heading">Shop</h1>
   <div class="products-grid">
      <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($unique_product = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="product-card">
         <img src="assets/uploaded_images/<?= htmlspecialchars($unique_product['image_01']); ?>" alt="<?= htmlspecialchars($unique_product['name']); ?>">
         <div class="content">
            <h3><?= htmlspecialchars($unique_product['name']); ?></h3>
            <p><?= htmlspecialchars($unique_product['details']); ?></p>
            <div class="price">R<?= htmlspecialchars($unique_product['price']); ?></div>
            <form action="" method="post">
               <input type="hidden" name="pid" value="<?= htmlspecialchars($unique_product['id']); ?>">
               <input type="hidden" name="name" value="<?= htmlspecialchars($unique_product['name']); ?>">
               <input type="hidden" name="price" value="<?= htmlspecialchars($unique_product['price']); ?>">
               <input type="hidden" name="image" value="<?= htmlspecialchars($unique_product['image_01']); ?>">
               <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
               <a href="product_view_detail.php?pid=<?= htmlspecialchars($unique_product['id']); ?>" class="fas fa-eye"></a>
               <input type="number" name="qty" class="qty" min="1" max="99" value="1">
               <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
            </form>
         </div>
      </div>
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
