<?php
require_once('navbar.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome
    <?php
    if (isset($_SESSION['nickname'])) {
      echo ($_SESSION['nickname']);
    } else {
      ?>
    Guest
    <?php
    }

    ?>
  </title>
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
    <form action="../src/controller/upload.php" method="POST" enctype="multipart/form-data">
      <div class="form-group m-3">
        <label for="upload">Upload Your Profile Picture</label>
        <input type="file" name="user_image">
      </div>
      <div class="form-group m-3">
        <button type="submit" value="upload" name="submit" class="btn btn-outline-secondary">Upload</button>
      </div>
    </form>
  </div>
  <!-- bootstrap js file -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- main js file -->
  <script src="js/main.js"></script>
</body>

</html>