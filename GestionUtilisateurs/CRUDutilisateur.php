<!DOCTYPE html>
<html>

	<?php
		require "../auth/EtreAuthentifie.php";
		require "../db_config.php";
	?>


					<!--ENTETE -->
		<head>
			<title>GestionUtilisateurs</title>
	       	<meta charset="utf-8" />
			<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
			<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
		</head>

	<body>
		<div class ="container">

						<!--HEADER (Logout)-->
			<header class ="page-header" name ="Header">			
				<a href="../home_admin.php"title="Home"><img class="Logout" src="../PICTURE/home48.png" alt="Home"></a>
			</header>


					<!-- TITRE -->
			<section class ="row" name="Titre">
				<div class="col">
					<h1 class ="Titre">Users Management</h1>
				</div>		
			</section>




			<?php

			require "../db_connect.php";

			$SQL = "SELECT * FROM users"; 
			$st = $db->prepare($SQL);
			$st->execute();

			?>
			<section class ="row" name="TableauUtilisateurs">
				<div class ="col-12">
					<div class="affichage">		
						<table class="table table-hover">
							 <tr>
								<th>UID</th>
								<th>Login</th>
								<th>Password</th>
								<th>Role</th>
							</tr>

							<?php

							foreach ($st as $row) 
							{
								echo "<tr>
											<td>$row[uid]</td>
											<td>$row[login]</td>
											<td><em>$row[mdp]</em></td>
											<td>$row[role]</td>
											<td><form method=post action='ChangerPassword.php'><input type=hidden value=$row[uid] name =iduser><input type=submit value ='Change Password'>
											</form></td>
											<td id=\"SupprimerUtilisateur\"><form method=post action ='SupprimerUtilisateur.php'><input type=hidden value=$row[uid] name=iduser>
												<input type=image
												src=../PICTURE/delete2.png></form></td>
									</tr>";
							}

							?>

						</table>
					</div>
				</div> 
			</section>

			<!-- Création button Ajouter -->
			<section class="row" name="AddButton">
				<div class="col-1 offset-8">
					<form method="post" action="AjouterUtilisateur.php">
						<input class="AddButton" type="submit" value="Ajouter Utilisateur">
					</form>
				</div>
			</section>


			<!-- <a href="http://ton lien"><img src="ton image.gif" alt= "nom de ton image"></a> -->

			<footer class= "row" name ="HomeButton">
				<div class="col-1">
					<a href="../<?= $pathFor['logout'] ?>" title="Logout"><p><img class="HomeButton" src="../PICTURE/exit.png" alt="Home"></p></a>
				</div>
			</footer>
		</div>
	</body>
</html>


