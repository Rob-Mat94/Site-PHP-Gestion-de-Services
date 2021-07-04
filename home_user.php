<?php
	require("auth/EtreAuthentifie.php");
	require "db_config.php";

	if(!isset($_SESSION["year"]) && empty($_SESSION["year"]))
	{
		$_SESSION["year"]="2016";
	}
	$annee = htmlspecialchars($_SESSION["year"]);

	$id = $idm->getUid();
	if(is_null($id) || empty($id) || !is_numeric($id))die("Erreur Fatale");


	/* Sélection information du l'utilisateur */
	require("db_connect.php");
	$SQL = "SELECT eid,nom,prenom FROM enseignants WHERE uid =:id AND annee=:year";
	$st = $db->prepare($SQL);
	$st->execute(["id"=>$id,"year"=>$annee]);
	$name = $st->fetch();
	$id = $name["eid"];
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
		<link href="BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="CSS/styles.css">

	</head>

	<body class ="container-fluid">
		<h1 class="Titre2">Bienvenue sur la platforme de gestion des services (<?php echo $annee ?>)</h1>

		<?php 	
				if(empty($name))
				{	echo "<div id=MissingChangePassword>";
					require("HomeChangePassword.php");
					echo "</div>";
					echo "<div id=YearChoiceMissing>";
						require("YearChoice.php");
					echo "</div>";
					echo "<h2 class=\"ErrorTitle\">Il n'y a aucune information vous concernant</h2>";
					require("pathforlogoutHomeUserError.php");


				}
				else
				{
					require("HomeUserInfos.php");

				}
		?>


	</body>
</html>