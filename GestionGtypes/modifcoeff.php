<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newcoeff"]) || $_POST["newcoeff"]<=0)
	{
		write_log("Warning : Coefficient manquant ou invalide pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Coefficient manquant ou invalide !')
			document.location.href='CRUDgtypes.php'
			</script>";
	}
	else
	{	

		$newcoeff = floatval(($_POST["newcoeff"]));
		$GTID = intval($_POST["gtid"]);

		$SQL = "UPDATE gtypes set coeff =:new WHERE gtid =:id";
		$st = $db -> prepare($SQL);
		$st -> execute(["new"=>$newcoeff,"id"=>$GTID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDgtypes.php");
	}
?>