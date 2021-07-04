<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";


	/* Vérification que les champs ne sont pas vide */

	if(secure_exit($_POST["mid"])  && !is_numeric($_POST["mid"]))
	{
		write_log("Champs manquants dans l'ajout d'un module");
		echo "<script type='text/javascript'>alert('Il faut saisir un MID(module) !')
			document.location.href='AjouterGroupe.php'
			</script>";
	}

	else if(secure_exit($_POST["nom"]))
	{
		write_log("Champs manquants dans l'ajout d'un module");
		echo "<script type='text/javascript'>alert('Il faut saisir un Nom !')
			document.location.href='AjouterGroupe.php'
			</script>";
	}

	else if(secure_exit($_POST["gtid"]) && !is_numeric($_POST["gtid"]))
	{
		write_log("Champs manquants dans l'ajout d'un module");
		echo "<script type='text/javascript'>alert('GTID (gtype) manquant !')
			document.location.href='AjouterGroupe.php'
			</script>";
	}

	$mid = intval($_POST["mid"]);
	$nom = htmlspecialchars($_POST["nom"]);
	$gtid = intval($_POST["gtid"]);

	$annee = htmlspecialchars($_SESSION["year"]);

	/* Vérification que le module saisit existe bien , de même pour 
		le gtypes saisie */

		// pour le module saisit //

	require("../db_connect.php");
	$SQL ="SELECT COUNT(*) AS nmodule FROM modules WHERE mid=:id";
	$st = $db -> prepare($SQL);
	$st -> execute(["id"=>$mid]);
	$row = $st->fetch();

	if($row["nmodule"]==0)
	{
		write_log("Le module saisit n'existe pas");
		echo "<p>Le module saisi n'existe pas</p>";
		header ("Refresh: 3;URL=AjouterGroupe.php");
	}
	else
	{	
					// pour le gtypes saisi //
		
		$SQL ="SELECT COUNT(*) AS ngtype FROM gtypes WHERE gtid=:id";
		$st = $db -> prepare($SQL);
		$st -> execute(["id"=>$gtid]);
		$row = $st->fetch();

		if($row["ngtype"]==0)
		{
			write_log("Le gtype saisie n'existe pas (Majout.php");
			echo "<p>Le gtype saisie n'existe pas</p>";
			header ("Refresh: 3;URL=AjouterModule.php");
		}
		else
		{
			$SQL ="INSERT INTO groupes VALUES(default,:mid,:nom,:annee,:gtid)";

			$st = $db -> prepare($SQL);
			$st->execute(["mid"=>$mid,"nom"=>$nom,"annee"=>$annee,"gtid"=>$gtid]);


			echo "<p>Ajouté avec succès !<br>Redirecting ... </p>";
			header ("Refresh: 4;URL=CRUDgroupes.php");
		}
	}

	
	
?>