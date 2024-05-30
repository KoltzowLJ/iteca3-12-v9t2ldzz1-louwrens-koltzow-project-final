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
         <p> name : <span>John Doe</span></p>
         <p> email : <span>johndoe@example.com</span></p>
         <p> number : <span>1234567890</span></p>
         <p> message : <span>Hello, I have a question about...</span></p>
         <a href="messages.php?delete=1" onclick="return confirm('delete this message?');" class="delete-btn">Delete</a>
      </div>

      <!-- Example Message 2 -->
      <div class="box">
         <p> user id : <span>2</span></p>
         <p> name : <span>Jane Smith</span></p>
         <p> email : <span>janesmith@example.com</span></p>
         <p> number : <span>0987654321</span></p>
         <p> message : <span>I need help with my order...</span></p>
         <a href="messages.php?delete=2" onclick="return confirm('delete this message?');" class="delete-btn">Delete</a>
      </div>

      <!-- Example Message 3 -->
      <div class="box">
         <p> user id : <span>3</span></p>
         <p> name : <span>Mike Johnson</span></p>
         <p> email : <span>mikejohnson@example.com</span></p>
         <p> number : <span>1122334455</span></p>
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