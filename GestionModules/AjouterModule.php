<!DOCTYPE html>
<html>
	<head>
		<title>AjouterModule</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<section class="container" name ="FormulaireAjoutModule">
			<div class = "row">
				<div  class ="col">
					<form method="post" action="Majout.php">

						<label for="intitule">Intitulé : </label>
						<input type="text" id="intitule" name="intitule">

						<label for="Code">Code : </label>
						<input type="text" id="Code" name="code">

						<label for="eid">EID (enseignant) : </label>
						<input type="number" id="eid" name="eid" min="0">

						<label for="cid">CID (catégorie) : </label>
						<input type="number" name="cid" id="cid" min="0">
					
						<input type="submit" name="envoie" value="Ajouter">

					</form>
				</div>
			</div>
		</section>
	</body>
</html>