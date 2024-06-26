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
}

// Redirect to Login
if (isset($_POST['add_to_cart']) || isset($_POST['add_to_wishlist'])) {
    if (!$user_id) {
        header('Location: user_login.php');
        exit;
    }
}

// Handles Add Requests
if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$name, $user_id]);

    if ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'Already added to cart!';
    } else {
        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
        $message[] = 'Added to cart!';
    }
}

// Handles Add Requests
if (isset($_POST['add_to_wishlist'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $image = filter_var($image, FILTER_SANITIZE_STRING);

    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
    $check_wishlist_numbers->execute([$name, $user_id]);

    if ($check_wishlist_numbers->rowCount() > 0) {
        $message[] = 'Already added to wishlist!';
    } else {
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
        $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
        $message[] = 'Added to wishlist!';
    }
}

// Fetch Categories
$select_categories = $conn->prepare("SELECT * FROM `categories`");
$select_categories->execute();
$categories = $select_categories->fetchAll(PDO::FETCH_ASSOC);

// Fetched Linked Products
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
if ($category_id) {
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE category_id = ?");
    $select_products->execute([$category_id]);
} else {
    $select_products = $conn->prepare("SELECT * FROM `products`");
    $select_products->execute();
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
    <title>Shop</title>
    
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    
<!-- Include headers on page -->
<?php include 'components/user_header.php'; ?>

<!-- Display Products -->
<section class="home-products">
    <h1 class="heading">Shop</h1>

    <!-- Category Filter -->
    <form action="shop.php" method="get" class="category-filter">
        <select name="category_id" onchange="this.form.submit()">
            <option value="">All Categories</option>
            <?php
            foreach ($categories as $category) {
                echo '<option value="' . htmlspecialchars($category['id']) . '"' . ($category_id == $category['id'] ? ' selected' : '') . '>' . htmlspecialchars($category['name']) . '</option>';
            }
            ?>
        </select>
    </form>

    <div class="products-grid">
        <?php
        if ($select_products->rowCount() > 0) {
            while ($unique_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="product-card">
            <img src="assets/uploaded_images/<?= htmlspecialchars($unique_product['image_01']); ?>" alt="<?= htmlspecialchars($unique_product['name']); ?>">
            <div class="content">
                <h3><?= htmlspecialchars($unique_product['name']); ?></h3>
                <p><?= htmlspecialchars($unique_product['details']); ?></p>
                <div class="price">R<?= number_format(htmlspecialchars($unique_product['price']), 2); ?></div>
                <form action="shop.php" method="post">
                    <input type="hidden" name="pid" value="<?= htmlspecialchars($unique_product['id']); ?>">
                    <input type="hidden" name="name" value="<?= htmlspecialchars($unique_product['name']); ?>">
                    <input type="hidden" name="price" value="<?= htmlspecialchars($unique_product['price']); ?>">
                    <input type="hidden" name="image" value="<?= htmlspecialchars($unique_product['image_01']); ?>">
                    <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                    <a href="product_view_detail.php?pid=<?= htmlspecialchars($unique_product['id']); ?>" class="fas fa-eye"></a>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="1">
                    <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
                </form>
            </div>
        </div>
        <?php
            }
        } else {
            echo '<p class="empty">No products available</p>';
        }
        ?>
    </div>
</section>

<!-- Include Footer -->
<?php include 'components/footer.php'; ?>

<!-- Include JavaScript -->
<script src="assets/js/script.js"></script>


</body>
</html>
