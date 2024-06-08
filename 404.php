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
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

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
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Page Not Found</title>

    <!-- Custom CSS file link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<!-- Include headers on page -->
<?php include 'components/user_header.php'; ?>

<!-- Error 404 -->
<section class="about">
   <h3 class="heading">404 - Page Not Found</h3>
   <div class="about-content">
      <div class="content">
         <p>Sorry, the page you are looking for does not exist. It might have been moved or deleted.</p>
         <p>Please check the URL or go back to the <a href="index.php">homepage</a>.</p>
      </div>
   </div>
</section>

<!-- Include Footer -->
<?php include 'components/footer.php'; ?>

<!-- Include JavaScript -->
<script src="assets/js/script.js"></script>

</body>
</html>
