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
		$post = get_post_by_id($_GET['id']);
		require 'templates/show.php';
	}
	else
	{
		update_post_by_id($_POST['id'], $_POST['title'], $_POST['body']);
		$post = get_post_by_id($_POST['id']);
		require 'templates/show.php';
	}
