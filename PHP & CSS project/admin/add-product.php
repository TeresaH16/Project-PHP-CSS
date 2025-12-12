<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();

require_once __DIR__ . '/../includes/Database.php';

$db = Database::getInstance();
$errors = [];
$name = $description = $price = $image = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if ($name === '') {
        $errors[] = 'Product name is required.';
    }
    if ($description === '') {
        $errors[] = 'Description is required.';
    }
    if ($price === '' || !is_numeric($price) || (float)$price <= 0) {
        $errors[] = 'Price must be a positive number.';
    }
    if ($image === '') {
        $errors[] = 'Image filename is required (e.g. product1.jpg).';
    }
    if (empty($errors)) {
        $db->run(
            "INSERT INTO products (name, descrption, price, image)
                VALUES (:name, :description, :price, :image)",
            [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image' => $image
            ]
        );

        header('Location: products.php');
        exit;
    }
}

$pageTitle = 'Admin - Add Product';
$pageDescription = 'Add a new product to the MyBrand shop.';
include __DIR__ . '/../includes/header.php';
?>

<section class="shop-hero">
    <h2>Add Product</h2>
    <p>Create a new product for the shop.</p>
</section>

<section class="admin-section">
    <?php if (!empty($errors)): ?>
        <div class="admin-error">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="add-product.php" method="post" class="admin-form">
        <div class="form-group">
            <label for="name">Product Name<span>*</span></label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description<span>*</span></label>
            <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price<span>*</span></label>
            <input type="text" id="price" name="price" value="<?= htmlspecialchars($price) ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Image Filename<span>*</span></label>
            <input type="text" id="image" name="image" value="<?= htmlspecialchars($image) ?>" required>
        </div>

        <button type="submit" class="btn admin-btn">Save Product</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>

