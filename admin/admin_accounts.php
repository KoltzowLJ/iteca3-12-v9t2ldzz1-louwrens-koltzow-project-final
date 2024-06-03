<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Admin Accounts</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">
   <h1 class="heading">Admin Accounts</h1>
   <div class="box-container">

      <div class="box">
         <p>Add new admin</p>
         <a href="register_admin.php" class="option-btn">Register Admin</a>
      </div>

      <!-- Example Admin Account 1 -->
      <div class="box">
         <p>Admin ID: <span>1</span></p>
         <p>Admin Name: <span>Admin One</span></p>
         <div class="flex-btn">
            <a href="#" onclick="return confirm('delete this account?')" class="delete-btn">Delete</a>
            <a href="update_profile.php" class="option-btn">Update</a>
         </div>
      </div>

      <!-- Example Admin Account 2 -->
      <div class="box">
         <p>Admin ID: <span>2</span></p>
         <p>Admin Name: <span>Admin Two</span></p>
         <div class="flex-btn">
            <a href="#" onclick="return confirm('delete this account?')" class="delete-btn">Delete</a>
         </div>
      </div>

      <!-- Example Admin Account 3 -->
      <div class="box">
         <p>Admin ID: <span>3</span></p>
         <p>Admin Name: <span>Admin Three</span></p>
         <div class="flex-btn">
            <a href="#" onclick="return confirm('delete this account?')" class="delete-btn">Delete</a>
         </div>
      </div>

      <!-- Example Empty State -->
      <p class="empty">No accounts available!</p>

   </div>
</section>

<script src="../js/admin_script.js"></script>

<script>
document.getElementById('user-btn').addEventListener('click', function() {
   document.querySelector('.profile').classList.toggle('active');
});
</script>

</body>
</html>
