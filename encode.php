<?php

if ($argv[1]) {
        echo "base64_encode(".$argv[1]."): ".base64_encode($argv[1])."\r\n";
        echo "sha1(".$argv[1]."): ".sha1($argv[1])."\r\n";
	echo "sha1(base64_encode(".$argv[1].")): ".sha1(base64_encode($argv[1]))."\r\n";
/*
	$options = [
	    'cost' => 13,
	];
	echo "password_hash(".$argv[1].", PASSWORD_BCRYPT, options): ".password_hash(".$argv[1].", PASSWORD_BCRYPT, $options)."\r\n";
*/
	echo "password_hash(".$argv[1].", PASSWORD_DEFAULT): ".password_hash(".$argv[1].", PASSWORD_DEFAULT)." \r\n";

	// See the password_hash() example to see where this came from.
	//not working
	$hash = '$2y$10$Q4vKWTjdZOCNVhOPbqTzCOazO5FwANxtXMTY1rZjEUYyw21BAHtQu';
	if (password_verify($argv[1], $hash)) echo "Password is valid!\r\n";
	else echo "Invalid password.\r\n";


	// Get the hash
	//working
	echo "crypt(".$argv[1].",$hash): ". crypt($argv[1],$hash)." \r\n";

	// See the password_hash() example to see where this came from.
	//       $2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa
	$hash = '$2y$10$Q4vKWTjdZOCNVhOPbqTzCOFXFck9Vo3zBigwJLM0QHgdqsw0Yh2LS';
	if (password_verify($argv[1], $hash)) echo "Password is valid!\r\n";
	else echo "Invalid password.\r\n";
}
else
{
	echo "podaj argument\r\n";
}
?>
