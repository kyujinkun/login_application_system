<!DOCTYPE html>
<?php
require_once('navbar.php');
if (isset($_SESSION['logged_in'], $_SESSION['nickname'])) {
  header("location:user.php");
}

?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
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
    <h1 class="text-center">Login</h1>
    <form action="../src/controller/login.php" class="w-50 mx-auto" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" />
      </div>
      <?php
      if (isset($_SESSION['incorrect_username']) && !empty($_SESSION['incorrect_username'])) {
        ?>
      <div class="alert alert-danger text-center">
        <?= $_SESSION['incorrect_username'] ?>
      </div>
      <?php
        unset($_SESSION['incorrect_username']);
      }
      ?>
      <div class="mb-3">
        <label for="Password" class="form-label">Password</label>
        <input type="password" class="form-control" id="Password" name="password" />
      </div>
      <?php
      if (isset($_SESSION['incorrect_password']) && !empty($_SESSION['incorrect_password'])) {
        ?>
      <div class="alert alert-danger text-center ">
        <?= $_SESSION['incorrect_password'] ?>
      </div>
      <?php
      } elseif (isset($_SESSION['invalid_password']) && !empty($_SESSION['invalid_password'])) {
        ?>
      <div class="alert alert-danger text-center ">
        <?= $_SESSION['invalid_password'] ?>
      </div>
      <?php
      }
      unset($_SESSION['incorrect_password']);
      unset($_SESSION['invalid_password']);
      ?>
      <button type="submit" class="btn btn-primary fw-bold" name="login">
        Login
      </button>
      <a href="register.php">
        <button type="button" class="btn btn-dark fw-bold" name="login">
          Create Account
        </button></a>
      <div class="mb-3 form-text">
        <a href="reset_password.html" class="h5">Forget Password</a>
      </div>
      <?php
      if (isset($_SESSION['register_done']) && !empty($_SESSION['register_done'])) {
        ?>
      <div class="alert alert-success text-center">
        <?= $_SESSION['register_done'] ?>
      </div>
      <?php
        unset($_SESSION['register_done']);
      } elseif (isset($_SESSION['ban_error']) && !empty($_SESSION['ban_error'])) {
        ?>
      <div class="alert alert-danger text-center">
        <?= $_SESSION['ban_error'] ?>
      </div>
      <?php
      }
      unset($_SESSION['ban_error']);
      ?>
    </form>
  </div>

  <!-- bootstrap js file -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- main js file -->
  <script src="js/main.js"></script>
</body>

</html>