<?php
	require "auth/EtreAuthentifie.php";
	require "db_config.php";
	require "FonctionTool.php";
?>
	<!-- Manque de sécurité -->
	<form method="post" action =" " name =Formulaire_modif_mdp>
		<p>Entrez le nouveau mot de passe : <input type="password" name="password"></p>
		<p>Confirmez le nouveau mot de passe : <input type ="password" name="password2"></p>
		<?php echo "<input type =hidden value=$_POST[iduser] name=iduser>"; ?>
		<input type ="submit" value="Confirmez">
	</form>


<?php
	if(!empty($_POST["password"]) && isset($_POST["password"]) && isset($_POST["password2"]) && !empty($_POST["password2"])) 
			{

				if(strcmp($_POST["password2"],$_POST["password"])!==0)
					echo "<p>Aucune correspondance entre les deux mots de passe</p>";
				else if(!empty($_POST["iduser"]) && isset($_POST["iduser"]))
					require "ChangerForHome.php";						
			}
?>