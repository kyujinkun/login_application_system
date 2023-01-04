<?php
require_once('../inc/connection.php');
use src\inc\connection;

$connection = new connection;

if (isset($_GET['email'], $_GET['reset_token']) && !empty($_GET['email']) && !empty($_GET['reset_token'])) {
  $stmt = $connection->pdo->prepare("SELECT email,reset_token FROM users WHERE email=:email AND reset_token=:reset_token");
  $stmt->execute([
    'email' => $_GET['email'],
    'reset_token' => $_GET['reset_token'],
  ]);
  if ($stmt->rowCount()) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
</head>

<body>
  <form action="" method="POST">
    <label for="new_password">New password: </label>
    <input type="text" name="new_password" id="new_password">
    <label for="confirm_password">Confirm password: </label>
    <input type="text" name="confirm_password" id="confirm_password">
    <button type="submit" name="reset">SUBMIT</button>
  </form>
</body>

</html>
<?php
    if (isset($_POST['new_password'], $_POST['confirm_password'])) {
      $new_password = $_POST['new_password'];
      $confirm_password = $_POST['confirm_password'];
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
      if (strlen($new_password) >= 4 && strlen($new_password) <= 16) {
        if ($new_password === $confirm_password) {
          $stmt = $connection->pdo->prepare("UPDATE users SET password=:password WHERE email=:email AND reset_token=:reset_token");
          $stmt->execute([
            'password' => $hashed_password,
            'email' => $_GET['email'],
            'reset_token' => $_GET['reset_token']
          ]);
          if ($stmt->rowCount()) {
            $stmt = $connection->pdo->prepare("UPDATE users SET reset_token=:reset_token WHERE email=:email");
            $stmt->execute([
              'reset_token' => NULL,
              'email' => $_GET['email']
            ]);
            if ($stmt->rowCount()) {
              header("location:../../view/login.php");
            }
          }
        } else {
          echo ('Confirm password doesn\'t match');
        }
      } else {
        echo ('Invalid Password');
      }
    } else {
      echo ('All input are requires');
    }

  }
} else {
  die('invalid Token');
}