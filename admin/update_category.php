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

// Handles Get Requests
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $select_category = $conn->prepare("SELECT * FROM `categories` WHERE id = ?");
    $select_category->execute([$edit_id]);
    if ($select_category->rowCount() > 0) {
        $fetch_category = $select_category->fetch(PDO::FETCH_ASSOC);
    } else {
        header('location:category.php');
        exit();
    }
} else {
    header('location:category.php');
    exit();
}

// Handles Update Requests
if (isset($_POST['update_category'])) {
    $cid = $_POST['cid'];
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    $update_category = $conn->prepare("UPDATE `categories` SET name = ?, description = ? WHERE id = ?");
    $update_category->execute([$name, $description, $cid]);

    $message[] = 'Category updated successfully!';
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
    <title>Update Category</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<!-- Include headers on page -->
<?php include '../components/admin_header.php'; ?>

<!-- Display Fields to Update Category -->
<section class="update-product">
    <h1 class="heading">Update Category</h1>

    <form action="" method="post">
        <input type="hidden" name="cid" value="<?= htmlspecialchars($fetch_category['id']); ?>">
        <span>Update Name</span>
        <input type="text" name="name" required class="box" maxlength="100" placeholder="Enter category name" value="<?= htmlspecialchars($fetch_category['name']); ?>">
        <span>Update Description</span>
        <textarea name="description" class="box" required cols="30" rows="10"><?= htmlspecialchars($fetch_category['description']); ?></textarea>
        <div class="flex-btn">
            <input type="submit" name="update_category" class="btn" value="Update">
            <a href="category.php" class="option-btn">Go Back</a>
        </div>
    </form>
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
