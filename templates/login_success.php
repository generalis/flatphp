<?php $title = 'Private part. List of Posts' ?>

<?php ob_start() ?>

  <h1>Private part</h1>
  <?php include 'priv_menu.php' ?>

  <h2>Home Page</h2>
  <p>Welcome back, <?=$_SESSION['name']?>!</p>

  <h1>You logged in</h1>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
