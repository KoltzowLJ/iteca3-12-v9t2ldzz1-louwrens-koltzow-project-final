<!--
    Name:       Louwrens Költzow
    Student     Number: V9T2LDZZ1
    Campus:     Pretoria
    Module:     ITECA3-B12: Project Final
 -->
    

<?php

// Include Database Connection
include 'components/connect.php';

// Start Session
session_start();

// Check User Authenticaiton
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
    exit();
}

// Handles Update Requests
if(isset($_POST['order'])) {
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
   $flat = filter_var($_POST['flat'], FILTER_SANITIZE_STRING);
   $street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
   $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
   $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
   $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
   $pin_code = filter_var($_POST['pin_code'], FILTER_SANITIZE_NUMBER_INT);
   
   $address = $flat . ', ' . $street . ', ' . $city . ', ' . $state . ', ' . $country . ', ' . $pin_code;

   // Fetch Total Products and Price of Cart Items
   $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $select_cart->execute([$user_id]);

   $total_products = '';
   $total_price = 0;
   if ($select_cart->rowCount() > 0) {
      while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
         $total_products .= $fetch_cart['name'] . ' (' . $fetch_cart['quantity'] . '), ';
         $total_price += $fetch_cart['price'] * $fetch_cart['quantity'];
      }
      $total_products = rtrim($total_products, ', ');
   }

   // Insert Order
   $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
   $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

   // Clear Cart
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$user_id]);

   try {
      // Email Sent To User 
      $to = $email;
      $subject = "Order Confirmation - SimplicityTech";
      $body = "Hello $name,\n\nThank you for your order. We have received your order and it is being processed.\n\nOrder Details:\n$total_products\n\nTotal Price: $total_price\n\nBest Regards,\nSimplicityTech Team";
      $headers = "From: no-reply@simplicitytech.co.za";

      // Email Sent To Company
      $admin_email = "no-reply@simplicitytech.co.za";
      $admin_subject = "New Order Received";
      $admin_body = "Name: $name\nEmail: $email\nNumber: $number\nOrder Details: $total_products\nTotal Price: R $total_price";
      $admin_headers = "From: $email";

      if(mail($to, $subject, $body, $headers) && mail($admin_email, $admin_subject, $admin_body, $admin_headers)){
          $message[] = 'Your order has been placed successfully and a confirmation email has been sent!';
      } else {
          $message[] = 'Order placed but failed to send confirmation email. Please contact support.';
      }
  } catch (PDOException $e) {
      $message[] = 'Order placed but failed to send confirmation email. Please contact support.';
  }


   $message[] = 'Order placed successfully!';
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
   <title>Checkout</title>
   
   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<!-- Include headers on page -->
<?php include 'components/user_header.php'; ?>

<!-- Display Fields to Submit Order -->
<section class="checkout-orders">

   <form action="" method="POST">

      <h3>Your Orders</h3>

      <div class="display-orders">
         <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if ($select_cart->rowCount() > 0) {
            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
               $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
               $grand_total += $total_price;
         ?>
         <p><?= htmlspecialchars($fetch_cart['name']); ?> <span>(R<?= htmlspecialchars($fetch_cart['price']); ?> x <?= htmlspecialchars($fetch_cart['quantity']); ?>)</span></p>
         <?php
            }
         }
         ?>
         <div class="grand-total">Grand Total: <span>R<?= htmlspecialchars($grand_total); ?></span></div>
      </div>

      <h3>Place Your Orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Your Name:</span>
            <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Your Number:</span>
            <input type="number" name="number" placeholder="Enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Your Email:</span>
            <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Payment Method:</span>
            <select name="method" class="box" required>
               <option value="credit card">Credit Card</option>
               <option value="paypal">PayPal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address Line 01:</span>
            <input type="text" name="flat" placeholder="e.g. Flat Number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Address Line 02:</span>
            <input type="text" name="street" placeholder="e.g. Street Name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City:</span>
            <input type="text" name="city" placeholder="e.g. Pretoria" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>State:</span>
            <input type="text" name="state" placeholder="e.g. Gauteng" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Country:</span>
            <input type="text" name="country" placeholder="e.g. South Africa" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Pin Code:</span>
            <input type="number" name="pin_code" placeholder="e.g. 0157" class="box" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn" value="Place Order">

   </form>

</section>

<!-- Include Footer -->
<?php include 'components/footer.php'; ?>

<!-- Include JavaScript -->
<script src="assets/js/script.js"></script>

</body>
</html>
