<?php 
	
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	if(secure_exit($_POST['iduser']) || !is_numeric($_POST['iduser']))
	{	
		write_log("Problème dans le formulaire de suppression Utilisateurs");
		die("FATAL ERROR");
	}

	require "../db_connect.php";	

	$valeur = intval($_POST['iduser']);

	/*( On peut faire vérification pour que l'admin ne se supprime pas lui-même )*/
	if($idm->getUid()==$valeur)
	{
		echo "Vous ne pouvez pas vous supprimer !<br>Redirection ...";

		write_log("Delete Failure : same id".$idm->getUid());
		header ("Refresh: 2;URL=CRUDutilisateur.php");
	}
	/*****************************************************/
	else
	{
		$SQL ="DELETE FROM users WHERE uid = :id_user";
		$st = $db->prepare($SQL);
		$st -> execute(["id_user"=>$valeur]);
		sleep(1);
		header("Location: CRUDutilisateur.php");
	}
	
	



?>