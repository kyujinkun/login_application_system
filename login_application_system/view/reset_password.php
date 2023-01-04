<?php
error_reporting(0);
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password</title>
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
    <h1 class="text-center">Reset Password</h1>
    <form action="../src/controller/reset_password.php" class="w-50 mx-auto" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" />
      </div>
      <button type="submit" class="btn btn-primary fw-bold" name="login">
        Generate password
      </button>
    </form>
  </div>

  <!-- bootstrap js file -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- main js file -->
  <script src="js/main.js"></script>
</body>

</html>