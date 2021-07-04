<?php

	/* Affichage des modules (en fonction de l'année toujours) */
			require("../db_connect.php");
			require("../FonctionTool.php");

			if(!isset($_POST["matiere"]) || empty($_POST["matiere"]))
			{
				$SQL ="SELECT modules.mid AS mid, modules.intitule AS intitule, modules.code AS code, enseignants.nom AS Enom, enseignants.prenom AS Eprenom,
						categories.nom AS Lannee FROM modules INNER JOIN enseignants ON enseignants.eid = modules.eid INNER JOIN 
						categories ON categories.cid = modules.cid WHERE modules.annee=:year";

				$st=$db->prepare($SQL);
				$st->execute(["year"=>htmlspecialchars($_SESSION["year"])]);

					echo "<section class=\"row justify-content-center\" name=\"ListeModule\">
							<div class=\"col-10\">
								<div class=\"affichage\">
									<table class=\"table table-hover\">
										<tr>
											<th>Intitulé</th>
											<th>Code</th>
											<th>Enseignant Responsable</th>
										</tr>";
										foreach ($st as $row)
										{	
											echo "
											<tr>
												<td>$row[intitule]</td>
												<td>$row[code]</td>
												<td>$row[Enom] $row[Eprenom]</td>
												<td>$row[Lannee]</td>
												<td>
													<form method=\"post\" name=\"view\" action=\"InformationModules.php\">
														<input type=\"hidden\" value=$row[mid] name=\"idmodule\">
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
			else if(!secure_exit($_POST["matiere"]))
			{
				$matiere = htmlspecialchars($_POST["matiere"]);
				$matiere = addslashes($matiere);

				$SQL ="SELECT modules.mid AS mid, modules.intitule AS intitule, modules.code AS code, enseignants.nom AS Enom, enseignants.prenom AS Eprenom,
						categories.nom AS Lannee FROM modules INNER JOIN enseignants ON enseignants.eid = modules.eid INNER JOIN 
						categories ON categories.cid = modules.cid WHERE modules.annee=:year AND modules.intitule LIKE '$matiere%'";

				$st=$db->prepare($SQL);
				$st->execute(["year"=>htmlspecialchars($_SESSION["year"])]);

					echo "<section class=\"row justify-content-center\" name=\"ListeModule\">
							<div class=\"col-10\">
								<div class=\"affichage\">
									<table class=\"table table-hover\">
										<tr>
											<th>Intitulé</th>
											<th>Code</th>
											<th>Enseignant Responsable</th>
										</tr>";
										foreach ($st as $row)
										{	
											echo "
											<tr>
												<td>$row[intitule]</td>
												<td>$row[code]</td>
												<td>$row[Enom] $row[Eprenom]</td>
												<td>$row[Lannee]</td>
												<td>
													<form method=\"post\" name=\"view\" action=\"InformationModules.php\">
														<input type=\"hidden\" value=$row[mid] name=\"idmodule\">
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
