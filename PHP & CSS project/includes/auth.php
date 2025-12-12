<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__.'/../includes/Database.php';

function login_user(string $email, string $password): bool
{
    $db = Database::getInstance();
    $stmt = $db->run(
        "SELECT id, name, email, password_hash, is_admin
        FROM users
        WHERE email = :email",
        ['email' => $email]
    );

    $user = $stmt->fetch();

    if (!$user){
        //No user linked to that email
        return false;
    }

    if (!password_verify($password, $user['password_hash'])) {
        //The password is incorrect
        return false;
    }

    //Login successful -> save into sesion
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['is_admin'] = (bool)$user['is_admin'];

    return true;
}

function register_admin(string $name, string $email, string $password, string $confirm, array &$errors): bool
{
  $errors = [];

  $name = trim($name);
  $email = trim($email);

  if ($name === '') {
      $errors[] = 'Name is required.';
  }
  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'A valid email is required.';
  }
  if ($password === '') {
      $errors[] = 'Password is required.';
  } elseif (strlen($password) < 8) {
      $errors[] = 'Password must be at least 8 characters long.';
  }
  if ($password !== $confirm) {
      $errors[] = 'Passwords do not match.';
  }
  if (!empty($errors)) {
      return false;
  }

  $db = Database::getInstance();
  $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $db->run(
            "INSERT INTO users (name, email, password_hash, is_admin)
                VALUES  (:name, :email, :hash, 1)",
            [
                'name' => $name,
                'email' => $email,
                'hash' => $hash,
            ]
        );
    } catch (PDOException $e) {
        $errors[] = 'That email is already registered.';
        return false;
    }
    return true;
}
function current_user_name(): ?string
{
    return $_SESSION['user_name'] ?? null;
}

function is_admin(): bool
{
    return !empty($_SESSION['is_admin']);
}

/**
 * Only  on admmin pages
 */
function require_admin(): void
{
    if (!is_admin()) {
        header('Location: login.php');
        exit;
    }
}




















