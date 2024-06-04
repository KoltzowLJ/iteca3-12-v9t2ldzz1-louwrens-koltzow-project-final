<?php
include '../components/connect.php';
session_start();

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, sha1($pass)]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   }else{
      $message = 'Incorrect username or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Admin Login</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<?php
if(isset($message)){
   echo '
   <div class="message">
      <span>'.$message.'</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
   </div>
   ';
}
?>

<section class="form-container">

   <form action="" method="post">
      <h3>Login Now</h3>
      <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box">
      <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="box">
      <input type="submit" value="Login Now" class="btn" name="submit">
   </form>

</section>

</body>
</html>
