<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
        <title><?= $title ?></title>
    </head>
    <body>
	<?php 
		if(isset($_SESSION['flashmessage']))
		{
			echo "<p>".$_SESSION['flashmessage']."</p>";
			unset($_SESSION['flashmessage']);
		}
	?>
        <?= $content ?>
    </body>
</html>
