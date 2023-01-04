<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Email</title>
  <!-- bootstrap -->
  <link rel="stylesheet" href="style/bootstrap.min.css" />
  <link rel="stylesheet" href="style/bootstrap.min.css.map" />
  <!-- mormalize -->
  <link rel="stylesheet" href="style/mormalize.css" />
  <!-- main css file -->
  <link rel="stylesheet" href="style/style.css" />
</head>

<body>
  <?php
  require_once('navbar.php');
  ?>
  <div class="container">
    <h1 class="text-center">Change Email</h1>
    <form action="../src/controller/change_email.php" class="w-50 mx-auto" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">New Email</label>
        <input type="text" class="form-control" id="email" name="email" />
      </div>
      <div class="mb-3">
        <label for="Password" class="form-label">Password</label>
        <input type="password" class="form-control" id="Password" name="password" />
      </div>
      <button type="submit" class="btn btn-primary" name="login">
        Submit
      </button>
    </form>
  </div>

  <!-- bootstrap js file -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- main js file -->
  <script src="js/main.js"></script>
</body>

</html>