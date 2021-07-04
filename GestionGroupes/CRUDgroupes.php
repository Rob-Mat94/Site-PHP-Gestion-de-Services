<!DOCTYPE html>
<html>
	<?php 
		require "../auth/EtreAuthentifie.php";
		require "../db_config.php";
		require "../FonctionTool.php";
	?>

						<!--ENTETE -->
	<head>
		<title>CRUDgroupes</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<div class ="container">

						<!--HEADER (Home)-->
			<header class ="page-header" name ="Header">			
				<a href="../home_admin.php"title="Home"><img class="Logout" src="../PICTURE/home48.png" alt="Home"></a>
			</header>


					<!-- TITRE -->
			<section class ="row" name="Titre">
				<div class="col">
					<h1 class ="Titre">Group Management</h1>
				</div>		
			</section>

			<!-- TABLEAUX Groupes -->
			<section class ="row" name="TableauGroupes">
				<div class ="col-12">
					<div class="affichage">		
						<table class="table table-hover">
							<?php 
								require("../db_connect.php");
								$st = $db->prepare("SELECT * FROM groupes WHERE annee=:year");
								$st -> execute(["year"=>htmlspecialchars($_SESSION["year"])]);
							?>

							<tr>
								<th>GID</th>
								<th>MID <br>(module)</th>
								<th>Nom</th>
								<th>Année</th>
								<th>GTID <br>(gtypes)</th>
							</tr>
		
							<?php

							// rajouter action supprimer au formulaire //
								foreach($st as $row)
								{
									echo "	<tr>
											  <td>$row[gid]</td>
											  <td>$row[mid]</td>
											  <td><strong>$row[nom]</strong></td>
											  <td>$row[annee]</td>
											  <td>$row[gtid]</td>
											  <td id=\"SupprimerGroupe\"><form method=post action ='SupprimerGroupe.php'>
													<input type=hidden value=$row[gid] name=gid>
													<input type=image
													title = 'Supprimer ce groupe' src='../PICTURE/delete2.png'></form></td>

												<td>
													<form method =post action =''>
													<input type=hidden value =$row[gid] name=idmodif>
													<input type=image 
														title ='Modifier'
														src ='../PICTURE/edittable.png'></form>
												</td>
											</tr>";
								}

							?>
						
						</table> 
					</div>
				</div> 
			</section>

			<?php
				if(!empty($_POST["idmodif"]) && isset($_POST["idmodif"]) &&
					is_numeric($_POST["idmodif"]))
				{	
					require("Gmodifier.php");
				}
			?>


			<!-- Création button AJOUTER -->
			<?php 
				if(empty($_POST["idmodif"]) && !isset($_POST["idmodif"]))
				{
				echo "
				<section class=\"row\" name=\"AddButton\">
					<div class=\"col-1 offset-8\">
						<form method=\"post\" action=\"AjouterGroupe.php\">
							<input class=\"AddButton\" type=\"submit\" value=\"Ajouter un Groupe\">
						</form>
					</div>
				</section>
				";
				}		
			?>


			<!-- <a href="http://ton lien"><img src="ton image.gif" alt= "nom de ton image"></a> -->

			<!-- LOGOUT -->
			<footer class= "row" name ="HomeButton">
				<div class="col-1">
					<a href="../<?= $pathFor['logout'] ?>" title="Logout"><p><img class="HomeButton" src="../PICTURE/exit.png" alt="Home"></p></a>
				</div>
			</footer>
		</div>
	</body>
</html>