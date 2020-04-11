<?php $title = 'Incorect login or password' ?>

<?php ob_start() ?>
		<h1>Login failure</h1>
		<a href="login.php">Go to login page</a>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
