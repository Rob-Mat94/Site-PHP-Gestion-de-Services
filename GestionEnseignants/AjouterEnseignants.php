<!DOCTYPE html>
<html>
	<head>
		<title>AjouterEnseignant</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<form method="post" action="Eajout.php">
			<label for="UID">UID : </label>
			<input type="number" id="UID" name="uid"><br>
			<label for="Nom">Nom : </label>
			<input type="text" id="Nom" name="Enom"><br>
			<label for="Prenom">Prénom : </label>
			<input type="text" id="Prenom" name="Eprenom"><br>
			<label for="Email">E-mail : </label>
			<input type="email" name="Email" id="Email"><br>
			<label for="tel">Téléphone : </label>
			<input type="tel" name="tel" id="tel"><br>
			<label for="etid">ETID : </label>
			<input type="number" name="etid" id="etid" min ="0"><br>
			<input type="submit" name="envoie" value="Ajouter">

		</form>
	</body>
</html>