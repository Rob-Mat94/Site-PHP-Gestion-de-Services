<?php
	
	/******Affichage des enseignants (toujours en fonction de l'année) ******/
	require("../db_connect.php");
	require("../FonctionTool.php");
	if(!isset($_POST["nom"]) || empty($_POST["nom"]))
	{
		$SQL ="SELECT * FROM enseignants WHERE annee=:year";
		$st=$db->prepare($SQL);
		$st->execute(["year"=>htmlspecialchars($_SESSION["year"])]);

			echo "<section class=\"row justify-content-center\" name=\"ListeEnseignants\">
					<div class=\"col-10\">
						<div class=\"affichage\">
							<table class=\"table table-hover\">
								<tr>
									<th>Nom</th>
									<th>Prénom</th>
									<th>E-mail</th>
									<th>Téléphone</th>
								</tr>";
								foreach ($st as $row)
								{	
									echo "
									<tr>
										<td>$row[nom]</td>
										<td>$row[prenom]</td>
										<td>$row[email]</td>
										<td>$row[tel]</td>
										<td>
											<form method=\"post\" name=\"view\" action=\"InformationEnseignants.php\">
												<input type=\"hidden\" value=$row[eid] name=\"idenseignants\">
												<input type=image src=../PICTURE/eye.png title=\"Inspecter\">
											</form>
										</td>
									</tr>";
								}
						echo "	
							</table>
						</div>
					</div>
				  </section>";
		
	}
	/****** Si l'utilisateur rentre le nom ou un début de chaine dans la barre de recherche 
			alors on recherche en fonction de la chaine ****/
	else if(!secure_exit($_POST["nom"]))
	{
		$search = htmlspecialchars($_POST["nom"]);
		$search = addslashes($search);

		$SQL2 ="SELECT * FROM enseignants WHERE nom LIKE '$search%' AND annee=:year";
		$st=$db->prepare($SQL2);
		$st->execute(["year"=>htmlspecialchars($_SESSION["year"])]);

			echo "<section class=\"row justify-content-center\" name=\"ListeEnseignants\">
					<div class=\"col-10\">
						<div class=\"affichage\">
							<table class=\"table table-hover\">
								<tr>
									<th>Nom</th>
									<th>Prénom</th>
									<th>E-mail</th>
									<th>Téléphone</th>
								</tr>";
								foreach ($st as $row)
								{	
									echo "
									<tr>
										<td>$row[nom]</td>
										<td>$row[prenom]</td>
										<td>$row[email]</td>
										<td>$row[tel]</td>
										<td>
											<form method=\"post\" name=\"view\" action=\"InformationEnseignants.php\">
												<input type=\"hidden\" value=$row[eid] name=\"idenseignants\">
												<input type=image src=../PICTURE/eye.png title=\"Inspecter\">
											</form>
										</td>
									</tr>";
								}
						echo "	
							</table>
						</div>
					</div>
				  </section>";
	}




?>