<?php
include '../components/connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Handle update store logo request
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

// Fetch current logo
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

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

    <h1 class="heading">Update Store Logo</h1>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message"><span>' . htmlspecialchars($msg) . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
        }
    }
    ?>

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

<script src="../assets/js/admin_script.js"></script>

<script>
document.getElementById('user-btn').addEventListener('click', function() {
   document.querySelector('.profile').classList.toggle('active');
});
</script>

</body>
</html>
