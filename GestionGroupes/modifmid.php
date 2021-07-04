<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newmid"]))
	{
		write_log("Warning : MID manquant pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un MID(module) !')
			document.location.href='CRUDgroupes.php'
			</script>";
	}
	else
	{	
		$newmid = intval(($_POST["newmid"]));
		$GID = intval($_POST["gid"]);

		// On vérifie si le module (mid) existe //
		
		$SQL = "SELECT COUNT(*) AS verif FROM modules WHERE mid=:id";
		$st = $db -> prepare($SQL);
		$st->execute(["id"=>$newmid]);
		$row = $st->fetch();

		if($row["verif"]==0)
		{
			write_log("Warning : le module (MID) saisi n'existe pas");
			unset($_POST);
			echo "<p>le module saisi n'existe pas !</p>";
			header("Refresh: 3;URL=CRUDgroupes.php");
		}
		else
		{
			$SQL = "UPDATE groupes set mid =:new WHERE gid =:id";
			$st = $db -> prepare($SQL);
			$st -> execute(["new"=>$newmid,"id"=>$GID]);

			echo "<p>Changement effectué avec succès !</p>";
			header("Refresh: 3;URL=CRUDgroupes.php");
		}
	}
?>