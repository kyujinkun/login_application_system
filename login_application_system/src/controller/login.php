<?php
session_start();
use src\inc\connection;

require_once('../inc/connection.php');

$connection = new connection();

if (isset($_POST['username'], $_POST['password'], $_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (strlen($password) >= 4 && strlen($password) <= 16) {
    $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE (username=:username OR email=:email)");
    $stmt->execute(['username' => $username, 'email' => $username]);
    if ($stmt->rowCount()) {
      foreach ($stmt->fetchAll() as $value) {
        $hashed_password = $value['password'];
        if ($value['activated'] === 1) {
          if (password_verify($password, $hashed_password)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $value['username'];
            $_SESSION['email'] = $value['email'];
            $_SESSION['id'] = $value['id'];
            $_SESSION['nickname'] = $value['nickname'] ?? $_SESSION['username'];
            // ($value['nickname'] === null) ? $_SESSION['username'] : $value['nickname'];
            $_SESSION['privil'] = $value['privil'];
            $_SESSION['image'] = $value['image_path'];

            $stmt = $connection->pdo->prepare("UPDATE users SET last_login=:last_login WHERE username=:username");
            $stmt->execute([
              'last_login' => date('Y-m-d H:i:s'),
              'username' => $_SESSION['username']
            ]);
            header("location:../../view/index.php");
          } else {
            $_SESSION['incorrect_password'] = ('incorrect password');
            header("location:../../view/login.php");
          }
        } else {
          if ($value['ban_time'] >= date('Y-m-d H:i:s')) {
            $_SESSION['ban_error'] = 'You are still banned';
            header('location:../../view/login.php');
          } else {
            $stmt = $connection->pdo->prepare("UPDATE users SET activated=:activated,ban_duration=:ban_duration,ban_time=:ban_time WHERE id=:id");
            $stmt->execute([
              'id' => $value['id'],
              'activated' => 1,
              'ban_duration' => NULL,
              'ban_time' => NULL
            ]);
            if ($stmt->rowCount()) {
              $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE username=:username AND activated=:activated");
              $stmt->execute(['username' => $_POST['username'], 'activated' => 1]);
              if ($stmt->rowCount()) {
                if (password_verify($_POST['password'], $hashed_password)) {
                  $_SESSION['logged_in'] = true;
                  $_SESSION['username'] = $value['username'];
                  $_SESSION['email'] = $value['email'];
                  $_SESSION['id'] = $value['id'];
                  $_SESSION['nickname'] = $value['nickname'] ?? $_SESSION['username'];
                  // ($value['nickname'] === null) ? $_SESSION['username'] : $value['nickname'];
                  $_SESSION['image'] = $value['image_path'];
                  $_SESSION['privil'] = $value['privil'];

                  $stmt = $connection->pdo->prepare("UPDATE users SET last_login=:last_login WHERE username=:username");
                  $stmt->execute([
                    'last_login' => date('Y-m-d H:i:s'),
                    'username' => $_SESSION['username']
                  ]);
                  header("location:../../view/index.php");
                } else {
                  $_SESSION['incorrect_password'] = ('incorrect password');
                  header("location:../../view/login.php");
                }
              }
            }
          }
        }

      }
    } else {
      $_SESSION['incorrect_username'] = ('Username/Email incorrect');
      header("location:../../view/login.php");
    }
  } else {
    $invalid_password = 'Please provide a valid password';
    $_SESSION['invalid_password'] = $invalid_password;
    header("location:../../view/login.php");
  }

} else {
  $_SESSION['require'] = ('All inputs are requires');
  header("location:../../view/login.php");
}