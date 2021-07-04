				
	<section class="row" id="Undertitle" name="Title">

		<div class="col-2 offset-1">
				<?php require("HomeChangePassword.php"); ?>
			</div>


		<div class="col-2 offset-2">
			<h2 class="Titre"><?php echo $name["prenom"]." ".$name["nom"]."&nbsp"?><img src=PICTURE/info.png></h1>
		</div>

		<div class="col-2 offset-3">
			<?php require("YearChoice.php"); ?>
		</div>
	</section>


	<!-- Changement du mot de passe -->
		<section class="row" name="changemdp">
		</section>
	<!------------------------------->

	<section class="row" name="InfosModules">


			<!-- Pour les Modules -->
			<div class="col-3 offset-1" name="Modules">
				<?php

						/*** SELECTION du modules dont l'enseignants est responsable ***/
					$SQL = "SELECT modules.intitule AS intitule, modules.code AS code, categories.nom AS nom FROM modules  INNER JOIN
							categories ON categories.cid = modules.cid WHERE  modules.eid =:idenseignants AND modules.annee =:year";
					$st = $db->prepare($SQL);
					$st->execute(["idenseignants"=>$id,"year"=>$annee]);					
						echo "<h2 class=\"Titre\">Module(s) assigné(s)</h2>
								<div class=\"affichage\"> 
										<table class=\"table table-hover\">
											<tr>
												<th>Intitulé du module</th>
												<th>Code du module</th>
												<th>Catégorie</th>
											</tr>";

						foreach ($st as $row) 
						{	
							echo "
									<tr>
										<td>$row[intitule]</td>
										<td>$row[code]</td>
										<td>$row[nom]</td>
									</tr>	
										";
						}
					

				?>	

					</table>
				</div>

				<?php

					/***Affichage Heure pas encore effectué ****/
					//1) On prends les heures déjà attribué //
					$SQL = "SELECT SUM(nbh) AS sum from affectations WHERE 
							eid =:idenseignants";
					$st = $db->prepare($SQL);
					$st->execute(["idenseignants"=>$id]);
					$rq = $st -> fetch();
					$heures_courantes = $rq["sum"];

					//2) On regarde le Etype de l'enseignant //
					$SQL = "SELECT etypes.nbh AS nbh FROM etypes INNER JOIN 
							enseignants ON enseignants.etid = etypes.etid
							WHERE enseignants.eid =:idenseignants AND enseignants.annee=:year";
					$st = $db->prepare($SQL);
					$st->execute(["idenseignants"=>$id,"year"=>$annee]);
					$rq2 = $st->fetch();
					$heures_max = $rq2["nbh"];

					$heure_restante = $heures_max - $heures_courantes;

					echo "<br>
						<p class=\"Titre\"> 
						Heures non effectuées : $heure_restante heure(s)&nbsp&nbsp<img src=PICTURE/clock.png></p>";

				?>
			</div>


			<!-- Pour les groupes -->
			<div class="col-5 offset-2" name="Groupes">
				<div class="affichage">
					<h2 class="Titre">Groupe(s) Affecté(s)</h2> 
					<table class="table table-hover">
						<tr>
							<th>Intitulé du module<br> (du groupe)</th>
							<th>Nom du groupe</th>
							<th>Catégorie</th>
							<th>Nombre d'heure (nbh)</th>
							<th>Nombre d'heure (eqtd)</th>
						</tr>
				<?php
							/***** Sélectionne les heures affecté *****/
					$SQL="SELECT modules.intitule AS intitule, groupes.nom AS nomgroupes, affectations.nbh AS nbh, gtypes.coeff AS coeff, categories.nom AS nom FROM affectations INNER JOIN groupes ON groupes.gid = affectations.gid INNER JOIN modules ON modules.mid = groupes.mid INNER JOIN gtypes ON gtypes.gtid = groupes.gtid INNER JOIN categories ON categories.cid = modules.cid WHERE affectations.eid =:idenseignants AND groupes.annee=:year";

					$st = $db->prepare($SQL);
					$st->execute(["idenseignants"=>$id,"year"=>$annee]);
					foreach ($st as $row) 
					{	
						$eqtd = $row["nbh"]*$row["coeff"];
						echo "
								<tr>
									<td>$row[intitule]</td>
									<td>$row[nomgroupes]</td>
									<td>$row[nom]</td>
									<td>$row[nbh]</td>
									<td>$eqtd</td>
								</tr>
								";
					}


				?>

					</table>
				</div>
			</div>

		</section>


		<!-- Logout -->
		<footer class="row">
			<div class="col-2 offset-1">
						<p class="HomeButtonError"><a href="<?= $pathFor['logout'] ?>" title="Logout"><img class="HomeButton" src="PICTURE/exit.png" alt="Home"></a>  Déconnexion</p>
			</div>
		</footer>
