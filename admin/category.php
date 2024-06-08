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

// Handle Add requests
if (isset($_POST['add_category'])) {
    $category_name = filter_var($_POST['category_name'], FILTER_SANITIZE_STRING);
    $category_description = filter_var($_POST['category_description'], FILTER_SANITIZE_STRING);
    if ($category_name == '') {
        $message[] = 'Please enter a category name!';
    } else {
        $insert_category = $conn->prepare("INSERT INTO `categories`(name, description) VALUES(?, ?)");
        $insert_category->execute([$category_name, $category_description]);
        $message[] = 'New category added!';
    }
}

// Handles Delete Request
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_category = $conn->prepare("DELETE FROM `categories` WHERE id = ?");
    $delete_category->execute([$delete_id]);
    header('location:category.php');
}

// Fetch Categories
$select_categories = $conn->prepare("SELECT * FROM `categories`");
$select_categories->execute();
$categories = $select_categories->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Manage Categories</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<!-- Include headers on page -->
<?php include '../components/admin_header.php'; ?>

<!-- Display and Add Categories -->
<section class="add-products">

    <h1 class="heading">Manage Categories</h1>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message"><span>' . htmlspecialchars($msg) . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
        }
    }
    ?>

    <div class="box-container">
        <div class="box">
            <h3>Add Category</h3>
            <form action="" method="post">
                <input type="text" name="category_name" class="box" placeholder="Enter category name" required>
                <textarea name="category_description" class="box" placeholder="Enter category description" required></textarea>
                <input type="submit" value="Add Category" class="btn" name="add_category">
            </form>
        </div>

        <div class="box">
            <h3>Current Categories</h3>
            <?php
            if (count($categories) > 0) {
                foreach ($categories as $category) {
                    echo '<div class="category">' . htmlspecialchars($category['name']) . ' 
                        <a href="category.php?delete=' . $category['id'] . '" class="delete-btn" onclick="return confirm(\'Delete this category?\');">Delete</a>
                        <a href="update_category.php?edit=' . $category['id'] . '#edit-category" class="option-btn">Edit</a>
                    </div>';
                }
            } else {
                echo '<p class="empty">No categories added yet!</p>';
            }
            ?>
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
