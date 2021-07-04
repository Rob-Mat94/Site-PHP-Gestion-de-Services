<?php
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	if(secure_exit($_POST['eid'])
		|| secure_exit($_POST['gid']) || secure_exit($_POST['nbh']))
	{	
		write_log("Problème dans le formulaire de suppression d'affectation");
		die("FATAL ERROR");
	}

	require "../db_connect.php";	

	$eid = intval($_POST['eid']);
	$gid = intval($_POST['gid']);
	$nbh = intval($_POST["nbh"]);

	
	$SQL ="DELETE FROM affectations WHERE eid =:id_eid AND gid =:id_gid AND nbh =:nbh_u";
	$st = $db->prepare($SQL);
	$st -> execute(["id_eid"=>$eid,"id_gid"=>$gid,"nbh_u"=>$nbh]);
	sleep(1);
	header("Location: assignement.php");
	
?>