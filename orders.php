<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">Placed Orders</h1>

   <div class="box-container">
      <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
      $select_orders->execute([$user_id]);

      if ($select_orders->rowCount() > 0) {
         while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="box">
         <p>Placed on: <span><?= htmlspecialchars($fetch_orders['placed_on']); ?></span></p>
         <p>Name: <span><?= htmlspecialchars($fetch_orders['name']); ?></span></p>
         <p>Email: <span><?= htmlspecialchars($fetch_orders['email']); ?></span></p>
         <p>Number: <span><?= htmlspecialchars($fetch_orders['number']); ?></span></p>
         <p>Address: <span><?= htmlspecialchars($fetch_orders['flat'] . ', ' . $fetch_orders['street'] . ', ' . $fetch_orders['city'] . ', ' . $fetch_orders['state'] . ', ' . $fetch_orders['country']); ?></span></p>
         <p>Payment Method: <span><?= htmlspecialchars($fetch_orders['method']); ?></span></p>
         <p>Your Orders: <span><?= htmlspecialchars($fetch_orders['total_products']); ?> items</span></p>
         <p>Total Price: <span>R<?= htmlspecialchars($fetch_orders['total_price']); ?></span></p>
         <p>Payment Status: <span style="color:<?php if ($fetch_orders['payment_status'] == 'Completed') { echo 'green'; } else { echo 'red'; } ?>;"><?= htmlspecialchars($fetch_orders['payment_status']); ?></span></p>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No orders placed yet!</p>';
      }
      ?>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>
