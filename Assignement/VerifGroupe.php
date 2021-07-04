<?php

	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	if(!isset($_POST["gid"]) || empty($_POST["gid"]) || !is_numeric($_POST["gid"]))
	{
		error_log("Problème formulaire vérification groupe");
		die("Erreur Fatale");
	}

	$gid = $_POST["gid"];
	$annee = htmlspecialchars($_SESSION["year"]);

	/* On vérifie si le groupe a la totalité de son volume horraire affecté */

	/* On fait la somme des horraires affecté au groupe */
	require "../db_connect.php";
	$SQL1 = "SELECT SUM(nbh) AS count_nbh FROM affectations where gid =:id";
	$st = $db->prepare($SQL1);
	$st->execute(["id"=>$gid]);
	$row = $st->fetch();

	$heures_placées = $row["count_nbh"];
	if(empty($heures_placées))
	{
		$heures_placées = 0;
	}
	/* On récupère le gtid du groupe sélectionné */

	$sql = "SELECT gtid FROM groupes WHERE gid =:id AND annee=:year";
	$ft = $db->prepare($sql);
	$ft->execute(["id"=>$gid,"year"=>$annee]);
	$vh = $ft->fetch();

	$gtid = $vh["gtid"];

	/* On vérifie le volume horraire nécessaire du groupe pour comparer avec la somme précédente */

	$SQL2 ="SELECT nbh FROM gtypes WHERE gtid =:id ";
	$ft = $db->prepare($SQL2);
	$ft->execute(["id"=>$gtid,]);
	$vh = $ft->fetch();

	$volume_neccessaire = $vh["nbh"];

	if($heures_placées == $volume_neccessaire)
	{
		echo "<p>Toutes les heures ont déjà été placé pour ce groupe !</p>";
		header ("Refresh: 3;URL=AssignerGroupe.php");
	}

	/* Si il y'a possibilité de placer des heures pour un groupe
		, on affiche les enseignants pour affecter le groupe à l'un 
		d'entre eux */
	else
	{
		$heures_restantes = $volume_neccessaire - $heures_placées;

		$SQL ="SELECT * FROM enseignants WHERE annee =:year";
		$st = $db->prepare($SQL);
		$st->execute(["year"=>$annee]);

		require "SelectionEnseignant.php";
	}

?>

