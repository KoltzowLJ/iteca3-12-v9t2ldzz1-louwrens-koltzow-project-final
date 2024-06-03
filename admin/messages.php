<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Messages</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="contacts">

   <h1 class="heading">Messages</h1>

   <div class="box-container">

      <!-- Example Message 1 -->
      <div class="box">
         <p> user id : <span>1</span></p>
         <p> name : <span>Danie Vanie</span></p>
         <p> email : <span>danie.vanie@example.com</span></p>
         <p> number : <span>+27 12 345 6789</span></p>
         <p> message : <span>Hello, I have a question about...</span></p>
         <a href="messages.php?delete=1" onclick="return confirm('delete this message?');" class="delete-btn">Delete</a>
      </div>

      <!-- Example Message 2 -->
      <div class="box">
         <p> user id : <span>2</span></p>
         <p> name : <span>Stollie Mollie</span></p>
         <p> email : <span>stollie.mollie@example.com</span></p>
         <p> number : <span>+27 12 345 6789</span></p>
         <p> message : <span>I need help with my order...</span></p>
         <a href="messages.php?delete=2" onclick="return confirm('delete this message?');" class="delete-btn">Delete</a>
      </div>

      <!-- Example Message 3 -->
      <div class="box">
         <p> user id : <span>3</span></p>
         <p> name : <span>Bor Tor</span></p>
         <p> email : <span>bor.tor@example.com</span></p>
         <p> number : <span>+27 12 345 6789</span></p>
         <p> message : <span>Can you provide more details about...</span></p>
         <a href="messages.php?delete=3" onclick="return confirm('delete this message?');" class="delete-btn">Delete</a>
      </div>

   </div>

</section>

<script src="../assets/js/admin_script.js"></script>

<script>
document.getElementById('user-btn').addEventListener('click', function() {
   document.querySelector('.profile').classList.toggle('active');
});
</script>

</body>
</html>