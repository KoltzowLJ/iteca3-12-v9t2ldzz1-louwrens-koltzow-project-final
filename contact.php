<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
   exit();
}

if(isset($_POST['name'], $_POST['email'], $_POST['number'], $_POST['msg'])){
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
    $message = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);

    // Email to be sent to the user
    $to = $email;
    $subject = "Contact Form Submission - SimplicityTech";
    $body = "Hello $name,\n\nThank you for contacting us. We have received your message and will get back to you soon.\n\nYour Message:\n$message\n\nBest Regards,\nSimplicityTech Team";
    $headers = "From: no-reply@simplicitytech.co.za";

    // Email to be sent to SimplicityTech
    $admin_email = "no-reply@simplicitytech.co.za";
    $admin_subject = "New Contact Form Submission";
    $admin_body = "Name: $name\nEmail: $email\nNumber: $number\nMessage: $message";
    $admin_headers = "From: $email";

    if(mail($to, $subject, $body, $headers) && mail($admin_email, $admin_subject, $admin_body, $admin_headers)){
        $message[] = 'Your message has been sent successfully!';
    } else {
        $message[] = 'Failed to send your message. Please try again later.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message"><span>' . htmlspecialchars($msg) . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
    }
}
?>

<section class="contact">
   <form action="" method="post">
      <h3>Contact Us</h3>
      <input type="text" name="name" placeholder="Enter your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
      <input type="number" name="number" placeholder="Enter your number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Enter your message" cols="30" rows="10" required></textarea>
      <input type="submit" value="Send Message" class="btn">
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="assets/js/script.js"></script>

</body>
</html>
