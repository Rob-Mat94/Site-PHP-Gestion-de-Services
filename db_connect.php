<?php

	try
	{
		$db = new PDO($dsn,$username,$password);
	}
	catch (Exception $e)
	{	
		write_log($e->getMessage());
		die('Erreur : '.$e->getMessage());
	}

?>