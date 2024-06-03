<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">
   <h3>About Us</h3>
   <div class="image">
      <img src="assets/images/about-img.jpg" alt="About Image">
   </div>
   <div class="content">
      <p>
         Welcome to SimplicityTech! We are a premier supplier of high-quality tech parts and a trusted reseller of technology products. Founded with the vision of simplifying technology for everyone, we have grown to become a leading name in the tech industry. Our mission is to provide our customers with the best tech parts, whether you're a DIY enthusiast, a small business, or a large enterprise.
      </p>
      <p>
         At SimplicityTech, we pride ourselves on offering a wide range of products, from the latest processors and graphics cards to essential peripherals and accessories. Our team of experts carefully selects each product to ensure it meets our high standards of quality and performance.
      </p>
      <p>
         As a reseller, we partner with top brands to bring you the latest innovations at competitive prices. Our commitment to customer satisfaction drives us to provide exceptional service, fast shipping, and expert advice to help you find the right solutions for your needs.
      </p>
      <p>
         Thank you for choosing SimplicityTech. We look forward to serving you and helping you stay ahead in the ever-evolving world of technology.
      </p>
      <a href="contact.php" class="btn">Contact Us</a>
   </div>
</section>


<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>
