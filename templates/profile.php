<?php $title = 'Private part. Profile' ?>

<?php ob_start() ?>
   <h1>Private part</h1>
   <a href="profile.php">Profile</a>
   <a href="logout.php">Logout</a>

   <h1>List of Profiles</h1>
        <?php foreach ($profiles as $profile): ?>
		<p>Your account details are below:</p>
			<table>
				<tr>
					<td>Username:</td>
					<td><?=$_SESSION['name']?></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><?=$profile['password']?></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><?=$profile['email']?></td>
				</tr>
			</table>
        <?php endforeach ?>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>

