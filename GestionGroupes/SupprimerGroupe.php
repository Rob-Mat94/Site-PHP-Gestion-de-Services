<?php 
	
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	if(secure_exit($_POST['gid']) || !is_numeric($_POST['gid']))
	{	
		write_log("Problème dans le formulaire de suppression de Groupes");
		die("FATAL ERROR");
	}

	require "../db_connect.php";	

	$gid = intval($_POST["gid"]);

	$SQL ="DELETE FROM groupes WHERE gid = :gid_delete";
	$st = $db->prepare($SQL);
	$st -> execute(["gid_delete"=>$gid]);
	sleep(1);
	header("Location: CRUDgroupes.php");
	

	



?>