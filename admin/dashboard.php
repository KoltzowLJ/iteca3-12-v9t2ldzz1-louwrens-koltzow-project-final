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
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

// Retrieves Admin ID
$admin_id = $_SESSION['admin_id'];

// Fetch Admin Name
$admin_name = '';
try {
   $select_admin = $conn->prepare("SELECT name FROM admins WHERE id = ?");
   $select_admin->execute([$admin_id]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $admin_name = $row['name'];
   }
} catch (PDOException $e) {
   echo "Error: " . $e->getMessage();
}

// Fetching Dynamic Data
$total_pendings = 0;
$total_completed = 0;
$total_orders = 0;
$total_products = 0;
$total_users = 0;
$total_admins = 0;
$total_messages = 0;
$total_categories = 0;
$store_logo = '';

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

   // Fetch total categories
   $select_categories = $conn->prepare("SELECT COUNT(*) AS total_categories FROM categories");
   $select_categories->execute();
   $row = $select_categories->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $total_categories = $row['total_categories'];
   }

   // Fetch store logo
   $select_logo = $conn->prepare("SELECT logo FROM store_settings WHERE id = 1");
   $select_logo->execute();
   $row = $select_logo->fetch(PDO::FETCH_ASSOC);
   if ($row) {
      $store_logo = $row['logo'];
   }
} catch (PDOException $e) {
   echo "Error: " . $e->getMessage();
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
   <title>Dashboard</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<!-- Include headers on page -->
<?php include '../components/admin_header.php'; ?>

<!-- Admin Dashboard Containg All Components -->
<section class="dashboard">
   <h1 class="heading">Dashboard</h1>
   <div class="box-container">

      <div class="box">
         <h3>Welcome!</h3>
         <p><?= htmlspecialchars($admin_name); ?></p>
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

      <div class="box">
         <h3><?= $total_categories; ?></h3>
         <p>Categories</p>
         <a href="update_category.php" class="btn">See Categories</a>
      </div>

      <div class="box">
         <h3>Store Logo</h3>
         <img src="../assets/store_logo/<?= htmlspecialchars($store_logo); ?>" alt="Store Logo" style="max-width: 100%; height: auto;">
         <a href="update_store_logo.php" class="btn">Update Logo</a>
      </div>

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