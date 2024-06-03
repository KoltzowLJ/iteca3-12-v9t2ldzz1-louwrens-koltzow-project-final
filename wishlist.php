<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
   exit();
};

include 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist_item->execute([$wishlist_id]);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:wishlist.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wishlist</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/styles.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h3 class="heading">Your Wishlist</h3>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $select_wishlist->execute([$user_id]);
      if($select_wishlist->rowCount() > 0){
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            $grand_total += $fetch_wishlist['price'];  
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= htmlspecialchars($fetch_wishlist['pid']); ?>">
      <input type="hidden" name="wishlist_id" value="<?= htmlspecialchars($fetch_wishlist['id']); ?>">
      <input type="hidden" name="name" value="<?= htmlspecialchars($fetch_wishlist['name']); ?>">
      <input type="hidden" name="price" value="<?= htmlspecialchars($fetch_wishlist['price']); ?>">
      <input type="hidden" name="image" value="<?= htmlspecialchars($fetch_wishlist['image']); ?>">
      <img src="assets/uploaded_images/<?= htmlspecialchars($fetch_wishlist['image']); ?>" alt="">
      <div class="name"><?= htmlspecialchars($fetch_wishlist['name']); ?></div>
      <div class="flex">
         <div class="price">R<?= htmlspecialchars($fetch_wishlist['price']); ?>/-</div>
      </div>
      <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
      <input type="submit" value="Delete Item" onclick="return confirm('Delete this from wishlist?');" class="delete-btn" name="delete">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Your wishlist is empty</p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      <p>Grand Total: <span>R<?= htmlspecialchars($grand_total); ?>/-</span></p>
      <a href="shop.php" class="option-btn">Continue Shopping</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Delete all from wishlist?');">Delete All Items</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>
