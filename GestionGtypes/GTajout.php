<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";


	/* Vérification que les champs ne sont pas vide */

	if(secure_exit($_POST["nom"]))
	{
		write_log("Champs manquants dans l'ajout d'un gtype");
		echo "<script type='text/javascript'>alert('Il faut saisir un Nom !')
			document.location.href='AjouterGtype.php'
			</script>";
	}

	else if(secure_exit($_POST["nbh"]) && !is_numeric($_POST["nbh"]))
	{
		write_log("Champs manquants dans l'ajout d'un gtype");
		echo "<script type='text/javascript'>alert('Il faut saisir un nombre d'heure !')
			document.location.href='AjouterGtype.php'
			</script>";
	}

	else if(secure_exit($_POST["coeff"]) && !is_numeric($_POST["coeff"]) ||
		$_POST["coeff"]<=0)
	{
		write_log("Champs manquants ou invalide dans l'ajout d'un gtype");
		echo "<script type='text/javascript'>alert('Coefficient manquant ou invalide !')
			document.location.href='AjouterGtype.php'
			</script>";
	}

	$nom = htmlspecialchars($_POST["nom"]);
	$nbh = intval($_POST["nbh"]);
	$coeff = floatval($_POST["coeff"]);
	
	/* Vérification que le nom saisit n'existe déjà pas */

		// pour le nom saisi //

	require("../db_connect.php");
	$SQL ="SELECT COUNT(*) AS nbname FROM gtypes WHERE nom=:nom_saisi";
	$st = $db -> prepare($SQL);
	$st -> execute(["nom_saisi"=>$nom]);
	$row = $st->fetch();

	if($row["nbname"]>=1)
	{
		write_log("Le nom saisit existe déjà");
		echo "<p>Erreur : Nom existant</p>";
		header ("Refresh: 3;URL=AjouterGtype.php");
	}
	else
	{
		$SQL ="INSERT INTO gtypes VALUES(default,:nom,:nbh,:coeff)";

		$st = $db -> prepare($SQL);
		$st->execute(["nom"=>$nom,"nbh"=>$nbh,"coeff"=>$coeff]);

		echo "<p>Ajouté avec succès !<br>Redirecting ... </p>";
		header ("Refresh: 4;URL=CRUDgtypes.php");
		
	}

	
	
?>