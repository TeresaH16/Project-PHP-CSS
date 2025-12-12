<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../includes/Database.php';

$db = Database::getInstance();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: products.php');
    exit;
}

//grab existing product
$stmt = $db->run("SELECT * FROM products WHERE id = :id", ['id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit;
}

$errors = [];
$name = $product['name'];
$description = $product['description'];
$price = (string)$product['price'];
$image = $product['image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $image       = trim($_POST['image'] ?? '');

    if ($name === '') {
        $errors[] = 'Product name is required.';
    }
    if ($description === '') {
        $errors[] = 'Description is required.';
    }
    if ($price === ''|| !is_numeric($price) || (float)$price <= 0) {
        $errors[] = 'Price must be a positive number.';
    }
    if ($image === '') {
        $errors[] = 'Image filename is required.';
    }

    if (empty($errors)) {
        $db->run(
            "UPDATE products
                SET name = :name,
                    description = :description,
                    price = :price,
                    image = :image
                WHERE id = :id",
            [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image' => $image,
                'id' => $id,
            ]
        );

        header('Location: products.php');
        exit;
    }
}

$pageTitle = 'Admin - Edit Product';
$pageDescription = 'Edit an existing product.';
include __DIR__ . '/../includes/header.php';
?>

<section class="shop-hero">
    <h2>Edit Product</h2>
    <p>Update product details.</p>
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

    <form action="edit-product.php?id=<?= (int)$id ?>" method="post" class="admin-form">
        <div class="form-group">
            <label for="name">Product Name<span>*</span></label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description<span>*</span></label>
            <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price<span>*</span></label>
            <input type="text" name="price" id="price" value="<?= htmlspecialchars($price) ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Image Filename<span>*</span></label>
            <input type="text" name="image" id="image" value="<?= htmlspecialchars($image) ?>" required>
        </div>

        <button type="submit" class="btn admin-btn">Update Product</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>

