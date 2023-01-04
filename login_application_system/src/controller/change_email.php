<?php
session_start();
require_once('../inc/connection.php');
use src\inc\connection;

$connection = new connection;
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  if (
    isset($_POST['email'], $_POST['password']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password'])
  ) {
    $password = $_POST['password'];
    $email = $_POST['email'];
    if (strlen($password) >= 4 && strlen($password) <= 16) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE username=:username");
        $stmt->execute(['username' => $_SESSION['username']]);
        if ($stmt->rowCount()) {
          foreach ($stmt->fetchAll() as $row) {
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
              $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE email=:email");
              $stmt->execute(['email' => $email]);
              if ($stmt->rowCount()) {
                echo ('Email is already exist, Pick another one');
              } else {
                $stmt = $connection->pdo->prepare("UPDATE users SET email=:email WHERE username=:username AND id=:id");
                $stmt->execute([
                  'username' => $_SESSION['username'],
                  'email' => $email,
                  'id' => $_SESSION['id']
                ]);
                if ($stmt->rowCount()) {
                  echo ('Email had been changed');
                  header("location:../../view/index.php");

                }
              }
            } else {
              echo ('password incorrect');
            }
          }
        } else {
          echo ('Username/email or password incorrect');
        }
      } else {
        echo ('Please provide valid email');
      }
    } else {
      echo ('Password Is weak');
    }
  }
} else {
  die('You need to logIn');
}