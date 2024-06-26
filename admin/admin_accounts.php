<!--
    Name:               Louwrens Költzow
    Student Number:     V9T2LDZZ1
    Campus:             Pretoria
    Module:             ITECA3-B12: Project Final
 -->


<?php

// Include Database Connection
include '../components/connect.php';

// Start Session
session_start();

// Check Admin Authenticaiton
if(!isset($_SESSION['admin_id'])){
   header('location:admin_login.php');
   exit();
}

// Retrieves Admin ID
$admin_id = $_SESSION['admin_id'];

// Handles Delete Requests
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
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
   <title>Admin Accounts</title>

   <!-- Custom CSS file links -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
   
</head>
<body>

<!-- Include headers on page -->
<?php include '../components/admin_header.php'; ?>

<!-- Display Accounts with ability to update or delete -->
<section class="accounts">
   <h1 class="heading">Admin Accounts</h1>
   <div class="box-container">

      <div class="box">
         <p>Add new admin</p>
         <a href="register_admin.php" class="option-btn">Register Admin</a>
      </div>

      <?php
      $select_admins = $conn->prepare("SELECT * FROM `admins`");
      $select_admins->execute();
      if($select_admins->rowCount() > 0){
         while($fetch_admin = $select_admins->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p>Admin ID: <span><?= $fetch_admin['id']; ?></span></p>
         <p>Admin Name: <span><?= $fetch_admin['name']; ?></span></p>
         <div class="flex-btn">
            <a href="admin_accounts.php?delete=<?= $fetch_admin['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">Delete</a>
            <a href="update_profile.php" class="option-btn">Update</a>
         </div>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No accounts available!</p>';
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
