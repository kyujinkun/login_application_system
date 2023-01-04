<?php

session_start();

require_once('../inc/connection.php');

use src\inc\connection;

$connection = new connection;

if (isset($_SESSION['privil']) && $_SESSION['privil'] === 1) {

  $stmt = $connection->pdo->prepare('SELECT * FROM users WHERE privil=:privil');
  $stmt->execute(['privil' => 0]);
  if ($stmt->rowCount()) {
    $_SESSION['users'] = $stmt->fetchAll();
    header('location:../../view/users.php');
  }
} else {
  $_SESSION['msg'] = 'You are not allowed to see the users';
  header('location:../../view/index.php');
}