<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin(); //only admins can access

require_once __DIR__ . '/../includes/Database.php';

$db = Database::getInstance();
$products = $db->run("SELECT id, name, price, image FROM products ORDER BY id ASC")->fetchAll();


$pageTitle = 'Admin - Products';
$pageDescription = 'Admin interface for managing MyBrand products.';
include __DIR__ .  '/../includes/header.php';
?>

<section class="shop-hero">
    <h2>Admin - Products</h2>
    <p>Manage the products displayed in the shop.</p>
</section>

<section class="admin-section">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" class="admin-table-empty">
                        No products found. Add some products to the database.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= (int)$product['id'] ?>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= number_format((float)$product['price'], 2) ?></td>
                        <td><?= htmlspecialchars($product['image']) ?></td>
                        <td class="admin-table-actions">
                            <!-- CRUD links -->
                            <a href="edit-product.php?id=<?= (int)$product['id'] ?>">Edit</a>
                            <a href="delete-product.php?id=<?= (int)$product ['id'] ?>"
                               oneclick="return confirm('Are you sure you want to delete this product?');">Delete
                            </a>"
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>