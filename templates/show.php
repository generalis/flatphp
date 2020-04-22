<?php $title = $post['title'] ?>

<?php ob_start() ?>

  <h1>Private part</h1>
  <?php include 'priv_menu.php' ?>

  <h2>Home Page</h2>
  <p>Welcome back, <?=$_SESSION['name']?>!</p>

    <?= $post['created_at'] ?>
    <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    tytuł: <input type="text" name="title" value="<?= $post['title'] ?>" required><br>
    treść: <textarea  rows="4" cols="50" name="body"><?= $post['body'] ?></textarea>
    <input type="hidden" name="id" value="<?= $post['id'] ?>"><br>
    <input type="submit" value="Zapisz">
    </form>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
