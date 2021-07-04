<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newnom"]))
	{
		write_log("Warning : Nom manquant pour la modification (Emodifnom.php)");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un Nom !')
			document.location.href='CRUDenseignants.php'
			</script>";
	}
	else
	{
		$newnom = htmlspecialchars($_POST["newnom"]);
		$EID = intval($_POST["eid"]);
		$SQL = "UPDATE enseignants set nom =:newnom WHERE eid =:idenseignant";
		$st = $db -> prepare($SQL);
		$st -> execute(["newnom"=>$newnom,"idenseignant"=>$EID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDenseignants.php");
	}
?>