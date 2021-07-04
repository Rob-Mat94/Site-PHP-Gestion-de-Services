<?php 
	
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	if(secure_exit($_POST['idteacher']) || !is_numeric($_POST['idteacher']) || secure_exit($_POST['uid']) || !is_numeric($_POST['uid']))
	{	
		write_log("Problème dans le formulaire de suppression Utilisateurs");
		die("FATAL ERROR");
	}

	require "../db_connect.php";	

	$ide = intval($_POST['idteacher']);
	$uid = intval($_POST['uid']);

	/*( On peut faire vérification pour que l'admin ne se supprime pas lui-même )*/
	if($idm->getUid()==$uid)
	{
		echo "Vous ne pouvez pas vous supprimer !<br>Redirection ...";

		write_log("Delete Failure : same id : ".$idm->getUid());
		header ("Refresh: 2;URL=CRUDEnseignants.php");
	}
	/*****************************************************/
	else
	{
		$SQL ="DELETE FROM enseignants WHERE eid = :eid_user";
		$st = $db->prepare($SQL);
		$st -> execute(["eid_user"=>$ide]);
		sleep(1);
		header("Location: CRUDEnseignants.php");
	}
	
	



?>