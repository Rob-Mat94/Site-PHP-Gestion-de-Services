<?php 
	
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	if(secure_exit($_POST['mid']) || !is_numeric($_POST['mid']))
	{	
		write_log("Problème dans le formulaire de suppression de Modules");
		die("FATAL ERROR");
	}

	require "../db_connect.php";	

	$mid = intval($_POST["mid"]);

	$SQL ="DELETE FROM modules WHERE mid = :mid_delete";
	$st = $db->prepare($SQL);
	$st -> execute(["mid_delete"=>$mid]);
	sleep(1);
	header("Location: CRUDmodule.php");
	

	



?>