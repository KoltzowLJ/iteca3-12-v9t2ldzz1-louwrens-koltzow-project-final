<?php
// Fetch store logo from the database
$store_logo_query = $conn->prepare("SELECT logo FROM store_settings WHERE id = 1");
$store_logo_query->execute();
$store_logo = $store_logo_query->fetch(PDO::FETCH_ASSOC)['logo'];
?>

<header class="header">
    <section class="flex">
        <a href="index.php" class="logo"><img src="assets/store_logo/<?= htmlspecialchars($store_logo); ?>" alt="SimplicityTech"></a>

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
                // Fetch wishlist and cart counts
                if (isset($user_id)) {
                    $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                    $count_wishlist_items->execute([$user_id]);
                    $total_wishlist_counts = $count_wishlist_items->rowCount();

                    $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $count_cart_items->execute([$user_id]);
                    $total_cart_counts = $count_cart_items->rowCount();
                } else {
                    $total_wishlist_counts = 0;
                    $total_cart_counts = 0;
                }
            } catch (PDOException $e) {
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
            if (isset($user_id)) {
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);
                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                    echo '<p>' . htmlspecialchars($fetch_profile["name"]) . '</p>';
                    echo '<a href="update_user.php" class="btn">Update Profile</a>';
                    echo '<div class="flex-btn">
                          <a href="user_register.php" class="option-btn">Register</a>
                          <a href="user_login.php" class="option-btn">Login</a>
                          </div>';
                    echo '<a href="components/user_logout.php" class="delete-btn" onclick="return confirm(\'Logout from the website?\');">Logout</a>';
                } else {
                    echo '<p>Please login or register first!</p>';
                    echo '<div class="flex-btn">
                          <a href="user_register.php" class="option-btn">Register</a>
                          <a href="user_login.php" class="option-btn">Login</a>
                          </div>';
                }
            } else {
                echo '<p>Please login or register first!</p>';
                echo '<div class="flex-btn">
                      <a href="user_register.php" class="option-btn">Register</a>
                      <a href="user_login.php" class="option-btn">Login</a>
                      </div>';
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
