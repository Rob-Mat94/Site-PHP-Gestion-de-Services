<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newprenom"]))
	{
		write_log("Warning : Prénom manquant pour la modification (Emodifprenom.php)");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un Prénom !')
			document.location.href='CRUDenseignants.php'
			</script>";
	}
	else
	{
		$newprenom = htmlspecialchars($_POST["newprenom"]);
		$EID = intval($_POST["eid"]);
		$SQL = "UPDATE enseignants set prenom =:newprenom WHERE eid =:idenseignant";
		$st = $db -> prepare($SQL);
		$st -> execute(["newprenom"=>$newprenom,"idenseignant"=>$EID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDenseignants.php");
	}
?>