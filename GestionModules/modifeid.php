<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["neweid"]))
	{
		write_log("Warning : EID manquant pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un EID(enseignant) !')
			document.location.href='CRUDmodule.php'
			</script>";
	}
	else
	{	
		$neweid = intval(($_POST["neweid"]));
		$MID = intval($_POST["mid"]);

		// On vérifie si l'enseignant existe //
		
		$SQL = "SELECT COUNT(*) AS verif FROM enseignants WHERE eid=:id";
		$st = $db -> prepare($SQL);
		$st->execute(["id"=>$neweid]);
		$row = $st->fetch();

		if($row["verif"]==0)
		{
			write_log("Warning : l'enseignant (EID) saisit n'existe pas");
			unset($_POST);
			echo "<p>L'enseignant saisi n'existe pas !</p>";
			header("Refresh: 3;URL=CRUDModule.php");
		}
		else
		{
			$SQL = "UPDATE modules set eid =:new WHERE mid =:id";
			$st = $db -> prepare($SQL);
			$st -> execute(["new"=>$neweid,"id"=>$MID]);

			echo "<p>Changement effectué avec succès !</p>";
			header("Refresh: 3;URL=CRUDModule.php");
		}
	}
?>