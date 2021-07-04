<!DOCTYPE html>
<html>

	<head>
		<title>SupprimerGtype</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>

	</body>

</html>



<?php 
	
	require "../auth/EtreAuthentifie.php";
	require "../db_config.php";
	require "../FonctionTool.php";

	if(secure_exit($_POST['idmodif']) || !is_numeric($_POST['idmodif']) || secure_exit($_SESSION["year"]))
	{	
		write_log("Problème dans le formulaire de suppression de Groupes");
		die("FATAL ERROR");
	}


	/* On vérifie si le type de groupe n'est pas utilisé, si le type est utilisé, la suppression est impossible */
	require "../db_connect.php";	

	$gtid = intval($_POST["idmodif"]);
	$annee = htmlspecialchars($_SESSION["year"]);

	$SQL="SELECT COUNT(*) AS n FROM groupes WHERE gtid=:idmodif";
	$st = $db->prepare($SQL);
	$st -> execute(["idmodif"=>$gtid]);
	$row = $st -> fetch();

	if($row["n"]>=1)
	{
		write_log("Impossible de supprimer le groupe");
		echo "
			<div class ='alert alert-warning'>
			<p><strong>ATTENTION : Opération impossible</strong> ce type de groupe est actuellement utilisé</p>
			</div>";

		header ("Refresh: 3;URL=CRUDgtypes.php");

	}

	else
	{
		$SQL ="DELETE FROM gtypes WHERE gtid = :delete";
		$st = $db->prepare($SQL);
		$st -> execute(["delete"=>$gtid]);
		sleep(1);
		header("Location: CRUDgtypes.php");
	}

	

	



?>