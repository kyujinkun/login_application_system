<?php
session_start();

use src\inc\connection;

require_once('../inc/connection.php');

$connection = new connection;
if (isset($_POST['id'], $_POST['delete']) && !empty($_POST['id'])) {
  if (preg_match('/^[0-9]*$/', $_POST['id'])) {
    $stmt = $connection->pdo->prepare("SELECT * FROM posts WHERE id=:id");
    $stmt->execute(['id' => $_POST['id']]);
    if ($stmt->rowCount()) {
      foreach ($stmt->fetchAll() as $value) {
        if ($value['user_id'] === $_SESSION['id']) {
          $stmt = $connection->pdo->prepare("DELETE FROM posts WHERE id=:id");
          $stmt->execute(['id' => $_POST['id']]);
          if ($stmt->rowCount()) {
            $id = $_POST['id'];
            $_SESSION['success'] = "Post $id has been deleted successfully";
            header('location:../../view/index.php');
          } else {
            $_SESSION['error'] = 'Unknowing error please try again';
            header('location:../../view/index.php');
          }
        } else {
          $_SESSION['error'] = 'You are not authorized to delete this post';
          header('location:../../view/index.php');
        }
      }
    } else {
      $_SESSION['error'] = 'You are not authorized to delete this post';
      header('location:../../view/index.php');
    }
  } else {
    $_SESSION['error'] = 'Unknowing ID';
    header('location:../../view/index.php');
  }
} else {
  $_SESSION['error'] = 'you need to select a post to delete it';
  header('location:../../view/index.php');
}