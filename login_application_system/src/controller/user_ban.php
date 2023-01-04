<?php
session_start();

require_once('../inc/connection.php');

use src\inc\connection;

$connection = new connection;

if (isset($_POST['duration'], $_POST['id']) && !empty($_POST['id']) && !empty($_POST['duration'])) {
  switch ($_POST['ban']) {
    case ($_POST['ban'] === 'Ban'):
      $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE id=:id");
      $stmt->execute(['id' => $_POST['id']]);
      if ($stmt->rowCount()) {
        $date = new DateTime(strtotime(time()));
        $date->modify('+' . $_POST['duration'] . 'Hours');
        $stmt = $connection->pdo->prepare("UPDATE users SET activated=:activated,ban_time=:ban_time,ban_duration=:ban_duration WHERE id=:id");
        $stmt->execute([
          'id' => $_POST['id'],
          'activated' => 0,
          'ban_duration' => $_POST['duration'] . 'Hours',
          'ban_time' => $date->format('Y-m-d H:i:s'),
        ]);
        if ($stmt->rowCount()) {
          $_SESSION['success'] = 'User Has been banned Successfully for ' . $_POST['duration'] . ' Hours';
          header('location:../../view/users.php');
        }
      }
      break;
    case ($_POST['ban'] === 'Un-Ban'):
      $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE id=:id");
      $stmt->execute(['id' => $_POST['id']]);
      if ($stmt->rowCount()) {
        $stmt = $connection->pdo->prepare("UPDATE users SET activated=:activated,ban_time=:ban_time,ban_duration=:ban_duration WHERE id=:id");
        $stmt->execute([
          'id' => $_POST['id'],
          'activated' => 1,
          'ban_duration' => NULL,
          'ban_time' => NULL,
        ]);
        if ($stmt->rowCount()) {
          $_SESSION['success'] = 'User Has been Un_banned Successfully';
          header('location:../../view/users.php');
        }
      }
      break;
  }

} else {
  $_SESSION['error'] = 'All inputs are requires';
  header('location:../../view/users.php');
}