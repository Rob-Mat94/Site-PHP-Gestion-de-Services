<?php
		require "../auth/EtreAuthentifie.php";
		require "../db_config.php";
		require "../FonctionTool.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Analyse</title>
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
	</head>

	<!-- Barre rapide horizontale -->
	<nav name="topbar" class="navbar navbar-expand-sm bg-dark justify-content-center navbar-dark">
		<a class="navbar-brand" href="#">Tools</a>
		<ul class ="navbar-nav">
			<li class ="nav-item"><a class="nav-link" href="../GestionUtilisateurs/CRUDutilisateur.php">Users Management</a></li>
			<li class ="nav-item"><a class="nav-link" href="../GestionEnseignants/CRUDenseignants.php">Teacher Management</a></li>
			<li class ="nav-item"><a class="nav-link" href="../GestionModules/CRUDmodule.php">Module Management</a></li> 				
			<li class ="nav-item"><a class="nav-link" href="../GestionGroupes/CRUDgroupes.php">Group Management</a></li>
			<li class ="nav-item"><a class="nav-link" href="../GestionGtypes/CRUDgtypes.php">Gtypes Management</a></li>
			<li class ="nav-item"><a class="nav-link" href="../Assignement/assignement.php">Assignment of a group to a teacher</a></li>
		</ul>
	</nav>
	<!------------------------------>

	<body class="container-fluid">
	
		<h2 class="Titre2">Résultat de la recherche :</h2>

		<section class="row" name="Recherche">

			<!-- Enseignants services non complets -->
			<div class="col-6">
				<h2 class="Titre">Enseignants (Services non complets)</h2>
				
				<div class ="Affichage">
					<table class="table table-hover">
						<tr>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Téléphone</th>
							<th>Mail</th>
						</tr>
				<?php
						$annee = htmlspecialchars($_SESSION["year"]);
						/** Pour chaque enseignants **/

						$SQL ="SELECT * FROM enseignants WHERE annee=:year";
						$rq = $db->prepare($SQL);
						$rq -> execute(["year"=>$annee]);

						foreach ($rq as $row) 
						{
							//1) On prends les heures déjà attribué //
							$SQL = "SELECT SUM(nbh) AS sum from affectations WHERE 
									eid =:idenseignants";
							$st = $db->prepare($SQL);
							$st->execute(["idenseignants"=>$row["eid"]]);
							$res = $st -> fetch();
							$heures_courantes = $res["sum"];
							//
							//2) On regarde le Etype de l'enseignant //
							$SQL = "SELECT etypes.nbh AS nbh FROM etypes INNER JOIN 
									enseignants ON enseignants.etid = etypes.etid
									WHERE enseignants.eid =:idenseignants AND enseignants.annee=:year";
							$st = $db->prepare($SQL);
							$st->execute(["idenseignants"=>$row["eid"],"year"=>$annee]);
							$res2 = $st->fetch();
							$heures_max = $res2["nbh"];
							//
							$heure_restante = $heures_max - $heures_courantes;
							if($heure_restante>0)
							{
								echo "<tr>";
									echo "<td>$row[nom]</td>
										  <td>$row[prenom]</td>
										  <td>$row[tel]</td>
										  <td>$row[email]</td>
										  <td>
										  	<form method=\"post\" name=\"view\" action=\"InformationEnseignants.php\">
												<input type=\"hidden\" value=$row[eid] name=\"idenseignants\">
												<input type=image src=../PICTURE/eye.png title=\"Inspecter\">
											</form>
										  </td>
										  	 ";
								echo "</tr>";
							}
						}
							
							


					


				?>
				</table>
			</div>
		</div>

		<div class="col-6" name="InfosModules">
			<h2 class="Titre">Modules (heures non affectées)</h2>
			<div class="Affichage">
				<table class="table table-hover">
					<tr>
						<th>Intitule</th>
						<th>Code</th>
					</tr>

					<?php
						/* Sélection des modules de l'année en cours */
						$SQL = "SELECT * FROM modules WHERE annee =:year";
						$module = $db->prepare($SQL);
						$module -> execute(["year"=>$annee]);

						/* Pour chaque module on Calcul la somme totale 
							des horraires affecté de ses groupes,
							et la sum total des gtypes de ses groupes*/
						foreach ($module as $row) 
						{	
							/* Initialisation $sommetotal */
							$SommeTotalHeureDuModule = 0;
							$SommeTotalGtypesDuModules = 0;

							$SQL = "SELECT * from groupes WHERE mid=:idmodule AND annee=:year";
							$groupe = $db->prepare($SQL);
							$groupe->execute(["idmodule"=>$row["mid"],"year"=>$annee]);
							/* ON a tous les groupes du modules en cours*/
							$lastgid = -1;
							/* Pour chaque Groupe */
							foreach ($groupe as $rq) 
							{	

								/*1) On prends les heures déjà attribué */
								$SQL = "SELECT SUM(nbh) AS sum from affectations WHERE 
											gid =:idgroupe";
								$st = $db->prepare($SQL);
								$st->execute(["idgroupe"=>$rq["gid"]]);
								$resultat = $st -> fetch();
								$heures_courantes = $resultat["sum"];

								/*2) On regarde le Gtype du groupe */
									$SQL = "SELECT gtypes.nbh AS nbh FROM gtypes INNER JOIN 
											groupes ON groupes.gtid = gtypes.gtid
											WHERE groupes.gid =:idgroupe AND groupes.annee=:year";
									$st = $db->prepare($SQL);
									$st->execute(["idgroupe"=>$rq["gid"],"year"=>$annee]);
									$resultat2 = $st->fetch();
									$heures_max = $resultat2["nbh"];

									$heure_restante = $heures_max - $heures_courantes;
									/* Si le groupe actuel est différent de celui d'avant on ajoute*/
									if($lastgid!=$rq["gid"])
									{
										$SommeTotalGtypesDuModules+=$heures_max;
										$SommeTotalHeureDuModule+=$heures_courantes;
									}

									$lastgid = $rq["gid"];
							}

							if($SommeTotalHeureDuModule<$SommeTotalGtypesDuModules)
							{
								echo "<tr>";
									echo "<td>$row[intitule]</td>
										  <td>$row[code]</td>
										  <td>
												<form method=\"post\" name=\"view\" action=\"InformationModules.php\">
													<input type=\"hidden\" value=$row[mid] name=\"idmodule\">
													<input type=image src=../PICTURE/eye.png title=\"Inspecter\">
												</form>
								
										  </td>
										
										 
										  	 ";
								echo "</tr>";
							}


						}

					?>






				</table>
			</div>
		</div>



		</section>
	
	</body>
</html>