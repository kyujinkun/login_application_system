<?php
session_start();

use src\inc\connection;

require_once('../inc/connection.php');

$connection = new connection;

if (isset($_GET) && (count($_GET) > 0)) {
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    if (preg_match('/^[0-9]*$/', $_GET['id'])) {
      $stmt = $connection->pdo->prepare("SELECT * FROM posts WHERE id=:id");
      $stmt->execute(['id' => $_GET['id']]);
      if ($stmt->rowCount()) {
        foreach ($stmt->fetchAll() as $value) {
          if ($_SESSION['id'] === $value['user_id'] || $_SESSION['privil'] === 1) {
            $_SESSION['post'] = $value;
            $_SESSION['test_id'] = $value['id'];
            header('location:../../view/edit.php');
          } else {
            $_SESSION['error'] = 'you are not authorized to edit this post';
            header('location:../../view/index.php');
          }

          //header('location:../../view/edit.php');
        }

      }

    } else {
      $_SESSION['error'] = 'ID can just had a numeric value';
      header('location:../../view/index.php');
    }
  } else {
    $_SESSION['error'] = 'The ID can\'t be empty';
    header('location:../../view/index.php');
  }
} elseif (isset($_POST) && !empty($_POST)) {
  try {
    $connection->pdo->beginTransaction();
    $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->execute(['id' => $_POST['id']]);
    if ($stmt->rowCount()) {
      if (password_verify($_POST['password'], $stmt->fetch()['password'])) {
        $stmt = $connection->pdo->prepare("UPDATE posts SET 
        title=:title,content=:content,updated_at=:updated_at 
        WHERE id=:id"
        );
        $stmt->execute([
          'title' => $_POST['title'],
          'content' => $_POST['content'],
          'updated_at' => date('Y-m-d H:i'),
          'id' => $_POST['id']
        ]);
        if ($stmt->rowCount()) {
          $_SESSION['success'] = 'Your editing has been applied successfully';
          header('location:../../view/index.php');
        } else {
          $_SESSION['error'] = 'Post title Already exists';
          header('location:../../view/index.php');
        }
      } else {
        $_SESSION['error'] = 'Password incorrect';
        header('location:../../view/index.php');
      }
    } else {
      $_SESSION['error'] = 'The id doesn\'t match';
      header('location:../../view/index.php');
    }
    $connection->pdo->commit();
  } catch (PDOException $e) {
    $connection->pdo->rollBack();
    $_SESSION['error'] = 'Post title Already exists';
    header('location:../../view/index.php');
  }

}