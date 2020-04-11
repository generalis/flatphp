<?php $title = 'Private part. List of Posts' ?>

<?php ob_start() ?>
		<h1>Login</h1>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			Username: <input type="text" name="username" placeholder="Username" id="username" required>
			Password: <input type="password" name="password" placeholder="Password" id="password" required>
			<input type="submit" value="Login">
		</form>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
