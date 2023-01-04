<?php
session_start();
require_once('../inc/connection.php');
use src\inc\connection;

$connection = new connection;

if (
  isset($_POST['title'], $_POST['content']) &&
  (!empty($_POST['title']) && (!empty($_POST['content'])))
) {
  if (ctype_alpha($_POST['title'])) {
    $stmt = $connection->pdo->prepare("INSERT INTO posts(user_id,username,title,content) VALUES (:user_id,:username,:title,:content)");
    $stmt->execute([
      'user_id' => $_SESSION['id'],
      'username' => $_SESSION['username'],
      'title' => $_POST['title'],
      'content' => $_POST['content']
    ]);
    if ($stmt->rowCount()) {
      $_SESSION['success'] = 'Post Has been added successfully';
      header("location:../../view/create.php");
    } else {
      $_SESSION['error'] = 'An error applied';
      header("location:../../view/create.php");
    }
  } else {
    $_SESSION['invalid_title'] = 'Title should contain only letters';
    header("location:../../view/create.php");
  }
} else {
  $_SESSION['require'] = 'All inputs are requires';
  header("location:../../view/create.php");
}