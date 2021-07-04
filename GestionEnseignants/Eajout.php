<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	if(secure_exit($_POST["Enom"])||  secure_exit($_POST["Eprenom"])
	 || secure_exit($_POST["Email"])
		|| secure_exit($_POST["tel"]) || secure_exit($_POST["etid"])
		|| secure_exit($_POST["uid"]))
	{
		echo "<p> Champs manquants, veuillez compléter le formulaire
			 (Tous les champs sont obligatoires !)<br>Redirecting ...</p>";
		write_log("Champs manquants dans l'ajout d'un enseignants");
		sleep(1);
		header ("Refresh: 4;URL=AjouterEnseignants.php");

	}

	$uid = intval($_POST["uid"]);
	$nom = htmlspecialchars($_POST["Enom"]);
	$prenom = htmlspecialchars($_POST["Eprenom"]);
	$email = htmlspecialchars($_POST["Email"]);
	$tel = htmlspecialchars($_POST["tel"]);
	$etid = intval($_POST["etid"]);
	$annee = htmlspecialchars($_SESSION["year"]);
	/* Vérification que l'enseignant ajouté à bien un compte 
			utilisateur */

	require ("../db_connect.php");
	$SQL = "SELECT COUNT(*) AS verifid FROM users WHERE uid =:idnouveauenseignants";
	$st = $db -> prepare($SQL);
	$st -> execute(["idnouveauenseignants"=>$_POST["uid"]]);
	$row = $st -> fetch();

	if($row["verifid"]==0)
	{
		echo "<p>L'enseignant ajouté doit avoir un compte utilisateur !</p>";
		write_log("Compte utilisateur manquants pour ajouter l'enseignant sur la platforme");
		sleep(1);
		header ("Refresh: 4;URL=CRUDenseignants.php");
	}
	else
	{
		$SQL ="INSERT INTO enseignants VALUES(default,:uid,:nom,:prenom,:email,:tel,:etid,:annee)";
		$st = $db -> prepare($SQL);
		$st->execute(["uid"=>$uid,"nom"=>$nom,"prenom"=>$prenom,"email"=>$email,"tel"=>$tel,"etid"=>$etid,"annee"=>$annee]);
		echo "<p>Ajouté avec succès !<br>Redirecting ... </p>";
		header ("Refresh: 4;URL=CRUDenseignants.php");
	}

?>