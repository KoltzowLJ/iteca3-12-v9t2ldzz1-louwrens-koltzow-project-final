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
      <!-- Example Order 1 -->
      <div class="box">
      <p>Placed on: <span>2023-04-25</span></p>
         <p>Name: <span>Pierre Clear</span></p>
         <p>Email: <span>pearre.clear@example.com</span></p>
         <p>Number: <span>+27 12 345 6789</span></p>
         <p>Address: <span>123 Nog Straat, Daar, South Africa</span></p>
         <p>Payment Method: <span>Credit Card</span></p>
         <p>Your Orders: <span>1 items</span></p>
         <p>Total Price: <span>R111.99</span></p>
         <p>Payment Status: <span style="color:green;">Completed</span></p>
      </div>

      <!-- Example Order 2 -->
      <div class="box">
         <p>Placed on: <span>2023-04-25</span></p>
         <p>Name: <span>Sally Pally</span></p>
         <p>Email: <span>sally.pally@example.com</span></p>
         <p>Number: <span>+27 12 345 6789</span></p>
         <p>Address: <span>123 Skip Street, Sea, South Africa</span></p>
         <p>Payment Method: <span>PayPal</span></p>
         <p>Your Orders: <span>2 items</span></p>
         <p>Total Price: <span>R223.98</span></p>
         <p>Payment Status: <span style="color:red;">Pending</span></p>
      </div>


   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>