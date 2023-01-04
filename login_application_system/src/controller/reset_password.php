<?php
use src\inc\connection;

require_once('../inc/connection.php');

$connection = new connection();

if (
  isset($_POST['username'], $_POST['email'], $_POST['login'])
  && !empty($_POST['username']) && !empty($_POST['email'])
) {
  $username = $_POST['username'];
  $email = $_POST['email'];

  if (preg_match("/^[a-z0-9-_. ]*$/i", $username)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $stmt = $connection->pdo->prepare("SELECT * FROM users WHERE username=:username AND email=:email");
      $stmt->execute([
        'username' => $username,
        'email' => $email
      ]);
      if ($stmt->rowCount()) {
        $stmt = $connection->pdo->prepare("UPDATE users SET reset_token=:reset_token WHERE username=:username AND email=:email");
        $stmt->execute([
          'reset_token' => sha1(uniqid('', true)) . sha1(date('Y-m-d H:i')),
          'username' => $username,
          'email' => $email
        ]);
        if ($stmt->rowCount()) {
          $stmt = $connection->pdo->prepare("SELECT email,reset_token FROM users WHERE username=:username AND email=:email");
          $stmt->execute(['email' => $email, 'username' => $username]);
          if ($stmt->rowCount()) {
            foreach ($stmt->fetchAll() as $value) { ?>
<a href="password_recovery.php?email=<?= $value['email']; ?>&reset_token=<?= $value['reset_token']; ?>">
  Click here to reset your password</a>
<?php }
          }

        }
      } else {
        echo ('Username/email incorrect');
      }
    } else {
      echo ('Please provide a valid email');
    }

  } else {
    echo ('Please provide a valid username');
  }
} else {
  echo ('All inputs are requires');
}