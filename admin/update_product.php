<?php
include '../components/connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $select_products->execute([$update_id]);
    if ($select_products->rowCount() > 0) {
        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
    } else {
        header('location:products.php');
        exit();
    }
} else {
    header('location:products.php');
    exit();
}

// Handle update request
if (isset($_POST['update'])) {
    $pid = $_POST['pid'];
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ?, category_id = ? WHERE id = ?");
    $update_product->execute([$name, $price, $details, $category_id, $pid]);

    $old_image_01 = $_POST['old_image_01'];
    $old_image_02 = $_POST['old_image_02'];
    $old_image_03 = $_POST['old_image_03'];

    // Function to handle image upload
    function upload_image($image_name, $image_tmp_name, $image_folder, $old_image, $pid, $conn, $field_name) {
        if (!empty($image_name)) {
            $unique_suffix = time() . '_' . uniqid();
            $image = 'product_' . $pid . '_' . $field_name . '_' . $unique_suffix . '.' . pathinfo($image_name, PATHINFO_EXTENSION);
            $image_path = $image_folder . $image;
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                if (file_exists($image_folder . $old_image)) {
                    unlink($image_folder . $old_image);
                }
                $update_image = $conn->prepare("UPDATE `products` SET $field_name = ? WHERE id = ?");
                $update_image->execute([$image, $pid]);
                return true;
            } else {
                echo "<p class='error'>Failed to upload $image_name</p>";
                return false;
            }
        }
        return false;
    }

    $image_folder = '../assets/uploaded_images/';
    upload_image($_FILES['image_01']['name'], $_FILES['image_01']['tmp_name'], $image_folder, $old_image_01, $pid, $conn, 'image_01');
    upload_image($_FILES['image_02']['name'], $_FILES['image_02']['tmp_name'], $image_folder, $old_image_02, $pid, $conn, 'image_02');
    upload_image($_FILES['image_03']['name'], $_FILES['image_03']['tmp_name'], $image_folder, $old_image_03, $pid, $conn, 'image_03');

    $message[] = 'Product updated successfully!';
    header("Refresh:0"); // Reload the page to reflect changes
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
    <title>Update Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">
    <h1 class="heading">Update Product</h1>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<p class="message">' . htmlspecialchars($msg) . '</p>';
        }
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="pid" value="<?= htmlspecialchars($fetch_products['id']); ?>">
        <input type="hidden" name="old_image_01" value="<?= htmlspecialchars($fetch_products['image_01']); ?>">
        <input type="hidden" name="old_image_02" value="<?= htmlspecialchars($fetch_products['image_02']); ?>">
        <input type="hidden" name="old_image_03" value="<?= htmlspecialchars($fetch_products['image_03']); ?>">

        <div class="image-container">
            <div class="main-image">
                <img src="../assets/uploaded_images/<?= htmlspecialchars($fetch_products['image_01']); ?>" alt="Main Image">
            </div>
            <div class="sub-image">
                <img src="../assets/uploaded_images/<?= htmlspecialchars($fetch_products['image_01']); ?>" alt="Image 1">
                <img src="../assets/uploaded_images/<?= htmlspecialchars($fetch_products['image_02']); ?>" alt="Image 2">
                <img src="../assets/uploaded_images/<?= htmlspecialchars($fetch_products['image_03']); ?>" alt="Image 3">
            </div>
        </div>

        <span>Update Name</span>
        <input type="text" name="name" required class="box" maxlength="100" placeholder="Enter product name" value="<?= htmlspecialchars($fetch_products['name']); ?>">

        <span>Update Price</span>
        <input type="number" name="price" step="0.01" required class="box" min="0" max="9999999999" placeholder="Enter product price" value="<?= htmlspecialchars($fetch_products['price']); ?>">

        <span>Update Details</span>
        <textarea name="details" class="box" required cols="30" rows="10"><?= htmlspecialchars($fetch_products['details']); ?></textarea>

        <span>Update Category</span>
        <select name="category_id" required class="box">
            <option value="" disabled selected>Select Category</option>
            <?php
            $select_categories = $conn->prepare("SELECT * FROM `categories`");
            $select_categories->execute();
            while ($fetch_categories = $select_categories->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $fetch_categories['id'] . '"' . ($fetch_products['category_id'] == $fetch_categories['id'] ? ' selected' : '') . '>' . $fetch_categories['name'] . '</option>';
            }
            ?>
        </select>

        <span>Update Image 01</span>
        <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">

        <span>Update Image 02</span>
        <input type="file" name="image_02" accept="image/jpg, image.jpeg, image/png, image.webp" class="box">

        <span>Update Image 03</span>
        <input type="file" name="image_03" accept="image/jpg, image.jpeg, image.png, image.webp" class="box">

        <div class="flex-btn">
            <input type="submit" name="update" class="btn" value="Update">
            <a href="products.php" class="option-btn">Go Back</a>
        </div>
    </form>
</section>

<script src="../assets/js/admin_script.js"></script>

<script>
document.getElementById('user-btn').addEventListener('click', function() {
    document.querySelector('.profile').classList.toggle('active');
});
</script>

</body>
</html>
