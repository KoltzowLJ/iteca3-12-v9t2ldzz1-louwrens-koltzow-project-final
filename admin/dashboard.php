<?php
include '../components/connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetching dynamic data
$total_pendings = 0;
$total_completed = 0;
$total_orders = 0;
$total_products = 0;
$total_users = 0;
$total_admins = 0;
$total_messages = 0;

try {
   // Fetch total pendings
   $select_pendings = $conn->prepare("SELECT SUM(total_price) AS total_pendings FROM orders WHERE payment_status = ?");
   $select_pendings->execute(['pending']);
   $row = $select_pendings->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $total_pendings = $row['total_pendings'];
   }

   // Fetch total completed
   $select_completed = $conn->prepare("SELECT SUM(total_price) AS total_completed FROM orders WHERE payment_status = ?");
   $select_completed->execute(['completed']);
   $row = $select_completed->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $total_completed = $row['total_completed'];
   }

   // Fetch total orders
   $select_orders = $conn->prepare("SELECT COUNT(*) AS total_orders FROM orders");
   $select_orders->execute();
   $row = $select_orders->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $total_orders = $row['total_orders'];
   }

   // Fetch total products
   $select_products = $conn->prepare("SELECT COUNT(*) AS total_products FROM products");
   $select_products->execute();
   $row = $select_products->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $total_products = $row['total_products'];
   }

   // Fetch total users
   $select_users = $conn->prepare("SELECT COUNT(*) AS total_users FROM users");
   $select_users->execute();
   $row = $select_users->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $total_users = $row['total_users'];
   }

   // Fetch total admins
   $select_admins = $conn->prepare("SELECT COUNT(*) AS total_admins FROM admins");
   $select_admins->execute();
   $row = $select_admins->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $total_admins = $row['total_admins'];
   }

   // Fetch total messages
   $select_messages = $conn->prepare("SELECT COUNT(*) AS total_messages FROM messages");
   $select_messages->execute();
   $row = $select_messages->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $total_messages = $row['total_messages'];
   }
} catch (PDOException $e) {
   echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Dashboard</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<!-- Admin Header -->
<header class="header">
   <section class="flex">
      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>
      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="products.php">Products</a>
         <a href="placed_orders.php">Orders</a>
         <a href="admin_accounts.php">Admins</a>
         <a href="users_accounts.php">Users</a>
         <a href="messages.php">Messages</a>
      </nav>
      <div class="icons">
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <div class="profile">
         <p>Admin 1</p>
         <a href="update_profile.php" class="btn">Update Profile</a>
         <a href="../components/admin_logout.php" class="delete-btn">Logout</a>
      </div>
   </section>
</header>

<section class="dashboard">
   <h1 class="heading">Dashboard</h1>
   <div class="box-container">

      <div class="box">
         <h3>Welcome!</h3>
         <p>Admin 1</p>
         <a href="update_profile.php" class="btn">Update Profile</a>
      </div>

      <div class="box">
         <h3><span>R</span><?= number_format($total_pendings, 2); ?><span>/-</span></h3>
         <p>Total Pendings</p>
         <a href="placed_orders.php" class="btn">See Orders</a>
      </div>

      <div class="box">
         <h3><span>R</span><?= number_format($total_completed, 2); ?><span>/-</span></h3>
         <p>Completed Orders</p>
         <a href="placed_orders.php" class="btn">See Orders</a>
      </div>

      <div class="box">
         <h3><?= $total_orders; ?></h3>
         <p>Orders Placed</p>
         <a href="placed_orders.php" class="btn">See Orders</a>
      </div>

      <div class="box">
         <h3><?= $total_products; ?></h3>
         <p>Products Added</p>
         <a href="products.php" class="btn">See Products</a>
      </div>

      <div class="box">
         <h3><?= $total_users; ?></h3>
         <p>Normal Users</p>
         <a href="users_accounts.php" class="btn">See Users</a>
      </div>

      <div class="box">
         <h3><?= $total_admins; ?></h3>
         <p>Admin Users</p>
         <a href="admin_accounts.php" class="btn">See Admins</a>
      </div>

      <div class="box">
         <h3><?= $total_messages; ?></h3>
         <p>New Messages</p>
         <a href="messages.php" class="btn">See Messages</a>
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
