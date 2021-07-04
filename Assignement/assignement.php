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
					<h1 class ="Titre">Assignement</h1>
				</div>		
			</section>

			<section class ="row" name="Affectations">
				<div class ="col-12">
					<div class="affichage">		
						<table class="table table-hover">
							<?php
								require("../db_connect.php");
								$st = $db->prepare("SELECT * FROM affectations INNER JOIN groupes ON affectations.gid = groupes.gid WHERE groupes.annee=:year");
								$st -> execute(["year"=>htmlspecialchars($_SESSION["year"])]);
							?>

							<tr>
								<th>Enseignant (id)</th>
								<th>Groupes (id)</th>
								<th>Horraire</th>
							</tr>
		
							<?php

								foreach($st as $row)
								{
									echo "	<tr>
											  <td>$row[eid]</td>
											  <td>$row[gid]</td>
											  <td><strong>$row[nbh] heure(s)</strong></td>
											  <td>
											  	<form method=post action=SupprimerAffectation.php>
											  	<input type =hidden value=$row[eid] name=eid>
											  	<input type =hidden value=$row[gid] name=gid>
											  	<input type =hidden value=$row[nbh] name=nbh>
											  	<input type=image
												src=../PICTURE/delete2.png></form>
											  </td>
											</tr>";
								}

							?>
						
						</table> 
					</div>
				</div> 
			</section>


			<section class="row" name="AddButton">
					<div class="col-1 offset-8">
						<form method="post" action="AssignerGroupe.php">
							<input class="AddButton\" type="submit" value="Assigner un groupe">
						</form>
					</div>
			</section>
















			<!-- LOGOUT -->
			<footer class= "row" name ="HomeButton">
				<div class="col-1">
					<a href="../<?= $pathFor['logout'] ?>" title="Logout"><p><img class="HomeButton" src="../PICTURE/exit.png" alt="Home"></p></a>
				</div>
			</footer>
		</div>
	</body>
</html>