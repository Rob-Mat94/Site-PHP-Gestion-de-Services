
<!DOCTYPE html>
<html>
	<head>
		<title>SélectionEnseignant</title>
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
					<h1 class ="Titre">Sélection de l'enseignant</h1>
				</div>		
			</section>

			<section class ="row" name="Affectationsdugroupe">
				<div class ="col-12">
					<div class="affichage">		
						<table class="table table-hover">
							<?php
								require("../db_connect.php");
								$SQL = "SELECT * FROM enseignants WHERE annee =:year";
								$st = $db->prepare($SQL);
								$st -> execute(["year"=>htmlspecialchars($_SESSION["year"])]);
							?>

							<tr>
								<th>Nom</th>
								<th>Prénom</th>
								<th>E-mail</th>
								<th>téléphone</th>
								<th>Heure(s) à potentiellement placer</th>
							</tr>
		
							<?php

								foreach($st as $row)
								{	/* POUR CHAQUE ENSEIGNANTS */
									//  1) On sélectionne le nombre d'heure déjà attribué au prof
									$SQL = "SELECT SUM(nbh) AS counth FROM affectations WHERE eid =:idenseignant";
									$st = $db -> prepare($SQL);
									$st -> execute(["idenseignant"=>$row["eid"]]);
									$rq = $st->fetch();
									$nombre_heure_actuel = $rq["counth"];
									if(empty($nombre_heure_actuel))
									{
										$nombre_heure_actuel = 0;
									}
									//  2) On regarde son etype sur la table
									$SQL2 = "SELECT nbh FROM etypes INNER JOIN enseignants ON enseignants.etid = etypes.etid WHERE enseignants.eid =:eid AND enseignants.annee =:year";
										$st = $db -> prepare($SQL2);
										$st -> execute(["eid"=>$row["eid"],"year"=>htmlspecialchars($_SESSION["year"])]);
										$rs = $st->fetch();
										$nombre_heure_max = $rs["nbh"];
										$nombre_heure_restant = 
										$nombre_heure_max - $nombre_heure_actuel;
									echo "<tr>
											  <td>$row[nom]</td>
											  <td>$row[prenom]</td>
											  <td><strong>$row[email]</strong></td>
											  <td>$row[tel]</td>";
											  if($nombre_heure_restant<=0)
											  {
											  	echo "<td> <img src=../PICTURE/impossible.png alt= Impossible>";
											  }
											  else{
											  	echo "
											  
											  <td><strong>$nombre_heure_restant heure(s)</strong></td>
											  <td>
											  	<form method=post action=''>
											  		<input type = hidden 
											  		value =1 name=Eselec>
											  		<input type=hidden value=$gid name =gid>
											  		<input type =hidden value=$row[eid] name=eid>
											  		<input type =hidden 
											  		value =$row[nom] name=nom
											  		>
											  		<input type=hidden value =$row[prenom]
											  		name =prenom>


											  		<input type=image 
														title ='Sélectionner'
														src ='../PICTURE/choice.png'> 
												</form>
												</td>
												";
											}
											echo"</tr>";
								}
							?>
						
						</table> 
					</div>
				</div> 
			</section>

		<?php
			if(isset($_POST["Eselec"]) && $_POST["Eselec"]==1)
								{
									if(secure_exit($_POST["gid"]) || secure_exit($_POST["eid"]) || secure_exit($_POST["nom"]) || secure_exit($_POST["prenom"]))
									{
										die("Fatal Error");
									}
									$eid = $_POST["eid"];
									$nom = $_POST["nom"];
									$prenom = $_POST["prenom"];
									echo "<section class =\"row\" name=\"Titre\">
										<div class=\"col\">
											<h2 class =\"Titre\">Affectation à $nom $prenom</h2>
										</div>		
									</section>";
									echo "
									<section class =\"row\">
										<div class =\"col-12\">
											<form method=post action=Affecter.php>
											<input type =hidden value =$eid name=eid>
											<input type =hidden value =$gid name=gid>
											<p>Veuillez choisir un volume horraire : </p>
											<input type =number name=nbheures max='$heures_restantes' min='1' value='$heures_restantes'>
											<input type=submit value=Valider>
											</form>
										</div>
									</section>
									"
									;
								}
			?>
		</div>
	</body>
</html>