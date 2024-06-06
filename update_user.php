<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $old_pass = filter_var($_POST['old_pass'], FILTER_SANITIZE_STRING);
    $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_STRING);
    $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

    // Fetch current password from database
    $select_old_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $select_old_pass->execute([$user_id]);
    $fetch_old_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($old_pass, $fetch_old_pass['password'])) {
        $message[] = 'Old password is incorrect!';
    } else {
        if ($new_pass != $cpass) {
            $message[] = 'Confirm password does not match!';
        } else {
            if (!empty($new_pass)) {
                $update_password = password_hash($new_pass, PASSWORD_DEFAULT);
                $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ?, password = ? WHERE id = ?");
                $update_profile->execute([$name, $email, $update_password, $user_id]);
                $message[] = 'Profile updated successfully!';
            } else {
                $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
                $update_profile->execute([$name, $email, $user_id]);
                $message[] = 'Profile updated successfully!';
            }
        }
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
   <title>Update Profile</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Update Now</h3>
      <?php
      $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
      $select_profile->execute([$user_id]);
      if ($select_profile->rowCount() > 0) {
          $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box" value="<?= htmlspecialchars($fetch_profile['name']); ?>">
      <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= htmlspecialchars($fetch_profile['email']); ?>">
      <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" class="btn" name="submit">
      <?php } else { echo '<p class="empty">User not found!</p>'; } ?>
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>
