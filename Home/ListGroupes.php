<?php
	
	/******Affichage des enseignants (toujours en fonction de l'année) ******/
	require("../db_connect.php");
	require("../FonctionTool.php");
	if(!isset($_POST["matiere"]) || empty($_POST["matiere"]))
	{
		$SQL ="SELECT groupes.gid AS gid, modules.intitule AS matiere, groupes.nom AS nom FROM groupes INNER JOIN modules ON modules.mid = groupes.mid WHERE groupes.annee=:year";
		$st=$db->prepare($SQL);
		$st->execute(["year"=>htmlspecialchars($_SESSION["year"])]);

			echo "<section class=\"row justify-content-center\" name=\"ListeGroupes\">
					<div class=\"col-10\">
						<div class=\"affichage\">
							<table class=\"table table-hover\">
								<tr>
									<th>Numéro du groupe</th>
									<th>Nom</th>
									<th>Matière</th>
								</tr>";
								foreach ($st as $row)
								{	
									echo "
									<tr>
										<td>$row[gid]</td>
										<td>$row[nom]</td>
										<td>$row[matiere]</td>
										<td>
											<form method=\"post\" name=\"view\" action=\"InformationGroupes.php\">
												<input type=\"hidden\" value=$row[gid] name=\"idgroupe\">
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
	else if(!secure_exit($_POST["matiere"]))
	{
		$matiere = htmlspecialchars($_POST["matiere"]);
		$matiere = addslashes($matiere);

		$SQL2 ="SELECT groupes.gid AS gid, modules.intitule AS matiere, groupes.nom AS nom FROM groupes INNER JOIN modules ON modules.mid = groupes.mid WHERE groupes.annee=:year AND modules.intitule LIKE '$matiere%'";




		$st=$db->prepare($SQL2);
		$st->execute(["year"=>htmlspecialchars($_SESSION["year"])]);

			echo "<section class=\"row justify-content-center\" name=\"ListeGroupes\">
					<div class=\"col-10\">
						<div class=\"affichage\">
							<table class=\"table table-hover\">
								<tr>
									<th>Numéro du groupe</th>
									<th>Nom</th>
									<th>Matière</th>
								</tr>";
								foreach ($st as $row)
								{	
									echo "
									<tr>
										<td>$row[gid]</td>
										<td>$row[nom]</td>
										<td>$row[matiere]</td>
										<td>
											<form method=\"post\" name=\"view\" action=\"InformationGroupes.php\">
												<input type=\"hidden\" value=$row[gid] name=\"idgroupe\">
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