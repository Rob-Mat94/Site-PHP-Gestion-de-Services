	<!DOCTYPE html>
<html>
	<head>
		<?php
			require "../auth/EtreAuthentifie.php";
			require "../db_config.php";
			require "../FonctionTool.php";

		?>
		<title>GestionEnseignants</title>
			<meta charset="utf-8" />
			<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
			<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	</head>
	
	<body>
		<div class ="container">

			<header class="page-header" name="Header">
				<a href="../home_admin.php"title="Home"><img class="Logout" src="../PICTURE/home48.png" alt="Home"></a>
			</header>


			<section class ="row" name="Titre">
				<div class="col">
					<h1 class ="Titre">Teacher Management</h1>
				</div>		
			</section>

			<?php		
				require "../db_connect.php";
		
				$SQL="SELECT * from enseignants WHERE annee=:year";
				$st = $db->prepare($SQL);
				$st -> execute(["year"=>$_SESSION["year"]]);	

			?>

			<section class ="row" name="TableauEnseignants">
					<div class ="col-12">
						<div class="affichage">		
							<table class="table table-hover">
								 <tr>
									<th>EID</th>
									<th>UID</th>
									<th>Last name</th>
									<th>First name</th>
									<th>E-mail</th>
									<th>Phone number</th>
									<th>ETID</th>
									<th>Year</th>						
								</tr>
							<?php

								foreach ($st as $row) 
								{
									echo "<tr>
												<td>$row[eid]</td>
												<td>$row[uid]</td>
												<td>$row[nom]</td>
												<td>$row[prenom]</td>
												<td>$row[email]</td>
												<td>$row[tel]</td>
												<td>$row[etid]</td>
												<td>$row[annee]</td>
												<td id=\"SupprimerEnseignant\"><form method=post action ='SupprimerEnseignants.php'><input type=hidden value=$row[eid] name=idteacher>
													<input type=hidden value=$row[uid] name=uid>
													<input type=image
													title = Supprimer src='../PICTURE/delete2.png'></form></td>

												<td><form method =post action =''>
													<input type=hidden value =$row[eid] name=idmodif>
													<input type=image 
														title ='Modifier'
														src ='../PICTURE/edit.png'></form>
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
					require("Emodifier.php");
				}
				?>
			<!------------------------------------------------------->

							<!-- Création button Ajouter -->
			<?php 
				if(empty($_POST["idmodif"]) && !isset($_POST["idmodif"]))
				{
				echo "
				<section class=\"row\" name=\"AddButton\">
					<div class=\"col-1 offset-8\">
						<form method=\"post\" action=\"AjouterEnseignants.php\">
							<input class=\"AddButton\" type=\"submit\" value=\"Ajouter un Enseignant\">
						</form>
					</div>
				</section>
				";
				}

				?>

							<!-- BOUTTON LOGOUT -->

			<footer class= "row" name ="Logout">
				<div class="col-1">
					<a href="../<?= $pathFor['logout'] ?>" title="Logout"><p><img class="HomeButton" src="../PICTURE/exit.png" alt="Home"></p></a>
				</div>
			</footer>

		</div>
	</body>
</html>