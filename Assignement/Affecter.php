
<!DOCTYPE html>
<html>
<head>
	<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
</head>
</html>



<?php

	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	/* on regarde la somme des heures dans la table affectation puis on compare avec le etypes de l'enseignant sélectionné*/
	
	if(secure_exit($_POST["eid"]) || secure_exit($_POST["gid"]) || secure_exit($_POST["nbheures"]) || !is_numeric($_POST["nbheures"]))
	{
		die("erreur fatal, champs manquants ou inexistants");
	}

	$eid = $_POST["eid"];
	$nbheures = $_POST["nbheures"];
	$gid = $_POST["gid"];

	require ("../db_connect.php");

	/* On effectue une revérification */
	//  1) On sélectionne le nombre d'heure déjà attribué au prof
	$SQL = "SELECT SUM(nbh) AS counth FROM affectations WHERE eid =:idenseignant";
	$st = $db -> prepare($SQL);
	$st -> execute(["idenseignant"=>$eid]);
	$row = $st->fetch();

	$nombre_heure_actuel = $row["counth"];
	if(empty($nombre_heure_actuel))
	{
		$nombre_heure_actuel = 0;
	}

	//  2) On regarde son etype sur la table
	$SQL2 = "SELECT nbh FROM etypes INNER JOIN enseignants ON enseignants.etid = etypes.etid WHERE enseignants.eid =:eid AND enseignants.annee=:year ";
	$st = $db -> prepare($SQL2);
	$st -> execute(["eid"=>$eid,"year"=>htmlspecialchars($_SESSION["year"])]);
	$row = $st->fetch();
	$nombre_heure_max = $row["nbh"];

	if($nombre_heure_actuel+$nbheures > $nombre_heure_max)
	{	
		$nberror = $nombre_heure_max - $nombre_heure_actuel;
		echo "<p>Affectation Impossible, vous ne pouvez attribuer plus de $nberror heure(s) à cet enseignant</p>";
		header ("Refresh: 3;URL=assignement.php");
	}
	else
	{	
		$SQL = "INSERT INTO affectations VALUES(:eid,:gid,:nbh)";
		$st = $db -> prepare($SQL);
		$st -> execute(["eid"=>$eid,"gid"=>$gid,"nbh"=>$nbheures]);
		echo "<div class='alert alert-success' id='log'><strong>L'affectation</strong> a été réalisé avec succès !</div>";
		header ("Refresh: 3;URL=assignement.php");
	}





















?>