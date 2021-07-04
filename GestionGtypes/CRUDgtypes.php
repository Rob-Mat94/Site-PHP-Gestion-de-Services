<!DOCTYPE html>
<html>
	<?php
		require "../auth/EtreAuthentifie.php";
		require "../db_config.php";
		require "../FonctionTool.php";
	?>

					<!--ENTETE -->
		<head>
			<title>GestionGtypes</title>
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
					<h1 class ="Titre">Gtypes Management</h1>
				</div>		
			</section>

			<!-- TABLEAUX MODULES -->
			<section class ="row" name="TableauGtypes">
				<div class ="col-12">
					<div class="affichage">		
						<table class="table table-hover">
							<?php 
								require("../db_connect.php");
								$st = $db->prepare("SELECT * FROM gtypes");
								$st -> execute();
							?>

							<tr>
								<th>GTID</th>
								<th>nom</th>
								<th>nombre d'heure (nbh)</th>
								<th>coeff</th>
							</tr>
		
							<?php

							// rajouter action au formulaire //
								foreach($st as $row)
								{
									echo "	<tr>
											  <td>$row[gtid]</td>
											  <td>$row[nom]</td>
											  <td><strong>$row[nbh]</strong></td>
											  <td>$row[coeff]</td>
											  <td id=\"SupprimerGroupe\"><form method=post action ='SupprimerGtype.php'>
													<input type=hidden value=$row[gtid] name=idmodif>
													<input type=image
													title = 'Supprimer' src='../PICTURE/delete2.png'></form></td>

													<td><form method =post action =''>
													<input type=hidden value =$row[gtid] name=idmodif>
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

			<!-- SI L'UTILISATEUR CLIQUE SUR l'ICON MODIFIER
				UN TABLEAU AVEC LES DIFFERENTE VALEURS MODIFIABLES 
				APPARAITRONT -->

			<?php
				if(!empty($_POST["idmodif"]) && isset($_POST["idmodif"]) &&
					is_numeric($_POST["idmodif"]))
				{	
					require("GTmodifier.php");
				}
			?>


			<!-- Création button AJOUTER -->
			<?php 
				if(empty($_POST["idmodif"]) && !isset($_POST["idmodif"]))
				{
				echo "
				<section class=\"row\" name=\"AddButton\">
					<div class=\"col-1 offset-8\">
						<form method=\"post\" action=\"AjouterGtype.php\">
							<input class=\"AddButton\" type=\"submit\" value=\"Ajouter Gtypes\">
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


