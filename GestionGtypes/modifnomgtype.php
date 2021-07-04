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
			document.location.href='CRUDgtypes.php'
			</script>";
	}
	else
	{	
		$newnom = htmlspecialchars($_POST["newnom"]);
		$GTID = intval($_POST["gtid"]);

		/* On véririe d'abord si le nom d'existe pas déjà */
		require("../db_connect.php");
		$SQL ="SELECT COUNT(*) AS nbname FROM gtypes WHERE nom=:nom_saisi";
		$st = $db -> prepare($SQL);
		$st -> execute(["nom_saisi"=>$newnom]);
		$row = $st->fetch();


		if($row["nbname"]>=1)
		{
			write_log("Le nom saisit existe déjà");
			echo "<p>Erreur : Nom existant</p>";
			header ("Refresh: 3;URL=CRUDgtypes.php");
		}

		else
		{
			$SQL = "UPDATE gtypes set nom=:new WHERE gtid =:id";
			$st = $db -> prepare($SQL);
			$st -> execute(["new"=>$newnom,"id"=>$GTID]);

			echo "<p>Changement effectué avec succès !</p>";
			header("Refresh: 3;URL=CRUDgtypes.php");
		}
	}
?>