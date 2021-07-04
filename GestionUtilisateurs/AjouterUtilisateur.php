<!DOCTYPE html>
<html>
	<head>
		<title>AjoutUtilisateur</title>
		<meta charset="utf-8" />
		<link href="../BOOTSTRAP/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../CSS/styles.css">
	</head>

	<body>

		<?php
			require "../auth/EtreAuthentifie.php";
			require "../db_config.php";
			require "../FonctionTool.php";
		?>

		<form method="post" id="FormulaireNewUser" action="">
			<p>Login : <input type="text" name="login"></p>
			<p>Password : <input type="Password" name="mdp"></p>
			<p>Confirm Password : <input type ="Password" name = "confirmpassword"></p>			
			<select name="Rôle" form ="FormulaireNewUser">
				<option value ="user">Utilisateur</option>
		 		<option value ="admin">Administrateur</option>
		 	</select>
		 	<input type="submit" value="Ajouter">
		</form>
		<?php

			if(!empty($_POST["login"]) && isset($_POST["login"]) && isset($_POST["Rôle"]) && !empty($_POST["Rôle"])) 
			{

				if(strcmp($_POST["mdp"],$_POST["confirmpassword"])!==0)
					echo "<p>Aucune correspondance entre les deux mots de passe</p>";
				else if(!empty($_POST["mdp"]) && isset($_POST["mdp"]))
					require ("Ajout.php");			
				else
					echo "<p>Il faut saisir un mot de passe</p>";			
			}
			
		?>

		<footer>
			<a href=CRUDutilisateur.php>Précédent</a><br>
		</footer>
	</body>
</html>