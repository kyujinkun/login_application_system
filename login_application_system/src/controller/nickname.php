<?php
use src\serialize\employer;

session_start();
require_once('../inc/connection.php');
use src\inc\connection;

$connection = new connection();

if (
  isset($_SESSION['logged_in'], $_SESSION['id'])
  && !empty($_SESSION['logged_in']) && !empty($_SESSION['id'])
) {
  if (isset($_POST['nickname'], $_POST['password']) && !empty($_POST['nickname']) && !empty($_POST['password'])) {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    if (preg_match("/^[a-z0-9 ]*$/i", $nickname)) {
      if (strlen($password) >= 4 && strlen($password) <= 16) {
        $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id' => $_SESSION['id']]);
        if ($stmt->rowCount()) {
          foreach ($stmt->fetchAll() as $value) {
            if (password_verify($password, $value['password'])) {
              $stmt = $connection->pdo->prepare("UPDATE users SET nickname=:nickname WHERE id=:id");
              $stmt->execute(['nickname' => $nickname, 'id' => $_SESSION['id']]);
              if ($stmt->rowCount()) {
                echo ("Hello $nickname");
                header("location:../../view/index.php");

              }
            } else {
              echo ('Incorrect password');

            }
          }
        } else {
          echo ('Incorrect password');
        }
      } else {
        echo ('please provide a valid password');
      }
    } else {
      echo ('Letter number and whitespace are only allowed');
    }
  } else {
    echo ('All inputs are requires');
  }
} else {
  die('You have to login');
}