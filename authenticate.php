<?php
	session_start();

	require_once 'config.php';

	$con = new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME", $DATABASE_USER, $DATABASE_PASS);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// Now we check if the data from the login form was submitted, isset() will check if the data exists.
	if ( !isset($_POST['username'], $_POST['password']) ) {
		// Could not get the data that should have been sent.
		exit('Please fill both the username and password fields!');
	}

	// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = :un')) {
		$stmt->bindParam(':un' , $_POST['username'], PDO::PARAM_STR, 50);
		$stmt->execute();
		
		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			// Account exists, now we verify the password.
			// Note: remember to use password_hash in your registration file to store the hashed passwords.
			if (password_verify($_POST['password'], $row['password'])) {
				// Verification success! User has loggedin!
				// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['id'] = $row['id'];
				header('Location: home.php');
			} else {
				echo 'Incorrect password!';
			}
		} else {
			echo 'Incorrect username!';
		}

		$con = null;
	}
?>
