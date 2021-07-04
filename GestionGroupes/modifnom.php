<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newnom"]))
	{
		write_log("Warning : Nom manquant pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un Nom !')
			document.location.href='CRUDgroupes.php'
			</script>";
	}
	else
	{
		$newnom = htmlspecialchars($_POST["newnom"]);
		$GID = intval($_POST["gid"]);

		$SQL = "UPDATE groupes set nom =:new WHERE gid =:id";
		$st = $db -> prepare($SQL);
		$st -> execute(["new"=>$newnom,"id"=>$GID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDgroupes.php");
	}
?>