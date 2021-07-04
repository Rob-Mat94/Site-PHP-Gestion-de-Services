<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newcid"]))
	{
		write_log("Warning : CID manquant pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un CID(catégorie) !')
			document.location.href='CRUDmodule.php'
			</script>";
	}
	else
	{	
		$newcid = intval(($_POST["newcid"]));
		$MID = intval($_POST["mid"]);

		// On vérifie si la catégorie existe //
		
		$SQL = "SELECT COUNT(*) AS verif FROM categories WHERE cid=:id";
		$st = $db -> prepare($SQL);
		$st->execute(["id"=>$newcid]);
		$row = $st->fetch();

		if($row["verif"]==0)
		{
			write_log("Warning : la catégorie (CID) saisie n'existe pas");
			unset($_POST);
			echo "<p>La catégorie saisie n'existe pas !</p>";
			header("Refresh: 3;URL=CRUDModule.php");
		}
		else
		{
			$SQL = "UPDATE modules set cid =:new WHERE mid =:id";
			$st = $db -> prepare($SQL);
			$st -> execute(["new"=>$newcid,"id"=>$MID]);

			echo "<p>Changement effectué avec succès !</p>";
			header("Refresh: 3;URL=CRUDModule.php");
		}
	}
?>