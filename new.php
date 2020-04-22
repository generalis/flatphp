<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location: login.php');
		exit;
	}

	require_once 'model.php';

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		$post['id'] = 0;
		$post['title'] = "";
		$post['body'] = "";
		$post['created_at'] = date("Y-m-d h:i:s");
		require 'templates/show.php';
	}
	else
	{
		set_post($_POST['id'], $_POST['title'], $_POST['body']);
		$posts = get_all_posts();
		require 'templates/home.php';
	}
