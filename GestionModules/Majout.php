<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";


	/* Vérification que les champs ne sont pas vide */

	if(secure_exit($_POST["intitule"]))
	{
		write_log("Champs manquants dans l'ajout d'un module (Majout.php");
		echo "<script type='text/javascript'>alert('Il faut saisir un intitulé !')
			document.location.href='AjouterModule.php'
			</script>";
	}

	else if(secure_exit($_POST["code"]))
	{
		write_log("Champs manquants dans l'ajout d'un module (Majout.php");
		echo "<script type='text/javascript'>alert('Il faut saisir un code !')
			document.location.href='AjouterModule.php'
			</script>";
	}

	else if(secure_exit($_POST["eid"]) && !is_numeric($_POST["eid"]))
	{
		write_log("Champs manquants dans l'ajout d'un module (Majout.php");
		echo "<script type='text/javascript'>alert('Enseignant manquant !')
			document.location.href='AjouterModule.php'
			</script>";
	}
	else if(secure_exit($_POST["cid"]) && !is_numeric($_POST["cid"]))
	{
		write_log("Champs manquants dans l'ajout d'un module (Majout.php");
		echo "<script type='text/javascript'>alert('Catégorie manquante !')
			document.location.href='AjouterModule.php'
			</script>";
	}

	$code = htmlspecialchars($_POST["code"]);
	$intitule = htmlspecialchars($_POST["intitule"]);
	$eid = $_POST["eid"];
	$cid = $_POST["cid"];
	$annee = htmlspecialchars($_SESSION["year"]);

	/* Vérification que l'enseignant saisit existe bien , de même pour 
		la catégorie saisie */

		// pour l'enseignant saisit //

	require("../db_connect.php");
	$SQL ="SELECT COUNT(*) AS teacher FROM enseignants WHERE eid=:id";
	$st = $db -> prepare($SQL);
	$st -> execute(["id"=>$eid]);
	$row = $st->fetch();

	if($row["teacher"]==0)
	{
		write_log("Enseignant saisit n'existe pas (Majout.php");
		echo "<p>L'enseignant saisi n'existe pas</p>";
		header ("Refresh: 3;URL=AjouterModule.php");
	}
	else
	{	
					// pour la catégorie saisite //
		
		$SQL ="SELECT COUNT(*) AS catego FROM categories WHERE cid=:id";
		$st = $db -> prepare($SQL);
		$st -> execute(["id"=>$cid]);
		$row = $st->fetch();

		if($row["catego"]==0)
		{
			write_log("La catégorie saisie n'existe pas (Majout.php");
			echo "<p>La catégorie saisie n'existe pas</p>";
			header ("Refresh: 3;URL=AjouterModule.php");
		}
		else
		{
			$SQL ="INSERT INTO modules VALUES(default,:intitule,:code,:eid,:cid,:annee)";

			$st = $db -> prepare($SQL);
			$st->execute(["intitule"=>$intitule,"code"=>$code,"eid"=>$eid,"cid"=>$cid,"annee"=>$annee]);


			echo "<p>Ajouté avec succès !<br>Redirecting ... </p>";
			header ("Refresh: 4;URL=CRUDModule.php");
		}
	}

	
	
?>