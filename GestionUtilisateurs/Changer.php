<?php
	
	$password1 = htmlspecialchars($_POST["password"]);
	$id = intval($_POST["iduser"]);

	try
	{
		$db = new PDO($dsn,$username,$password);
    	$SQL = "UPDATE users set mdp =:new_password WHERE uid=:iduser";
    	$st = $db->prepare($SQL);
    	$st->execute(["new_password"=>password_hash($password1, PASSWORD_DEFAULT),"iduser"=>$id]);
    	echo "Mot de passe changé avec succès !<br>Redirection ...";
    	header ("Refresh: 2;URL=CRUDutilisateur.php");
	}
	catch (Exception $e)
	{	
		write_log($e->getMessage());
		die('Erreur : '.$e->getMessage());
	}

?>