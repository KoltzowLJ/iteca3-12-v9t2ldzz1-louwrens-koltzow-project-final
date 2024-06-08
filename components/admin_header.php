<!--
    Name:       Louwrens Költzow
    Student     Number: V9T2LDZZ1
    Campus:     Pretoria
    Module:     ITECA3-B12: Project Final
 -->
    

<?php

// Initialize variable as an array
if (!isset($message)) {
    $message = [];
}

// Display Messages
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . htmlspecialchars($msg) . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<!-- Header Section -->
<header class="header">
   <section class="flex">

      <a href="../admin/dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="../admin/dashboard.php">Home</a>
         <a href="../admin/products.php">Products</a>
         <a href="../admin/placed_orders.php">Orders</a>
         <a href="../admin/admin_accounts.php">Admins</a>
         <a href="../admin/users_accounts.php">Users</a>
         <a href="../admin/messages.php">Messages</a>
         <a href="../admin/update_category.php">Categories</a>
         <a href="../admin/update_store_logo.php">Store Logo</a>
      </nav>

      <div class="icons">
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <p>Admin 1</p>
         <a href="../admin/update_profile.php" class="btn">Update Profile</a>
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a>
      </div>

   </section>
</header>



