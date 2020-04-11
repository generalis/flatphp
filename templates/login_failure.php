<!-- templates/login_failure.php -->
<?php $title = 'Private part. List of Posts' ?>

<?php ob_start() ?>
		<h1>Private part</h1>
		<a href="profile.php">Profile</a>
		<a href="logout.php">Logout</a>

		<p>Incorect login or password</p>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>
