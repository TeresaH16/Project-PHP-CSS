<?php

require_once __DIR__.'/../includes/Database.php';

$db = Database::getInstance();

// get and validate the product ID from the URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0){
    //Invalid or missing ID
    $product = null;
} else {
    $stmt = $db->run(
        "SELECT id, name, description, price, image
        FROM products
        WHERE id = :id",
        ['id' => $id]
    );
    $product = $stmt->fetch();
}


$pageTitle = 'MyBrand - Retro Style. Modern Vibes.';
$pageDescription = 'Browse retro-inspired products, learn about MyBrand, and join the retro club.';
include 'includes/header.php';
?>

<?php if (!$product): ?>

<section class="product-hero">
    <h2>Product Not Found</h2>
    <p>Sorry, we couldn't find the product you were looking for.</p>
    <a href="shop.php" class="btn product-back-btn">Back to Shop</a>
</section>

<?php else: ?>

<section class="product-hero">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <p>Discover the details of this retro favourite from our collection.</p>
</section>

<section class="product-details-wrapper">
    <div class="product-details-image">
        <?php
            $imageFile = !empty($product['image']) ? $product['image'] : 'placeholder.jpg';
            $imagePath = 'assets/images/'.$imageFile;
        ?>
        <img src="<?= htmlspecialchars($imagePath) ?>"
             alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <div class="product-details-info">
        <h3><?= htmlspecialchars($product['name']) ?></h3>

        <p class="product-details-price">
            $<?= number_format((float) $product['price'], 2) ?>
        </p>

        <p class="product-details-description">
            <?= nl2br(htmlspecialchars($product['description'])) ?>
        </p>

        <ul class="product-details-highlights">
            <li>Authentic retro-inspired design</li>
            <li>Perfect for collectors and decor lovers</li>
            <li>Ships from Barrie, Ontario</li>
        </ul>
    </div>
</section>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
