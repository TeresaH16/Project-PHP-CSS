<?php

require_once __DIR__ . '/../includes/auth.php';

//If already logged in as admin, you can redirect to admin area
if (is_admin()) {
    header('Location: about/product.php');
    exit;
}

$error = '';
$success = '';
if (isset($_GET['registered']) && $_GET['registered'] == '1') {
    $success = 'Account created successfully. Pelas log in.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email   = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter both email and password';
    } else {
        if (login_user($email, $password)) {
            // Success -> go to admin products page
            header('Location: about/product.php');
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    }
}


$pageTitle = 'MyBrand - Retro Style. Modern Vibes.';
$pageDescription = 'Browse retro-inspired products, learn about MyBrand, and join the retro club.';
include 'includes/header.php';
?>


<section class="auth-hero">
    <h2>Admin Login</h2>
    <p>Sign in to manage products and update your retro collection.</p>
</section>

<section class="auth-wrapper">
    <div class="auth-card">
        <h3>Sign In</h3>

        <?php if ($error): ?>
            <p class="auth-error">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="auth-success">
                <?= htmlspecialchars($success) ?>
            </p>
        <?php endif; ?>

        <form action="login.php" method="post" class="auth-form">
            <div class="form-group">
                <label for="login-email">Email<span>*</span></label>
                <input type="email" name="login-email" id="login-email" placeholder="admin@example.com" required>
            </div>

            <div class="form-group">
                <label for="login-password">Password<span>*</span></label>
                <input type="password" name="password" id="login-password" placeholder="Your password" required>
            </div>

            <button type="submit" class="btn auth-btn">Login</button>

            <p class="auth-note">
                This area is for administrators only.
            </p>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>



















