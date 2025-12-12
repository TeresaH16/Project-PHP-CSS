<?php

require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../includes/Database.php';

$db = Database::getInstance();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0){
    $db->run("DELETE FROM products WHERE id = :id", ['id' => $id]);
}

header('Location: products.php');
exit;
