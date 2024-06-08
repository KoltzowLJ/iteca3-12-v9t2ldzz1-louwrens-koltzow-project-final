<!--
    Name:       Louwrens Költzow
    Student     Number: V9T2LDZZ1
    Campus:     Pretoria
    Module:     ITECA3-B12: Project Final
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

// Handles Delete Requests
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
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
   <title>Messages</title>
   
   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<!-- Include headers on page -->
<?php include '../components/admin_header.php'; ?>

<!-- Display Messages with Ability To Delete -->
<section class="contacts">

   <h1 class="heading">Messages</h1>

   <div class="box-container">

      <?php
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p> user id : <span><?= $fetch_message['user_id']; ?></span></p>
         <p> name : <span><?= $fetch_message['name']; ?></span></p>
         <p> email : <span><?= $fetch_message['email']; ?></span></p>
         <p> number : <span><?= $fetch_message['number']; ?></span></p>
         <p> message : <span><?= $fetch_message['message']; ?></span></p>
         <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">Delete</a>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No messages available!</p>';
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
