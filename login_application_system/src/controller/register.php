<?php
use src\inc\connection;

session_start();
require_once('../inc/connection.php');

$connection = new connection();

if (
  (isset($_POST['user_name'], $_POST['email'], $_POST['password'])) &&
  (!empty($_POST['user_name']) && !empty($_POST['password']) && !empty($_POST['email']))
) {
  $user_name = $_POST['user_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $confirm_password = $_POST['confirm_password'];

  if (
    preg_match(
      '/^[a-z0-9-_. ]*$/i',
      $user_name
    )
  ) {
    if (strlen($password) >= 4 && strlen($password) <= 16) {
      if ($confirm_password === $password) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE username = :user_name");
          $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
          $stmt->execute();
          if ($stmt->rowCount()) {
            $existing_username = 'Username already exist,Please pick another one';
            $_SESSION['exist_username'] = $existing_username;
            header("location:../../view/register.php");
          }
          $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE email=:email");
          $stmt->bindValue(':email', $email, PDO::PARAM_STR);
          $stmt->execute();
          if ($stmt->rowCount()) {
            $existing_email = 'Email already exist,Please pick another one';
            $_SESSION['exist_email'] = $existing_email;
            header("location:../../view/register.php");
          } else {
            $stmt = $connection->pdo->prepare("INSERT INTO users (username,email,password)VALUES(:user_name,:email,:password)");
            $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount()) {
              $register_done = 'Thanks for Registering, Please go to activate your account';
              $_SESSION['register_done'] = $register_done;
              header("location:../../view/login.php");
            }
          }
        } else {
          $invalid_email = 'Please provide a valid Email';
          $_SESSION['invalid_email'] = $invalid_email;
          header("location:../../view/register.php");

        }

      } else {
        $invalid_confirm_password = 'Password confirmation doesn\'t match';
        $_SESSION['invalid_confirm_password'] = $invalid_confirm_password;
        header("location:../../view/register.php");

      }
    } else {
      $invalid_password = 'Please provide a valid password';
      $_SESSION['invalid_password'] = $invalid_password;
      header("location:../../view/register.php");

    }

  } else {
    $invalid_username = 'Please provide a valid Username';
    $_SESSION['invalid_username'] = $invalid_username;
    header("location:../../view/register.php");

  }
} else {
  $_SESSION['require'] = 'All inputs are requires';
  header("location:../../view/register.php");
}