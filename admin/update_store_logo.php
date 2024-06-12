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

// Handle Update Requests
if (isset($_POST['update_logo'])) {
    $logo = $_FILES['logo']['name'];
    $logo_tmp_name = $_FILES['logo']['tmp_name'];
    $logo_folder = '../assets/store_logo/' . $logo;

    if ($logo == '') {
        $message[] = 'Please select a logo!';
    } else {
        move_uploaded_file($logo_tmp_name, $logo_folder);
        $update_logo = $conn->prepare("UPDATE `store_settings` SET logo = ? WHERE id = 1");
        $update_logo->execute([$logo]);
        $message[] = 'Store logo updated!';
    }
}

// Fetch Current Logo
$select_logo = $conn->prepare("SELECT logo FROM store_settings WHERE id = 1");
$select_logo->execute();
$current_logo = $select_logo->fetch(PDO::FETCH_ASSOC)['logo'];
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
    <title>Update Store Logo</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<!-- Include headers on page -->
<?php include '../components/admin_header.php'; ?>

<!-- Fields to Update and Display Logo -->
<section class="add-products">

    <h1 class="heading">Update Store Logo</h1>

    <div class="box-container">
        <div class="box">
            <h3>Update Store Logo</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="logo" class="box" required>
                <input type="submit" value="Update Logo" class="btn" name="update_logo">
            </form>
            <?php if ($current_logo): ?>
                <div>
                    <h4>Current Logo:</h4>
                    <img src="../assets/store_logo/<?= htmlspecialchars($current_logo); ?>" alt="Store Logo" style="max-width: 100%; height: auto;">
                </div>
            <?php endif; ?>
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
