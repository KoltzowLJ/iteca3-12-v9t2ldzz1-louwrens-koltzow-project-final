<?php

class ProductView {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getProductById($product_id) {
        $query = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $query->execute([$product_id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function displayProduct($product) {
        if ($product) {
            $images = [];
            if (!empty($product['image_01'])) $images[] = $product['image_01'];
            if (!empty($product['image_02'])) $images[] = $product['image_02'];
            if (!empty($product['image_03'])) $images[] = $product['image_03'];
    
            echo '<div class="product-details">';
            
            if (!empty($images)) {
                echo '<div class="product-images">';
                foreach ($images as $image) {
                    echo '<img src="assets/uploaded_images/' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($product['name']) . '">';
                }
                echo '</div>';
            }
            
            echo '
                <h1>' . htmlspecialchars($product['name']) . '</h1>
                <p>' . htmlspecialchars($product['details']) . '</p>
                <div class="price">R' . number_format($product['price'], 2) . '</div>
                <form action="" method="post">
                    <input type="hidden" name="pid" value="' . htmlspecialchars($product['id']) . '">
                    <input type="hidden" name="name" value="' . htmlspecialchars($product['name']) . '">
                    <input type="hidden" name="price" value="' . htmlspecialchars($product['price']) . '">
                    <input type="hidden" name="image_01" value="' . htmlspecialchars($product['image_01']) . '">
                    ' . (!empty($product['image_02']) ? '<input type="hidden" name="image_02" value="' . htmlspecialchars($product['image_02']) . '">' : '') . '
                    ' . (!empty($product['image_03']) ? '<input type="hidden" name="image_03" value="' . htmlspecialchars($product['image_03']) . '">' : '') . '
                    <button class="btn" type="submit" name="add_to_cart">Add to Cart</button>
                    <button class="btn" type="submit" name="add_to_wishlist">Add to Wishlist</button>
                </form>
            </div>';
        } else {
            echo '<p class="empty">Product not found!</p>';
        }
    }
    
    
    
    
}
?>
