<!DOCTYPE html>
<html>
	<head>
		<title>Informations</title>
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">

		<?php
			require "../auth/EtreAuthentifie.php";
			require "../db_config.php";
			require("../FonctionTool.php");

			if(secure_exit($_POST["idgroupe"]) || !is_numeric($_POST["idgroupe"]))
			{
				die("Erreur Fatale");
			}
			/* Affichage du nom et matière en Titre */
			$id = intval($_POST["idgroupe"]);
			$annee = htmlspecialchars($_SESSION["year"]);
			require("../db_connect.php");
			$SQL = "SELECT groupes.nom AS nom, modules.intitule AS intitule FROM groupes INNER JOIN modules ON modules.mid = groupes.mid WHERE groupes.gid =:id AND groupes.annee=:year";
			$st = $db->prepare($SQL);
			$st->execute(["id"=>$id,"year"=>$annee]);
			$row = $st->fetch();
		?>

	</head>

	<body class="container-fluid">


		<?php
				echo "
					<section class=\"row\" name=\"Title\">
						<div class=col>
							<a href=\"../home_admin.php\" title=\"Home\"><img class=\"imgpanel\" src=\"../PICTURE/home48.png\" alt=\"Home\"></a>
						</div>
						<div class=\"col-12\">
							<h1 class=\"Titre\">$row[nom] : $row[intitule] <img src=../PICTURE/InfoObject.png></h1>
						</div>
					</section>";
		?>
		<section class="row justify-content-center" name="Informations Groupes">
			<div class="col-6">
					<?php
						/* Affichage Groupe + Enseignant affecté + nbh + eqtd */

						$SQL2 = "SELECT enseignants.nom AS nom, enseignants.prenom AS prenom, enseignants.tel AS tel, enseignants.email AS email, affectations.nbh AS nbh, gtypes.coeff AS coeff FROM enseignants INNER JOIN affectations ON affectations.eid = enseignants.eid INNER JOIN groupes ON groupes.gid = affectations.gid INNER JOIN gtypes ON gtypes.gtid = groupes.gtid WHERE groupes.gid =:gid AND groupes.annee =:year";
					?>
					<h2 class="Titre">Enseignant(s) Affecté(s) :</h2>
					<div class="Affichage">
						<table class="table table-hover">
							<tr>
								<th>Enseignant</th>
								<th>Nombre d'heure</th>
								<th>Nombre d'heure(eqtd)</th>
								<th>Téléphone</th>
								<th>Mail</th>
							</tr>
							<?php
								$rq = $db->prepare($SQL2);
								$rq->execute(["gid"=>$id,"year"=>$annee]);
								foreach ($rq as $row) 
								{
									$eqtd = $row["nbh"]*$row["coeff"];
									echo "
											<tr>
												<td>$row[nom] $row[prenom]</td>
												<td>$row[nbh]</td>
												<td>$eqtd</td>
												<td>$row[tel]</td>
												<td>$row[email];


											</tr>";
								}


							?>
						</table>
					</div>
			</div>
		</section>

		<section class="row" name="Heure Manquante">
			<div class ="col">
				<?php

					/***Affichage Heure pas encore effectué ****/
					//1) On prends les heures déjà attribué //
					$SQL = "SELECT SUM(nbh) AS sum from affectations WHERE 
							gid =:idgroupe";
					$st = $db->prepare($SQL);
					$st->execute(["idgroupe"=>$id]);
					$rq = $st -> fetch();
					$heures_courantes = $rq["sum"];

					//2) On regarde le Gtype du groupe //
					$SQL = "SELECT gtypes.nbh AS nbh FROM gtypes INNER JOIN 
							groupes ON groupes.gtid = gtypes.gtid
							WHERE groupes.gid =:idgroupe AND groupes.annee=:year";
					$st = $db->prepare($SQL);
					$st->execute(["idgroupe"=>$id,"year"=>$annee]);
					$rq2 = $st->fetch();
					$heures_max = $rq2["nbh"];

					$heure_restante = $heures_max - $heures_courantes;

					echo "<br>
						<p class=\"Titre\"> 
						Heures manquantes : <strong>$heure_restante</strong> heure(s)&nbsp&nbsp<img src=../PICTURE/clock.png></p>";

				?>
			</div>
		</section>




	</body>
</html>