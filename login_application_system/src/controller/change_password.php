<?php
session_start();
require_once('../inc/connection.php');
use src\inc\connection;

$connection = new connection;
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  if (
    isset($_POST['current_password'], $_POST['new_password'],
    $_POST['confirm_password']) &&
    !empty($_POST['current_password']) &&
    !empty($_POST['new_password']) &&
    !empty($_POST['confirm_password'])
  ) {
    $curren_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if ((strlen($curren_password) >= 4 && strlen($curren_password) <= 16) && (strlen($new_password) >= 4 && strlen($new_password) <= 16)) {
      if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE 
        username=:username OR email=:email");
        $stmt->execute([
          'username' => $_SESSION['username'],
          'email' => $_SESSION['email']
        ]);
        if ($stmt->rowCount()) {
          foreach ($stmt->fetchAll() as $value) {
            if (password_verify($curren_password, $value['password'])) {
              $stmt = $connection->pdo->prepare("UPDATE users SET password=:password WHERE (username=:username OR email=:email) AND id=:id");
              $stmt->execute([
                'password' => $hashed_password,
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email'],
                'id' => $_SESSION['id']
              ]);
              if ($stmt->rowCount()) {
                echo ('Password has been changed');
                header("location:../../view/index.php");

              } else {
                echo ('An error has occurred');
              }
            } else {
              echo ('Password incorrect');
            }
          }
        }
      } else {
        echo ('Confirmation password doesn\'t match');
      }

    } else {
      echo ('Password Is weak');
    }
  } else {
    echo ('All inputs are requires');
  }
} else {
  die('You need to logIn');
}