<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">
   <form action="" method="post">
      <h3>Contact us</h3>
      <input type="text" name="name" placeholder="Enter your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
      <input type="number" name="number" placeholder="Enter your number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="Send Message" class="btn">
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>
