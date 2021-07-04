<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newintitule"]))
	{
		write_log("Warning : Intitulé manquant pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un Intitulé !')
			document.location.href='CRUDmodule.php'
			</script>";
	}
	else
	{
		$newintitule = htmlspecialchars($_POST["newintitule"]);
		$MID = intval($_POST["mid"]);

		$SQL = "UPDATE modules set intitule =:new WHERE mid =:id";
		$st = $db -> prepare($SQL);
		$st -> execute(["new"=>$newintitule,"id"=>$MID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDmodule.php");
	}
?>