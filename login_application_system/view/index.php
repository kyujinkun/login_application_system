<?php
use src\serialize\employer;

require_once('navbar.php');
require_once('../src/inc/connection.php');

use src\inc\connection;

$connection = new connection;

$stmt = $connection->pdo->prepare("SELECT * FROM posts");

$stmt->execute();

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
    if ($stmt->rowCount()) {
      ?>
    <table class="table mt-3">
      <thead>
        <tr>
          <?php
            if ($_SESSION['privil'] === 1) {
              ?>
          <th scope="col">#</th>
          <?php
            }
            ?>
          <th scope="col">Title</th>
          <th scope="col">Body</th>
          <?php
            if ($_SESSION['privil'] === 1) {
              ?>
          <th scope="col">status</th>
          <?php
            }
            ?>
          <th scope="col">Edit Post</th>
          <th scope="col">Delete Post</th>
        </tr>
      </thead>
      <?php
        foreach ($stmt->fetchAll() as $value) {
          ?>
      <tbody>
        <tr>
          <?php
              if ($_SESSION['privil'] === 1) {
                ?>
          <th scope="row">
            <?= $value['id'] ?>
          </th>
          <?php
              }
              ?>
          <td>
            <?= $value['title'] ?>
          </td>
          <td>
            <?= $value['content'] ?>
          </td>
          <?php
              if ($_SESSION['privil'] === 1) {
                ?>
          <td>
            <?=($value['approved'] === 0) ? 'Not Approved yet' : 'Approved' ?>
          </td> <?php
              }
              ?>
          <td>
            <button class="btn btn-primary btn-sm">
              <a href="../src/controller/edit.php?id=<?= $value['id'] ?>" class="nav-link text-light ">Edit Post</a>
            </button>
          </td>
          <td>
            <form action="../src/controller/delete.php" method="post">
              <input type="hidden" name="id" value="<?= $value['id'] ?>">
              <button type="submit" class="btn btn-danger btn-sm" name="delete">Delete</button>
            </form>
          </td>
        </tr>
      </tbody>
      <?php
        }
        ?>
    </table>
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