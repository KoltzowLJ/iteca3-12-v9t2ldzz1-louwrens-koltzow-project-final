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

// Check if the form is submitted
if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admin->execute([$name]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   // Verify Credentials
   if($row && password_verify($pass, $row['password'])){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   } else {
      $message = 'Incorrect username or password!';
   }
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
   <title>Admin Login</title>

   <!-- Custom CSS file links -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/admin_styles.css">


</head>
<body>


<?php

// Display messages
if(isset($message)){
   echo '
   <div class="message">
      <span>'.$message.'</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
   </div>
   ';
}

?>

<!-- Login Form -->
<section class="login-form">
   <form action="" method="post">
      <h3>Login Now</h3>
      <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box">
      <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="box">
      <input type="submit" value="Login Now" class="btn" name="submit">
   </form>
</section>
<p class="back-link"><a href="/user_login.php" class="option-btn">Go Back</a></p>

</body>
</html>
