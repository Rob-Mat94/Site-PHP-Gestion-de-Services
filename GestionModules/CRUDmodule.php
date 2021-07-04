<!DOCTYPE html>
<html>
	<?php
		require "../auth/EtreAuthentifie.php";
		require "../db_config.php";
		require "../FonctionTool.php";
	?>

					<!--ENTETE -->
		<head>
			<title>GestionModules</title>
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
					<h1 class ="Titre">Module Management</h1>
				</div>		
			</section>

			<!-- TABLEAUX MODULES -->
			<section class ="row" name="TableauModules">
				<div class ="col-12">
					<div class="affichage">		
						<table class="table table-hover">
							<?php 
								require("../db_connect.php");
								$st = $db->prepare("SELECT * FROM modules WHERE annee=:year");
								$st -> execute(["year"=>htmlspecialchars($_SESSION["year"])]);
							?>

							<tr>
								<th>MID</th>
								<th>Intitulé</th>
								<th>Code</th>
								<th>EID</th>
								<th>CID</th>
								<th>Année</th>
							</tr>
		
							<?php

							// rajouter action au formulaire //
								foreach($st as $row)
								{
									echo "	<tr>
											  <td>$row[mid]</td>
											  <td>$row[intitule]</td>
											  <td><strong>$row[code]</strong></td>
											  <td>$row[eid]</td>
											  <td>$row[cid]</td>
											  <td>$row[annee]</td>
											  <td id=\"SupprimerModule\"><form method=post action ='SupprimerModule.php'>
													<input type=hidden value=$row[mid] name=mid>
													<input type=image
													title = 'Supprimer ce module'src='../PICTURE/delete2.png'></form></td>

													<td><form method =post action =''>
													<input type=hidden value =$row[mid] name=idmodif>
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
					require("Mmodifier.php");
				}
			?>


			<!-- Création button AJOUTER -->
			<?php 
				if(empty($_POST["idmodif"]) && !isset($_POST["idmodif"]))
				{
				echo "
				<section class=\"row\" name=\"AddButton\">
					<div class=\"col-1 offset-8\">
						<form method=\"post\" action=\"AjouterModule.php\">
							<input class=\"AddButton\" type=\"submit\" value=\"Ajouter un Module\">
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


