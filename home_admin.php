<?php 

require("auth/EtreAuthentifie.php");
if(!isset($_SESSION["year"]) && empty($_SESSION["year"]))
{
	$_SESSION["year"]="2016";
}
$annee = htmlspecialchars($_SESSION["year"]);
?>
<!DOCTYPE html>
<html>
<head class ="jumbotron text-center">
	<link href="BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="CSS/styles.css">
	<title>Home</title>
</head>

<nav name="topbar" class="navbar navbar-expand-sm bg-dark justify-content-center navbar-dark">
	<a class="navbar-brand" href="#">Tools</a>
	<ul class ="navbar-nav">
		<li class ="nav-item"><a class="nav-link" href="GestionUtilisateurs/CRUDutilisateur.php">Users Management</a></li>
		<li class ="nav-item"><a class="nav-link" href="GestionEnseignants/CRUDenseignants.php">Teacher Management</a></li>
		<li class ="nav-item"><a class="nav-link" href="GestionModules/CRUDmodule.php">Module Management</a></li> 				
		<li class ="nav-item"><a class="nav-link" href="GestionGroupes/CRUDgroupes.php">Group Management</a></li>
		<li class ="nav-item"><a class="nav-link" href="GestionGtypes/CRUDgtypes.php">Gtypes Management</a></li>
		<li class ="nav-item"><a class="nav-link" href="Assignement/assignement.php">Assignment of a group to a teacher</a></li>
	</ul>
</nav>

<body class ="container-fluid">

			<section class="row" id="TitleYear" name="Title&Year">
				<div class="col-12">
					<h1 class="Titre">Bienvenue sur la page de modération et d'administration</h1>
					<?php echo "<h2 class='Titre'>$annee</h2>"; ?>
				</div>
			</section>



			<!-- New year filter -->
			<section name="YearChose2" class="row">
				<div class="col-2 offset-10">
					<form method="post" action="changeyear.php">
				<p id="yearchoice">Choix de l'année :
					<br>
   						 <input class="btn btn-dark" type="submit" id="year"
    					 name="year" value="2016">
    					  <input class="btn btn-dark" type="submit" id="year"
    					 name="year" value="2015">
    					 </p>   
	   		
					</form>
				</div>
			</section>


			<!--------TABLEAU DE BORD ------->
			<section name ="navtab" class="row">
				<div class="col-12">
					<nav name="tabbar" class="navbar bg-light justify-content-center">
						<ul class="navbar-nav">
							<li class="nav-item"><a class ="nav-link" href="Home/EnseignantsSearch.php"><p class="pcenter">Enseignants</p></a></li>
							<li class="nav-item"><a class= "nav-link" href="Home/GroupSearch.php"><p class="pcenter">Groupes</p></a></li>
							<li class="nav-item"><a class="nav-link" href ="Home/ModulesSearch.php"><p class="pcenter">Modules</p></a></li>
							<li class="nav-item"><a class="nav-link" href ="Home/Recherche.php"><p class="pcenter">Recherche Rapide&nbsp<img src="PICTURE/loupe.png"></p></a></li>
						</ul>
					</nav>
				</div>
			</section>





			<!------------------------------- ------------------->
			<!------------------------------- ------------------->
			<!------------------------------- ------------------->

		<!-- LOGOUT -->
			<footer class= "row" id="logoutHome" name ="HomeButton">
				<div class="col-2">
					<p><a href="<?= $pathFor['logout'] ?>" title="Logout"><img class="HomeButton" src="PICTURE/exit.png" alt="Home"></a>  Déconnexion</p>
				</div>


		<!-- Nombre total des heures affecté et non affecté -->

				<div class="col-4 offset-6" name="Indications">
					<?php
						require "db_config.php";
						require "FonctionTool.php";
						require "db_connect.php";
						$HeuresAffecte = 0;
						$HeuresNonAffecte = 0;

						/* Heures affectées */
						$SQL = "SELECT SUM(affectations.nbh) AS sum FROM affectations INNER JOIN groupes ON groupes.gid = affectations.gid 
								WHERE groupes.annee =:year";
						$rq = $db->prepare($SQL);
						$rq -> execute(["year"=>$annee]);
						$Heures = $rq -> fetch();

						$HeuresAffecte = $Heures["sum"];


						/* Heures non affectées */

						$SQL = "SELECT SUM(gtypes.nbh) AS max FROM gtypes INNER JOIN groupes ON groupes.gtid = gtypes.gtid WHERE groupes.annee =:year";
						$rq = $db->prepare($SQL);
						$rq -> execute(["year"=>$annee]);
						$Heures2 = $rq -> fetch();

						$HeuresNonAffecte = $Heures2["max"] - $HeuresAffecte;
						echo "<div class=InfoHome>";
							echo "<img src='PICTURE/infohome.png'>";
							echo "&nbsp Heures non affectés : "."<strong>".$HeuresNonAffecte."</strong>&nbsp/";
							echo "&nbsp Heures affectés : "."<strong>".$HeuresAffecte."</strong>";
						echo "</div>";


					?>
				</div>
			</footer>
</body>
</html>
