<?php

	$login = htmlspecialchars($_POST["login"]);
	$mdp = htmlspecialchars($_POST["mdp"]);
	$role = htmlspecialchars($_POST["Rôle"]);

	require "../db_connect.php";

	/* Vérification que le login n'existe pas déjà */
	$SQL ="SELECT login FROM users WHERE login =:login";
	$st = $db->prepare($SQL);
	$st->execute(["login"=>$login]);

	$row = $st->fetch();
	if($row["login"]==$login)   
	{	
		write_log("Echec de l'ajout d'un utilisateur (login already used) : ".$idm->getUid());
		echo "<p>Login déjà utilisé !</p>";
		sleep(1);
		unset($_POST["login"]);
	}

	/* Ajout */
	else
	{
		/* HACHAGE */
		$mdp = password_hash($mdp, PASSWORD_DEFAULT);
		/**********/
		
		$SQL ="INSERT INTO users VALUES(default,:login,:mdp,:role)";
		$st = $db->prepare($SQL);
		$st->execute(["login"=>$login,"mdp"=>$mdp,"role"=>$role]);
		sleep(1);
		header("Location: CRUDutilisateur.php");
	}
?>