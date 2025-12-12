<?php
require_once __DIR__.'/includes/Database.php';

$db = Database::getInstance();

//Change this before running
$name = 'Site Admin';
$email = 'admin@example.com';
$plainPassword = 'Password123!';

//Hash the password securely
$hash = password_hash($plainPassword, PASSWORD_DEFAULT);

$db->run(
    "INSERT INTO users (name, email, password_hash, is_admin)
        VALUES (:name, :email, :hash, 1)",
    [
        ':name' => $name,
        ':email' => $email,
        ':hash' => $hash
    ]
);

echo "Admin user created: $email";