<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Password</title>
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
    <h1 class="text-center">Change Password</h1>
    <form action="../src/controller/change_password.php" class="w-50 mx-auto" method="POST">
      <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" class="form-control" id="current_password" name="current_password" />
      </div>
      <div class="mb-3">
        <label for="new_Password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new_Password" name="new_password" />
      </div>
      <div class="mb-3">
        <label for="confirm_Password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_Password" name="confirm_password" />
      </div>
      <button type="submit" class="btn btn-primary" name="change">
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