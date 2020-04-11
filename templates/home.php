<?php $title = 'Private part. List of Posts' ?>

<?php ob_start() ?>

  <h1>Private part</h1>
  <?php include 'priv_menu.php' ?>

  <h2>Home Page</h2>
  <p>Welcome back, <?=$_SESSION['name']?>!</p>

  <h1>List of Posts</h1>
  <ul>
	<?php foreach ($posts as $post): ?>
	 <li>
		<a href="/flatphp/show.php?id=<?= $post['id'] ?>">
                <?= $post['title'] ?>
		</a>
	 </li>
	<?php endforeach ?>
  </ul>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
