<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	require "../db_connect.php";

	if(secure_exit($_POST["newcode"]))
	{
		write_log("Warning : Code manquant pour la modification");
		unset($_POST);
		echo "<script type='text/javascript'>alert('Il faut saisir un Code !')
			document.location.href='CRUDmodule.php'
			</script>";
	}
	else
	{
		$newcode = htmlspecialchars($_POST["newcode"]);
		$MID = intval($_POST["mid"]);

		$SQL = "UPDATE modules set code =:new WHERE mid =:id";
		$st = $db -> prepare($SQL);
		$st -> execute(["new"=>$newcode,"id"=>$MID]);

		echo "<p>Changement effectué avec succès !</p>";
		header("Refresh: 3;URL=CRUDModule.php");
	}
?>