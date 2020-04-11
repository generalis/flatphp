<?php
// model.php
function open_database_connection()
{
    require_once 'config.php';

    $connection = new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME", $DATABASE_USER, $DATABASE_PASS);

    return $connection;
}

function close_database_connection(&$connection)
{
    $connection = null;
}

function get_all_posts()
{
    $connection = open_database_connection();

    $result = $connection->query('SELECT id, title FROM post');

    $posts = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $posts[] = $row;
    }
    close_database_connection($connection);

    return $posts;
}

function get_post_by_id($id)
{
    $connection = open_database_connection();

    $query = 'SELECT created_at, title, body FROM post WHERE id=:id';
    $statement = $connection->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    close_database_connection($connection);

    return $row;
}

function authenticate()
{
	session_start();
	$login_state = false;	
   	$connection = open_database_connection();

	// Now we check if the data from the login form was submitted, isset() will check if the data exists.
	if ( !isset($_POST['username'], $_POST['password']) ) {
		// Could not get the data that should have been sent.
		exit('Please fill both the username and password fields!');
	}

	// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
	if ($stmt = $connection->prepare('SELECT id, password FROM accounts WHERE username = :un')) {
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
				$login_state = true;	
			} else {
				//echo 'Incorrect password!';
				$_SESSION['flashmessage'] ='Incorrect password!'; 
			}
		} else {
			//echo 'Incorrect username!';
			$_SESSION['flashmessage'] ='Incorrect username!'; 
		}

		$connection = null;
	}

    close_database_connection($connection);

    return $login_state;
}
