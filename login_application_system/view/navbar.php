<?php
session_start();

?>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand ms-5" href="index.php"><img src="../image/981-consultation-lineal.gif" alt="Logo"
        class="img-circle" style="max-height: 50px;max-width:50px;"></a>
    <a class="navbar-brand ms-5" href="#">
    </a>
    <button class="navbar-toggler me-5" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end mx-5" id="navbar">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <?php
          if (isset($_SESSION['logged_in'], $_SESSION['nickname'])) {
            $nickname = $_SESSION['nickname'];
            ?>
          <img src="<?=($_SESSION['image'] ?? '../image/2703062_user_account_profile_icon.png') ?>" class="img-circle"
            style="max-height:20px;max-width:20px;position:absolute;top:20%;left:-10%">
          <span class="nav-link dropdown-toggle active" role="button" data-bs-toggle="dropdown">
            <?php
              echo ("Welcome back $nickname"); ?>
          </span>
          <ul class="dropdown-menu">
            <?php
              if ($_SESSION['privil'] === 0) {
                ?>
            <li><a class="dropdown-item" href="create.php">Create A post</a></li>
            <?php
              } elseif ($_SESSION['privil'] === 1) {
                ?>
            <li><a class="dropdown-item" href="create.php">Create A post</a></li>
            <li><a class="dropdown-item" href="../src/controller/index.php">List Newest Poss</a></li>
            <li><a class="dropdown-item" href="../src/controller/users.php">List Users</a></li>
            <?php
              }
              ?>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="upload.php">Update your image</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="change_password.php">Change Your Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="change_email.php">Change Your Email</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="nickname.php">Update Your nickname</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>
        <?php

          } else {
            ?>
        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
          <?php
            echo ('Welcome Guest');
            ?>
        </a>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Create An Account</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="login.php
                                                        ">Login</a>
        </li>
        <?php
          }
          ?>
      </ul>
    </div>
  </div>
</nav>