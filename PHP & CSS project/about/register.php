<?php

require_once __DIR__ . '/../includes/auth.php';

$errors = [];
$name = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirm = $_POST["confirm_password"] ?? '';

    if (register_admin($name, $email, $password, $confirm, $errors)) {
        header('Location: login.php?registered=1');
        exit;
    }
}

$pageTitle = 'MyBrand - Retro Style. Modern Vibes.';
$pageDescription = 'Browse retro-inspired products, learn about MyBrand, and join the retro club.';
include 'includes/header.php';
?>

<section class="auth-hero">
    <h2>Create an Account</h2>
    <p>Join MyBrand to save your favourites and keep track of your retro purchases.</p>
</section>

<section class="auth-wrapper">
    <div class="auth-card">
        <h3>Register</h3>
        <form action="#" method="post" class="auth-form">
            <div class="form-group">
                <label for="reg-name">Full Name<span>*</span></label>
                <input type="text" id="reg-name" name="name" placeholder="Your Full Name" required>
            </div>

            <div class="form-group">
                <label for="reg-password">Password<span>*</span></label>
                <input type="password" id="reg-password" name="password" placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="btn auth-btn"><span>Create Account</span></button>

            <p class="auth-note">
                Already have an account?
                <a href="login.php">Log in here</a>.
            </p>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>