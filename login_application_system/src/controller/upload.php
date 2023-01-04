<?php
session_start();
use src\inc\connection;

require_once('../inc/connection.php');

$connection = new connection;

if (isset($_FILES['user_image'])) {
  $file = $_FILES['user_image'];
  $file_name = $file['name'];
  $file_path = $file['full_path'];
  $file_type = $file['type'];
  $file_tmp = $file['tmp_name'];
  $file_error = $file['error'];
  $file_size = $file['size'];
  $allowedExts = ['gif', 'jpeg', 'png', 'jpg'];
  $extension = explode('.', $file_name);
  $extension = strtolower(end($extension));
  if (in_array($extension, $allowedExts)) {
    if ($file_error === 0) {
      if ($file_size <= 2 * 1024 * 1024) {
        $file_name_new = sha1(uniqid('', true)) . '.' . $extension;
        $file_destination = "../../image/$file_name_new";
        if (move_uploaded_file($file_tmp, $file_destination)) {
          $stmt = $connection->pdo->prepare("UPDATE users SET image_path=:image_path WHERE id=:id");
          $file_destination_from_user = "../image/$file_name_new";
          $stmt->execute(['id' => $_SESSION['id'], 'image_path' => $file_destination_from_user]);
          if ($stmt->rowCount()) {
            header("location:../../view/index.php");
          }
        }
      }
    }
  }
}