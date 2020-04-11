<?php
 require_once 'model.php';
 
 if ($_SERVER["REQUEST_METHOD"] != "POST") {
	 require 'templates/login_form.php';
 }
 else {
	if(authenticate())
		require 'templates/login_success.php';
	else
		require 'templates/login_failure.php'; 
 }
?>

