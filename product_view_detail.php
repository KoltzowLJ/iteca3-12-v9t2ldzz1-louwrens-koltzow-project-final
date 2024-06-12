<!--
    Name:       Louwrens Költzow
    Student     Number: V9T2LDZZ1
    Campus:     Pretoria
    Module:     ITECA3-B12: Project Final
 -->
    

<?php

// Include Database Connection
include 'components/connect.php';

// Include Detailed Product View
include 'components/product_view.php';

// Start Session
session_start();

// Check User Authenticaiton
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

$product_view = new ProductView($conn);

if (isset($_GET['pid'])) {
    $product_id = $_GET['pid'];
    $product = $product_view->getProductById($product_id);
} else {
    $product = null;
}

// Redirect to Login
if (isset($_POST['add_to_cart']) || isset($_POST['add_to_wishlist'])) {
    if (!$user_id) {
        header('Location: user_login.php');
        exit;
    }
}

// Handle Add Requests
if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image_01 = $_POST['image_01'];


    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT);
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);

    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$name, $user_id]);

    if ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'Already added to cart!';
    } else {
        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$user_id, $pid, $name, $price, $quantity, $image_01]);
        $message[] = 'Added to cart!';
    }
}

// Handle Add Requests
if (isset($_POST['add_to_wishlist'])) {
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_01 = $_POST['image_01'];

    // Sanitize input
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);

    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
    $check_wishlist_numbers->execute([$name, $user_id]);

    if ($check_wishlist_numbers->rowCount() > 0) {
        $message[] = 'Already added to wishlist!';
    } else {
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
        $insert_wishlist->execute([$user_id, $pid, $name, $price, $image_01]);
        $message[] = 'Added to wishlist!';
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
    <title>Product View</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
   
<!-- Include headers on page -->
<?php include 'components/user_header.php'; ?>

<!-- View Selected Product -->
<section class="product-view">
    <?php if ($product): ?>
        <div class="product-details">
            <div class="product-images">
                <img src="assets/uploaded_images/<?= htmlspecialchars($product['image_01']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <?php if (!empty($product['image_02'])): ?>
                    <img src="assets/uploaded_images/<?= htmlspecialchars($product['image_02']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <?php endif; ?>
                <?php if (!empty($product['image_03'])): ?>
                    <img src="assets/uploaded_images/<?= htmlspecialchars($product['image_03']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <?php endif; ?>
            </div>
            <h1><?= htmlspecialchars($product['name']); ?></h1>
            <p><?= htmlspecialchars($product['details']); ?></p>
            <div class="price">R<?= number_format(htmlspecialchars($product['price']), 2); ?></div>
            <form action="" method="post">
                <input type="hidden" name="pid" value="<?= htmlspecialchars($product['id']); ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']); ?>">
                <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']); ?>">
                <input type="hidden" name="image_01" value="<?= htmlspecialchars($product['image_01']); ?>">
                <input type="number" name="quantity" class="quantity" min="1" max="99" value="1">
                <button class="btn" type="submit" name="add_to_cart">Add to Cart</button>
                <button class="btn" type="submit" name="add_to_wishlist">Add to Wishlist</button>
            </form>
        </div>
    <?php else: ?>
        <p class="empty">Product not found!</p>
    <?php endif; ?>
</section>

<!-- Include Footer -->
<?php include 'components/footer.php'; ?>

<!-- Include JavaScript -->
<script src="assets/js/script.js"></script>


</body>
</html>
