<!--
    Name:       Louwrens Költzow
    Student     Number: V9T2LDZZ1
    Campus:     Pretoria
    Module:     ITECA3-B12: Project Final
 -->
    

<?php
// Include Database Connection
include 'components/connect.php';

// Start Session
session_start();

// Check User Authenticaiton
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
    exit();
}

// Test
$message = []; 

// On Submit Action
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['number'], $_POST['msg'])){
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
    $message_text = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);

    // Insert Message Into Database
    try {
        $insert_message = $conn->prepare("INSERT INTO `messages` (user_id, name, email, number, message) VALUES (?, ?, ?, ?, ?)");
        $insert_message->execute([$user_id, $name, $email, $number, $message_text]);
        
        // Email Sent To User 
        $to = $email;
        $subject = "Contact Form Submission - SimplicityTech";
        $body = "Hello $name,\n\nThank you for contacting us. We have received your message and will get back to you soon.\n\nYour Message:\n$message_text\n\nBest Regards,\nSimplicityTech Team";
        $headers = "From: no-reply@simplicitytech.co.za";

        // Email Sent To Company
        $admin_email = "no-reply@simplicitytech.co.za";
        $admin_subject = "New Contact Form Submission";
        $admin_body = "Name: $name\nEmail: $email\nNumber: $number\nMessage: $message_text";
        $admin_headers = "From: $email";

        if(mail($to, $subject, $body, $headers) && mail($admin_email, $admin_subject, $admin_body, $admin_headers)){
            $message[] = 'Your message has been sent successfully!';
        } else {
            $message[] = 'Failed to send your message. Please try again later.';
        }
    } catch (PDOException $e) {
        $message[] = 'Failed to send your message. Please try again later.';
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
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<!-- Include headers on page -->
<?php include 'components/user_header.php'; ?>

<!-- Display Fields to Send Message -->
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

<!-- Include Footer -->
<?php include 'components/footer.php'; ?>

<!-- Include JavaScript -->
<script src="assets/js/script.js"></script>


</body>
</html>
