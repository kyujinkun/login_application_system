<?php
session_start();
if (isset($_SESSION['logged_in'], $_SESSION['nickname'])) {
  header("location:user.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <!-- bootstrap -->
  <link rel="stylesheet" href="style/bootstrap.min.css" />
  <link rel="stylesheet" href="style/bootstrap.min.css.map" />
  <!-- mormalize -->
  <link rel="stylesheet" href="style/mormalize.css" />
  <!-- main css file -->
  <link rel="stylesheet" href="style/style.css" />
</head>

<body>
  <div class="container">
    <h2 class="text-center">Register</h2>
    <form action="../src/controller/register.php" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="user_name" aria-describedby="userHelp" />
        <div class="form-text" id="userHelp">
          <?php
          if (isset($_SESSION['invalid_username']) && !empty($_SESSION['invalid_username'])) {
          ?>
          <div class="alert alert-danger text-center">
            <?= $_SESSION['invalid_username'] ?>
          </div>
          <?php
          } elseif (isset($_SESSION['exist_username']) && !empty($_SESSION['exist_username'])) {
          ?>
          <div class="alert alert-danger text-center">
            <?= $_SESSION['exist_username'] ?>
          </div>
          <?php
          } else {
          ?>
          Username can contain any letters or numbers, without spaces
          <?php
          }
          unset($_SESSION['invalid_username']);
          unset($_SESSION['exist_username']);
          ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="Email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="Email" aria-describedby="emailHelp" />
        <div id="emailHelp" class="form-text helper-color">
          <?php
          if (isset($_SESSION['invalid_email']) && !empty($_SESSION['invalid_email'])) {
          ?>
          <div class="alert alert-danger text-center">
            <?= $_SESSION['invalid_email'] ?>
          </div>
          <?php
          } elseif (isset($_SESSION['exist_email']) && !empty($_SESSION['exist_email'])) {
          ?>
          <div class="alert alert-danger text-center">
            <?= $_SESSION['exist_email'] ?>
          </div>
          <?php
          } else {
          ?>
          We'll never share your email with anyone else.
          <?php
          }
          unset($_SESSION['invalid_email']);
          unset($_SESSION['exist_email']);
          ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="Password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="Password" aria-describedby="passwordHelp" />
        <div class="form-text helper-color" id="passwordHelp">
          <?php
          if (isset($_SESSION['invalid_password']) && !empty($_SESSION['invalid_password'])) {
          ?>
          <div class="alert alert-danger text-center">
            <?= $_SESSION['invalid_password'] ?>
          </div>
          <?php
            unset($_SESSION['invalid_password']);
          } else {
          ?>
          Password should be at least 4 characters
          <?php
          }
          ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="ConfirmPassword" class="form-label">Password (Confirm)</label>
        <input type="password" class="form-control" name="confirm_password" id="ConfirmPassword"
          aria-describedby="confirmHelp" />
        <div class="form-text" id="confirmHelp helper-color">
          <?php
          if (
            isset($_SESSION['invalid_confirm_password']) &&
            !empty($_SESSION['invalid_confirm_password'])
          ) {
          ?>
          <div class="alert alert-danger text-center">
            <?= $_SESSION['invalid_confirm_password'] ?>
          </div>
          <?php
            unset($_SESSION['invalid_confirm_password']);
          } else {
          ?>
          Please confirm password
          <?php
          }
          ?>
        </div>
      </div>
      <button type="submit" class="btn btn-primary fw-bold" name="submit" value="register"
        aria-describedby="confirmRegister">
        register
      </button>
      <a href="login.php"><button type="button" class="btn btn-dark fw-bold">Login</button></a>
      <?php
      if (
        isset($_SESSION['require']) &&
        !empty($_SESSION['require'])
      ) {
      ?>
      <div class="alert alert-danger text-center">
        <?= $_SESSION['require'] ?>
      </div>
      <?php
        unset($_SESSION['require']);
      }
      ?>
    </form>
  </div>

  <!-- bootstrap js file -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- main js file -->
  <script src="js/main.js"></script>
</body>

</html>
<!-- <?php //session_destroy() ?> -->