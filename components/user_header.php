<?php
// Initialize the $message variable as an array if it is not already set
if (!isset($message)) {
    $message = [];
}

// Display messages
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . htmlspecialchars($msg) . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">
    <section class="flex">
        <a href="index.php" class="logo">SimplicityTech <span></span></a>

        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="orders.php">Orders</a>
            <a href="shop.php">Shop</a>
            <a href="contact.php">Contact</a>
        </nav>

        <div class="icons">
            <?php
            try {
                // Fetch wishlist count
                if (isset($user_id)) {
                    $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                    $count_wishlist_items->execute([$user_id]);
                    $total_wishlist_counts = $count_wishlist_items->rowCount();

                    // Fetch cart count
                    $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $count_cart_items->execute([$user_id]);
                    $total_cart_counts = $count_cart_items->rowCount();
                } else {
                    $total_wishlist_counts = 0;
                    $total_cart_counts = 0;
                }
            } catch (PDOException $e) {
                // Handle database error
                echo '<div class="message"><span>Database error: ' . htmlspecialchars($e->getMessage()) . '</span></div>';
                $total_wishlist_counts = 0;
                $total_cart_counts = 0;
            }
            ?>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= htmlspecialchars($total_wishlist_counts); ?>)</span></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= htmlspecialchars($total_cart_counts); ?>)</span></a>
            <a href="#" id="user-btn"><i class="fas fa-user"></i></a>
        </div>

        <div class="profile">
            <?php
            try {
                // Fetch user profile
                if (isset($user_id)) {
                    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_profile->execute([$user_id]);
                    if ($select_profile->rowCount() > 0) {
                        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p><?= htmlspecialchars($fetch_profile["name"]); ?></p>
            <a href="update_user.php" class="btn">Update Profile</a>
            <div class="flex-btn">
                <a href="user_register.php" class="option-btn">Register</a>
                <a href="user_login.php" class="option-btn">Login</a>
            </div>
            <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('Logout from the website?');">Logout</a>
            <?php
                    } else {
            ?>
            <p>Please login or register first!</p>
            <div class="flex-btn">
                <a href="user_register.php" class="option-btn">Register</a>
                <a href="user_login.php" class="option-btn">Login</a>
            </div>
            <?php
                    }
                } else {
            ?>
            <p>Please login or register first!</p>
            <div class="flex-btn">
                <a href="user_register.php" class="option-btn">Register</a>
                <a href="user_login.php" class="option-btn">Login</a>
            </div>
            <?php
                }
            } catch (PDOException $e) {
                // Handle database error
                echo '<div class="message"><span>Database error: ' . htmlspecialchars($e->getMessage()) . '</span></div>';
            }
            ?>
        </div>
    </section>
</header>

<script>
function toggleProfile() {
    const profile = document.querySelector('.profile');
    profile.classList.toggle('active');
}

document.getElementById('user-btn').addEventListener('click', toggleProfile);
</script>
