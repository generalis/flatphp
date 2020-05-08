<?php
// model.php
function open_database_connection()
{
    require 'config.php';

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

    $result = $connection->query('SELECT id, title, body, created_at FROM post');

    $posts = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $posts[] = $row;
    }
    close_database_connection($connection);

    return $posts;
}

function get_all_paginated_posts()
{
	$connection = open_database_connection();

	// find out how many rows are in the table 
	$result = $connection->query('SELECT COUNT(*) FROM post');
	$r = $result->fetch(PDO::FETCH_NUM);
	$numrows = $r[0];

	// number of rows to show per page
	//$rowsperpage = 10;
	require 'config.php';
	// find out total pages
	$totalpages = ceil($numrows / $rowsperpage);

	// get the current page or set a default
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
	   // cast var as int
	   $currentpage = (int) $_GET['currentpage'];
	} else {
	   // default page num
	   $currentpage = 1;
	} // end if

	// if current page is greater than total pages...
	if ($currentpage > $totalpages) {
	   // set current page to last page
	   $currentpage = $totalpages;
	} // end if
	// if current page is less than first page...
	if ($currentpage < 1) {
	   // set current page to first page
	   $currentpage = 1;
	} // end if

	// the offset of the list, based on current page 
	$offset = ($currentpage - 1) * $rowsperpage;
	$_SESSION['currentpage'] = $currentpage;
	$_SESSION['totalpages'] = $totalpages;


	//Our SQL query.
	$sql = "SELECT id, title, body, created_at FROM post LIMIT $offset, $rowsperpage";
 
	//Generate an MD5 hash from the SQL query above.
	$sqlCacheName = md5($sql) . ".cache";
 
	//The name of our cache folder.
	//$cache = 'cache'; //is in config.php
  
	//Full path to cache file.
	$cacheFile = $cache . "/" . $sqlCacheName;
  
	//Cache time in seconds. 60 * 60 = one hour.
	//$cacheTimeSeconds = (60 * 60); //in config.php
 
	//Our results array.
	$results = array();
 
	//If the file exists and the filemtime time is larger than
	//our cache expiry time.
	if(
	    file_exists($cacheFile) && 
	    (filemtime($cacheFile) > (time() - ($cacheTimeSeconds)))
	){
	    //$_SESSION['flashmessage'] = 'Cache file found. Use cache file instead of querying database.';
	    //Get the contents of our cached file. 
	    $fileContents = file_get_contents($cacheFile);
	    //Decode the JSON back into an array.
	    $posts = json_decode($fileContents, true);
	} else {
	    //$_SESSION['flashmessage'] = 'Valid cache file not found. Query database.';
	    //Cache file doesn't exist or has expired.
	    //Connect to MySQL using PDO.

		// get the info from the db 
		$result = $connection->query($sql);

	    	$posts = [];
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		   $posts[] = $row;
		}

	    //Convert the results into JSON so that we can save them to our cache file.
	    $resultsJSON = json_encode($posts);

	    //Save the contents to our cache file.
	    file_put_contents($cacheFile, $resultsJSON);
	}

	close_database_connection($connection);

	return $posts;
}

function get_post_by_id($id)
{
    $connection = open_database_connection();

    $query = 'SELECT id, created_at, title, body FROM post WHERE id=:id';
    $statement = $connection->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    close_database_connection($connection);

    return $row;
}

function update_post_by_id($id, $title, $body)
{
    $connection = open_database_connection();

    $query = 'UPDATE post SET title=:title, body=:body WHERE id=:id';
    $statement = $connection->prepare($query);
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':body', $body, PDO::PARAM_STR);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['flashmessage'] ='Update successful!';

    close_database_connection($connection);
}

function set_post($id, $title, $body)
{
    $connection = open_database_connection();

    $query = "INSERT INTO post (id, title, body, created_at) VALUES (NULL, :title, :body, :created_at)";
    $statement = $connection->prepare($query);
    $statement->execute([
		'title' => $title,
		'body' => $body,
		'created_at' => date("Y-m-d h:i:s")
	]);

    $_SESSION['flashmessage'] ='Insert data successful!';

    close_database_connection($connection);
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

function get_all_profiles()
{
   	$connection = open_database_connection();

	// We don't have the password or email info stored in sessions so instead we can get the results from the database.
	$stmt = $connection->prepare('SELECT password, email FROM accounts WHERE id = ?');
	// In this case we can use the account ID to get the account info.
	$stmt->bindParam(1, $_SESSION['id'],PDO::PARAM_INT);
	$stmt->execute();

	$profiles = [];
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$profiles[] = $row;
	}

	close_database_connection($connection);

	return $profiles;
}
