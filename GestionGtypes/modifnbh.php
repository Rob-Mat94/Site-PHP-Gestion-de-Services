<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newnbh"]) || !is_numeric($_POST["newnbh"]))
	{
		write_log("Warning : volume horraire manquant pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un volume horraire !')
			document.location.href='CRUDgtypes.php'
			</script>";
	}
	else
	{
		$newnbh = intval(($_POST["newnbh"]));
		$GTID = intval($_POST["gtid"]);

		$SQL = "UPDATE gtypes set nbh =:new WHERE gtid =:id";
		$st = $db -> prepare($SQL);
		$st -> execute(["new"=>$newnbh,"id"=>$GTID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDgtypes.php");
	}
?>