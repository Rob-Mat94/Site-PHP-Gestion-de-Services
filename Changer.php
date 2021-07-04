<?php
	
	$password = htmlspecialchars($_POST["password"]);
	$id = intval($_POST["iduser"]);

	try
	{
		$db = new PDO($dsn,$username,$password);
	}
	catch (Exception $e)
	{	
		write_log($e->getMessage());
		die('Erreur : '.$e->getMessage());
	}

	$SQL = "UPDATE users set mdp =:new_password WHERE uid=:iduser";
	$st = $db->prepare($SQL);
	$st->execute(["new_password"=>password_hash($password, PASSWORD_DEFAULT),"iduser"=>$id]);
	echo "mot de passe changé avec succès !";
	header ("Refresh: 5;URL=CRUDutilisateur.php");
?>