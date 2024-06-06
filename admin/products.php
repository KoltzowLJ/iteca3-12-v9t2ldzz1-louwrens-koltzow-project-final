<?php
include '../components/connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Handle add product request
if (isset($_POST['add_product'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

    // Ensure unique naming for each image
    function upload_image($image_name, $image_tmp_name, $image_folder, $pid, $field_name) {
        if (!empty($image_name)) {
            $unique_suffix = time() . '_' . uniqid();
            $image = 'product_' . $pid . '_' . $field_name . '_' . $unique_suffix . '.' . pathinfo($image_name, PATHINFO_EXTENSION);
            $image_path = $image_folder . $image;
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                return $image;
            } else {
                return false;
            }
        }
        return false;
    }

    $image_folder = '../assets/uploaded_images/';

    if ($name == '' || $price == '' || $details == '' || $_FILES['image_01']['name'] == '' || $_FILES['image_02']['name'] == '' || $_FILES['image_03']['name'] == '') {
        $message[] = 'Please fill out all fields!';
    } else {
        $insert_product = $conn->prepare("INSERT INTO `products` (name, price, details) VALUES (?, ?, ?)");
        $insert_product->execute([$name, $price, $details]);
        $pid = $conn->lastInsertId();

        $image_01 = upload_image($_FILES['image_01']['name'], $_FILES['image_01']['tmp_name'], $image_folder, $pid, 'image_01');
        $image_02 = upload_image($_FILES['image_02']['name'], $_FILES['image_02']['tmp_name'], $image_folder, $pid, 'image_02');
        $image_03 = upload_image($_FILES['image_03']['name'], $_FILES['image_03']['tmp_name'], $image_folder, $pid, 'image_03');

        if ($image_01 && $image_02 && $image_03) {
            $update_product_images = $conn->prepare("UPDATE `products` SET image_01 = ?, image_02 = ?, image_03 = ? WHERE id = ?");
            $update_product_images->execute([$image_01, $image_02, $image_03, $pid]);
            $message[] = 'New product added successfully!';
        } else {
            $message[] = 'Failed to upload images!';
        }
    }
}

// Handle delete request
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    if (file_exists('../assets/uploaded_images/' . $fetch_delete_image['image_01'])) {
        unlink('../assets/uploaded_images/' . $fetch_delete_image['image_01']);
    }
    if (file_exists('../assets/uploaded_images/' . $fetch_delete_image['image_02'])) {
        unlink('../assets/uploaded_images/' . $fetch_delete_image['image_02']);
    }
    if (file_exists('../assets/uploaded_images/' . $fetch_delete_image['image_03'])) {
        unlink('../assets/uploaded_images/' . $fetch_delete_image['image_03']);
    }
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    header('location:products.php');
    exit();
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
    <title>Products</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin_styles.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">
    <h1 class="heading">Add Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">
            <div class="inputBox">
                <span>Product Name (required)</span>
                <input type="text" class="box" required maxlength="100" placeholder="Enter product name" name="name">
            </div>
            <div class="inputBox">
                <span>Product Price (required)</span>
                <input type="number" step="0.01" min="0" class="box" required max="9999999999" placeholder="Enter product price" name="price">
            </div>
            <div class="inputBox">
                <span>Image 01 (required)</span>
                <input type="file" name="image_01" accept="image/*" class="box" required>
            </div>
            <div class="inputBox">
                <span>Image 02 (required)</span>
                <input type="file" name="image_02" accept="image/*" class="box" required>
            </div>
            <div class="inputBox">
                <span>Image 03 (required)</span>
                <input type="file" name="image_03" accept="image/*" class="box" required>
            </div>
            <div class="inputBox">
                <span>Product Details (required)</span>
                <textarea name="details" placeholder="Enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
            </div>
        </div>
        <input type="submit" value="Add Product" class="btn" name="add_product">
    </form>
</section>

<section class="show-products">
    <h1 class="heading">Products Added</h1>
    <div class="box-container">
        <?php
        $select_products = $conn->prepare("SELECT * FROM `products`");
        $select_products->execute();
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="box">
            <img src="../assets/uploaded_images/<?= htmlspecialchars($fetch_products['image_01']); ?>" alt="Product Image">
            <div class="name"><?= htmlspecialchars($fetch_products['name']); ?></div>
            <div class="price">R<?= htmlspecialchars($fetch_products['price']); ?></div>
            <div class="details"><?= htmlspecialchars($fetch_products['details']); ?></div>
            <div class="flex-btn">
                <a href="update_product.php?update=<?= htmlspecialchars($fetch_products['id']); ?>" class="option-btn">Update</a>
                <a href="products.php?delete=<?= htmlspecialchars($fetch_products['id']); ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
            </div>
        </div>
        <?php
            }
        } else {
            echo '<p class="empty">No products available!</p>';
        }
        ?>
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
