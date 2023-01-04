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

    <h2 class="text-center mt-5">Posts</h2>
    <?php
    // echo ('<pre>');
    // var_dump($_SESSION);
    // echo ('</pre>');
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
      ?>
    <div class="alert alert-danger text-center">
      <?= $_SESSION['error'] ?>
    </div>
    <?php
    }
    if (count($_SESSION['users']) > 0) {
      ?>
    <form action="../src/controller/user_ban.php" method="post">
      <div class="form-group">
        <label for="ban_duration">Ban duration in hours</label>
        <select name="duration" class="mx-3">
          <?php
            for ($i = 1; $i <= 8; $i++) {
              ?>
          <option value="<?= $i ?>">
            <?= $i ?>
          </option>
          <?php
            }
            ?>
        </select>
      </div>
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Nickname</th>
            <th scope="col">Joined At</th>
            <th scope="col">Last Login Date</th>
            <th scope="col">Status User</th>
            <th scope="col">Duration</th>
          </tr>
        </thead>
        <?php
          foreach ($_SESSION['users'] as $value) {
            ?>
        <tbody>
          <tr>
            <th scope="row">
              <?= $value['id'] ?>
            </th>
            <td>
              <?= $value['username'] ?>
            </td>
            <td>
              <?= $value['nickname'] ?>
            </td>
            <td>
              <?= $value['created_at'] ?>
            </td>
            <td>
              <?= $value['last_login'] ?>
            </td>
            <td>
              <?php
                  if ($value['activated'] === 1) {
                    ?>
              <input type="hidden" name="id" value="<?= $value['id'] ?>">
              <input type="submit" name="ban" class="btn btn-danger" value="Ban">
              <?php
                  } elseif ($value['activated'] === 0) {
                    ?>
              <input type="hidden" name="id" value="<?= $value['id'] ?>">
              <input type="submit" name="ban" class="btn btn-success" value="Un-Ban">
              <?php
                  }
                  ?>
            </td>
            <td>
              <?=($value['ban_duration'] === NULL) ? '' : $value['ban_duration'] ?>
            </td>
          </tr>
        </tbody>
        <?php
          }
          ?>
      </table>
    </form>
    <?php
    } else {
      ?>
    <h2 class="text-center">No Posts to view</h2>
    <?php
    }
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
      ?>
    <div class="alert alert-success text-center"><?= $_SESSION['success'] ?></div>
    <?php
    }
    ?>
  </div>

  <!-- bootstrap js file -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- main js file -->
  <script src="js/main.js"></script>
  <?php
  unset($_SESSION['error']);
  unset($_SESSION['success']);
  ?>
</body>

</html>