<?php
		require "../auth/EtreAuthentifie.php";
		require "../db_config.php";
		require "../db_connect.php";
		require "../FonctionTool.php";

		if(secure_exit($_POST["idmodule"]) || !is_numeric($_POST["idmodule"]))
		{
			die("Erreur Fatale");
		}
		$sommeTotal = 0;
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
		<title>Informations Modules</title>
	</head>

	<body class ="container-fluid">
		<?php 
			$idmodule = intval($_POST["idmodule"]);
			$annee = htmlspecialchars($_SESSION["year"]);
		?>
		<?php
		
			
				$SQL = "SELECT intitule FROM modules WHERE mid =:id AND annee=:year";
				$rq = $db -> prepare($SQL);
				$rq -> execute(["id" => $idmodule, "year"=>$annee]);
				$row = $rq -> fetch();
		
				echo "
					<section class=\"row\" name=\"Title\">
						<div class=col>
							<a href=\"../home_admin.php\" title=\"Home\"><img class=\"imgpanel\" src=\"../PICTURE/home48.png\" alt=\"Home\"></a>
						</div>
						<div class=\"col-12\">
							<h1 class=\"Titre\">$row[intitule] <img src=../PICTURE/InfoObject.png></h1>
						</div>
					</section>";
		?>

		<section class="row justify-content-center" name="GroupeDumodule">
			<div class="col-7">
				<h2 class="Titre">Liste des groupes du modules : </h2>
				<div class="Affichage">
					<table class="table table-hover">
						<tr align="center">
							<th>N°</th>
							<th>Nom du groupe</th>
							<th>Enseignant</th>
							<th>Nombre d'heure</th>
							<th>Nombre d'heure(eqtd)</th>
						    <th>Téléphone</th>
							<th>Mail</th>
							<th>Heures Manquantes</th>
						</tr>
						<?php   


							$SQL ="SELECT groupes.gid AS gid, groupes.nom AS nomgroupe,enseignants.nom AS nom, enseignants.prenom AS prenom, enseignants.tel AS tel, enseignants.email AS email, affectations.nbh AS nbh, gtypes.coeff AS coeff FROM enseignants INNER JOIN affectations ON affectations.eid = enseignants.eid INNER JOIN groupes ON groupes.gid = affectations.gid INNER JOIN gtypes ON gtypes.gtid = groupes.gtid WHERE groupes.mid =:moduleid AND groupes.annee =:year";
				
								$rq = $db->prepare($SQL);
								$rq->execute(["moduleid"=>$idmodule,"year"=>$annee]);
								$lastgid = -1;
								foreach ($rq as $row) 
								{	

									
									//1) On prends les heures déjà attribué //
									$SQL = "SELECT SUM(nbh) AS sum from affectations WHERE 
											gid =:idgroupe";
									$st = $db->prepare($SQL);
									$st->execute(["idgroupe"=>$row["gid"]]);
									$rq = $st -> fetch();
									$heures_courantes = $rq["sum"];
									if(empty($heures_courantes))$heures_courantes=0;

									//2) On regarde le Gtype du groupe //
									$SQL = "SELECT gtypes.nbh AS nbh FROM gtypes INNER JOIN 
											groupes ON groupes.gtid = gtypes.gtid
											WHERE groupes.gid =:idgroupe AND groupes.annee=:year";
									$st = $db->prepare($SQL);
									$st->execute(["idgroupe"=>$row["gid"],"year"=>$annee]);
									$rq2 = $st->fetch();
									$heures_max = $rq2["nbh"];

									$heure_restante = $heures_max - $heures_courantes;


								
									$eqtd = $row["nbh"]*$row["coeff"];
									echo "
											<tr align=center>";
											if($row["gid"]==$lastgid)
											{
												echo "<td class=previous></td>
													<td class=previous></td>
													<td>$row[nom] $row[prenom]</td>
												<td>$row[nbh]</td>
												<td>$eqtd</td>
												<td>$row[tel]</td>
												<td>$row[email]</td>
												<td class=previous></td>";
											}
											else
											{	
												echo "
												<td>$row[gid]</td>
												<td>$row[nomgroupe]</td>
												<td>$row[nom] $row[prenom]</td>
												<td>$row[nbh]</td>
												<td>$eqtd</td>
												<td>$row[tel]</td>
												<td>$row[email]</td>
												<td>$heure_restante h&nbsp&nbsp<img src=../PICTURE/clock.png>
												</td>";
												$sommeTotal += $heure_restante;
											}
												


									echo "</tr>";
								
										$lastgid = $row["gid"];

				}
							/* TEST AFFECTATION */ /*On récupère tous les groupes du modules */
							$SQL1 = "SELECT * FROM groupes WHERE mid=:idmodule AND annee=:year";
							$row = $db->prepare($SQL1);
							$row->execute(["idmodule"=>$idmodule,"year"=>$annee]);

							foreach ($row as $groupe) 
							{
								$SQL ="SELECT * FROM affectations WHERE gid=:id";
								$rq = $db->prepare($SQL);
								$rq -> execute(["id"=>$groupe["gid"]]);
								$res = $rq -> fetch();

								/* On regarde si groupe est dans la table, et plus précisemment si il a une affectation*/
								if(empty($res["eid"]))
								{
									$SQL ="SELECT groupes.gid,groupes.nom,gtypes.coeff,gtypes.nbh FROM groupes INNER JOIN gtypes ON gtypes.gtid = groupes.gtid
											WHERE groupes.gid =:gid";

									$r = $db -> prepare($SQL);
									$r->execute(["gid"=>$groupe["gid"]]);
									$Grp = $r->fetch();

									echo "<tr align =center>";
											echo "
												<td>$Grp[gid]</td>
												<td>$Grp[nom]</td>
												<td colspan=5 align=center>Pas d'affectations pour ce groupes</td>
												<td>$Grp[nbh] h&nbsp&nbsp<img src=../PICTURE/clock.png>
												</td>";
											echo "</tr>";
										$sommeTotal+= $Grp["nbh"];

								}
							}


							?>
						</table>
					</div>
			</div>
			<div class="col-4" name="HeureManquanteModule">
				<h5 class ="Titre">Nombre Total d'heures Manquantes : <?php echo $sommeTotal; ?> h&nbsp&nbsp<img src=../PICTURE/clock.png></h5> 
			</div>
		</section>
	</body>
</html>