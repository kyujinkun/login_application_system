<?php

require_once('navbar.php');

if (!isset($_SESSION['logged_in'])) {
  header('location:login.php');
}
if (!isset($_SESSION['post']) && empty($_SESSION['post'])) {
  header('location:index.php');
}
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
  <div class="container mt-5">
    <h2 class="text-center">Edit Post</h2>
    <form method="POST" action="../src/controller/edit.php">
      <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $_SESSION['post']['title'] ?>">
        <?php
        if (isset($_SESSION['invalid_title']) && !empty($_SESSION['invalid_title'])) {
          ?>
        <div class="alert alert-danger text-center mt-3">
          <?= $_SESSION['invalid_title'] ?>
        </div>
        <?php
          unset($_SESSION['invalid_title']);
        }
        ?>
      </div>
      <div class="mb-3">
        <label class="form-label" for="content">Content:</label>
        <textarea class="form-control w-100" name="content" id="content"><?= $_SESSION['post']['content'] ?></textarea>
        <?php
        if (isset($_SESSION['invalid_content']) && !empty($_SESSION['invalid_content'])) {
          ?>
        <div class="alert alert-danger text-center mt-3">
          <?= $_SESSION['invalid_content'] ?>
        </div>
        <?php
          unset($_SESSION['invalid_content']);
        }
        ?>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <button type="submit" class="btn btn-success ">Update</button>
      <input type="hidden" name="id" value="<?= $_SESSION['post']['id'] ?>">
    </form>
    <?php
    if (isset($_SESSION['require']) && !empty($_SESSION['require'])) {
      ?>
    <div class="alert alert-danger text-center mt-3">
      <?= $_SESSION['require'] ?>
    </div>
    <?php
    } elseif (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
      ?>
    <div class="alert alert-success text-center">
      <?= $_SESSION['success'] ?>
    </div>
    <?php
    } elseif (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
      ?>
    <div class="alert alert-danger text-center">
      <?= $_SESSION['error'] ?>
    </div>
    <?php
    }
    unset($_SESSION['require']);
    unset($_SESSION['success']);
    unset($_SESSION['error']);
    unset($_SESSION['post']);
    ?>
  </div>
  <!-- bootstrap js file -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- main js file -->
  <script src="js/main.js"></script>
</body>

</html>