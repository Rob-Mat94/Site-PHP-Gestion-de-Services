<!DOCTYPE html>
<html>
	<head>
		<title>AjouterGroupe</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<section class="container" name ="FormulaireAjoutGroupe">
			<div class = "row">
				<div  class ="col">
					<form method="post" action="Gajouter.php">

						<label for="mid">MID (module) : </label>
						<input type="number" id="mid" name="mid" min="1">

						<label for="nom">Nom : </label>
						<input type="text" id="nom" name="nom">

						<label for="gtid">GTID (gtypes) : </label>
						<input type="number" id="gtid" name="gtid" min="1">
					
						<input type="submit" name="envoie" value="Ajouter">

					</form>
				</div>
			</div>
		</section>
	</body>
</html>