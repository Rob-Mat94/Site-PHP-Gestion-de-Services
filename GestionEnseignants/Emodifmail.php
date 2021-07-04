<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newemail"]))
	{
		write_log("Warning : Email manquant pour la modification (Emodifmail.php)");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir une Adresse Mail !')
			document.location.href='CRUDenseignants.php'
			</script>";
	}
	else
	{
		$newmail = htmlspecialchars($_POST["newemail"]);
		$EID = intval($_POST["eid"]);
		$SQL = "UPDATE enseignants set email =:newmail WHERE eid =:idenseignant";
		$st = $db -> prepare($SQL);
		$st -> execute(["newmail"=>$newmail,"idenseignant"=>$EID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDenseignants.php");
	}
?>