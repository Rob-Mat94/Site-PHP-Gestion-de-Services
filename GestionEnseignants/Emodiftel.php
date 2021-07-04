<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newtel"]))
	{
		write_log("Warning : Numéro de téléphone invalide (Emodiftel.php)");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un numéro de téléphone !')
			document.location.href='CRUDenseignants.php'
			</script>";
	}
	else if(strlen($_POST["newtel"])<9)			
	{	
		write_log("Warning : Numéro de téléphone invalide (Emodiftel.php)");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Numéro de téléphone invalide !')
			document.location.href='CRUDenseignants.php'
			</script>";
	}
	else
	{
		$newtel = htmlspecialchars($_POST["newtel"]);	
		$EID = intval($_POST["eid"]);
		$SQL = "UPDATE enseignants set tel =:newtel WHERE eid =:idenseignant";
		$st = $db -> prepare($SQL);
		$st -> execute(["newtel"=>$newtel,"idenseignant"=>$EID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDenseignants.php");
	}
?>