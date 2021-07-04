 <!DOCTYPE html>
<html>
<head>
	<?php
		require "../auth/EtreAuthentifie.php";
		require "../db_config.php";
	?>

	<title>Groupes</title>
	<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
</head>

		<!--- Bar de navigation pour les Groupes ! -->
	<nav name="topbar" class="navbar navbar-expand-sm bg-dark justify-content-center navbar-dark">
		<a id="HomeButtonBar" class="navbar-brand" href="../home_admin.php"><img class="Logout" src="../PICTURE/homewhite.png" alt="Home"></a>
		<ul class ="navbar-nav">
			<li class ="nav-item"><a class="nav-link" href="../GestionUtilisateurs/CRUDutilisateur.php">Users Management</a></li>
			<li class ="nav-item"><a class="nav-link" href="../GestionEnseignants/CRUDenseignants.php">Teacher Management</a></li>
			<li class ="nav-item"><a class="nav-link" href="../GestionModules/CRUDmodule.php">Module Management</a></li> 				
			<li class ="nav-item"><a class="nav-link" href="../GestionGroupes/CRUDgroupes.php">Group Management</a></li>
			<li class ="nav-item"><a class="nav-link" href="../GestionGtypes/CRUDgtypes.php">Gtypes Management</a></li>
			<li class ="nav-item"><a class="nav-link" href="../Assignement/assignement.php">Assignment of a group to a teacher</a></li>
			<li class ="nav-item"> 
				<form class="form-inline" action="" method ="post">
				    <input class="form-control mr-sm-2" type="text" name="matiere" placeholder="Matière ...">
				    <button class="btn btn-success" type="submit">Search</button>
			 	</form>
			</li>
		</ul>
	</nav>


	<body class="container-fluid">
		<?php
			require("ListGroupes.php");
		?>
	</body>
</html>