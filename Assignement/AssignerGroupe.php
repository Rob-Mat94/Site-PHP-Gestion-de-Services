<!DOCTYPE html>
<html>
	<?php
		require "../auth/EtreAuthentifie.php";
		require "../db_config.php";
		require "../FonctionTool.php";
	?>
	<head>
		<title>Assignement</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<div class="container">

			<!-- HOME -->
			<header class ="page-header" name ="Header">			
				<a href="../home_admin.php"title="Home"><img class="Logout" src="../PICTURE/home48.png" alt="Home"></a>			
			</header>

			<section class ="row" name="Titre">
				<div class="col">
					<h1 class ="Titre">Sélection du Groupe</h1>
				</div>		
			</section>

			<section class ="row" name="Affectationsdugroupe">
				<div class ="col-12">
					<div class="affichage">		
						<table class="table table-hover">
							<?php
								require("../db_connect.php");
								$st = $db->prepare("SELECT groupes.nom AS nom1, groupes.gid, groupes.mid, gtypes.nbh FROM groupes INNER JOIN gtypes ON groupes.gtid = gtypes.gtid WHERE groupes.annee=:year");
								$st -> execute(["year"=>htmlspecialchars($_SESSION["year"])]);
							?>

							<tr>
								<th>Groupe(id)</th>
								<th>Module (id)</th>
								<th>Nom</th>
								<th>Horraire à réaliser</th>
								<th>Heures placées</th>
							</tr>
		
							<?php

								foreach($st as $row)
								{	
									$SQL1 = "SELECT SUM(nbh) AS count_nbh FROM affectations where gid =:id";
									$st = $db->prepare($SQL1);
									$st->execute(["id"=>$row["gid"]]);
									$rq = $st->fetch();

									$heures_placées = $rq["count_nbh"];
									if(empty($heures_placées))
									{
										$heures_placées = 0;
									}
									echo "	<tr>
											  <td>$row[gid]</td>
											  <td>$row[mid]</td>
											  <td><strong>$row[nom1]</strong></td>";
									if($heures_placées < $row["nbh"])
									{
										echo "
									
											  <td>$row[nbh] heure(s)</td>
											  <td><strong>$heures_placées heures(s)</strong></td>
											  <td>
											  	<form method=post action='VerifGroupe.php'>
											  		<input type=hidden name=gid value=$row[gid]>
											  		<input type=image 
														title ='Sélectionner'
														src ='../PICTURE/choice.png'> 
											  	</form> 
											  	</td>
											  	";
											  }
											  else
											  {
											  	echo "

											  		<td> <img src=../PICTURE/impossible.png alt= Impossible></td>
											  		<td> <img src=../PICTURE/impossible.png alt= Impossible></td>";
											  }
										echo "</tr>";
								}

							?>
						
						</table> 
					</div>
				</div> 
			</section>
		</div>
	</body>
</html>