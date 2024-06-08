<!--
    Name:       Louwrens Költzow
    Student     Number: V9T2LDZZ1
    Campus:     Pretoria
    Module:     ITECA3-B12: Project Final
 -->
    

<?php

// Include Database Connection
include '../components/connect.php';

// Start Session
session_start();

// Check Admin Authenticaiton
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

// Retrieves Admin ID
$admin_id = $_SESSION['admin_id'];

// Handles Delete Requests
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

// Handles Update Requests
if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_payment_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment_status->execute([$payment_status, $order_id]);
   header('location:placed_orders.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WJVLZYDW1W"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-WJVLZYDW1W');
    </script>

   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Placed Orders</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<!-- Include headers on page -->
<?php include '../components/admin_header.php'; ?>

<!-- Display Users Orders With Ability to Update or Delete Orders -->
<section class="orders">

   <h1 class="heading">Placed Orders</h1>

   <div class="box-container">

      <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p>Placed on: <span><?= $fetch_order['placed_on']; ?></span></p>
         <p>Name: <span><?= $fetch_order['name']; ?></span></p>
         <p>Number: <span><?= $fetch_order['number']; ?></span></p>
         <p>Address: <span><?= $fetch_order['address']; ?></span></p>
         <p>Total Products: <span><?= $fetch_order['total_products']; ?></span></p>
         <p>Total Price: <span>R<?= $fetch_order['total_price']; ?></span></p>
         <p>Payment Method: <span><?= $fetch_order['method']; ?></span></p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
            <select name="payment_status" class="select">
               <option selected disabled><?= $fetch_order['payment_status']; ?></option>
               <option value="pending">Pending</option>
               <option value="completed">Completed</option>
            </select>
            <div class="flex-btn">
               <input type="submit" value="Update" class="option-btn" name="update_payment">
               <a href="placed_orders.php?delete=<?= $fetch_order['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
            </div>
         </form>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No orders available!</p>';
      }
      ?>

   </div>

</section>

<!-- Include JavaScript -->
<script src="../assets/js/admin_script.js"></script>

<!-- EventListener for Profile Button -->
<script>
document.getElementById('user-btn').addEventListener('click', function() {
   document.querySelector('.profile').classList.toggle('active');
});
</script>
   
</body>
</html>
