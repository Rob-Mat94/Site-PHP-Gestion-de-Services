<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newgtid"]))
	{
		write_log("Warning : GTID manquant pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un MID(module) !')
			document.location.href='CRUDgroupes.php'
			</script>";
	}
	else
	{	
		$newgtid = intval(($_POST["newgtid"]));
		$GID = intval($_POST["gid"]);

		// On vérifie si le gtype (gtid) existe //
		
		$SQL = "SELECT COUNT(*) AS verif FROM gtypes WHERE gtid=:id";
		$st = $db -> prepare($SQL);
		$st->execute(["id"=>$newgtid]);
		$row = $st->fetch();

		if($row["verif"]==0)
		{
			write_log("Warning : le gtype (GTID) saisi n'existe pas");
			unset($_POST);
			echo "<p>le gtype saisi n'existe pas !</p>";
			header("Refresh: 3;URL=CRUDgroupes.php");
		}
		else
		{
			$SQL = "UPDATE groupes set gtid =:new WHERE gid =:id";
			$st = $db -> prepare($SQL);
			$st -> execute(["new"=>$newgtid,"id"=>$GID]);

			echo "<p>Changement effectué avec succès !</p>";
			header("Refresh: 3;URL=CRUDgroupes.php");
		}
	}
?>