<!DOCTYPE html>
<html>
	<head>
		<title>AjouterGtype</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<section class="container" name ="FormulaireAjoutGtypes">
			<div class = "row">
				<div  class ="col">
					<form method="post" action="GTajout.php">

						<label for="nom">Nom : </label>
						<input type="text" id="nom" name="nom">

						<label for="nbh">Nombre d'heure (nbh) : </label>
						<input type="number" id="nbh" name="nbh" min="1">

						<label for="coeff">Coefficient : </label>
						<input type="number" id="coeff" name="coeff" step="any">				
						<input type="submit" name="envoie" value="Ajouter">
					</form>
				</div>
			</div>
		</section>
	</body>
</html>