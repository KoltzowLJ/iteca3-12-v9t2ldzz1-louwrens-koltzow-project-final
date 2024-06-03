<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users Accounts</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">
   <h1 class="heading">User Accounts</h1>
   <div class="box-container">
      <!-- Example User Account 1 -->
      <div class="box">
         <p>user id: <span>1</span></p>
         <p>username: <span>Greg Cleg</span></p>
         <p>email: <span>greg.cleg@example.com</span></p>
         <a href="users_accounts.php?delete=1" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
      </div>

      <!-- Example User Account 2 -->
      <div class="box">
         <p>user id: <span>2</span></p>
         <p>username: <span>Sale Pale</span></p>
         <p>email: <span>sale.pale@example.com</span></p>
         <a href="users_accounts.php?delete=2" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
      </div>

      <!-- Example User Account 3 -->
      <div class="box">
         <p>user id: <span>3</span></p>
         <p>username: <span>Von Bom</span></p>
         <p>email: <span>von.bom@example.com</span></p>
         <a href="users_accounts.php?delete=3" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
      </div>

      <!-- Example User Account 4 -->
      <div class="box">
         <p>user id: <span>4</span></p>
         <p>username: <span>Alexa Spalexa</span></p>
         <p>email: <span>alexa.spalexa@example.com</span></p>
         <a href="users_accounts.php?delete=4" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
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