	


 <!-- Bouton annuler -->
 	<section class ="row" nane="annuler">
 		<div class ="col-1 offset-11">
 			<a href="CRUDenseignants.php"><p><img src="../PICTURE/cancel.png" title ="Annuler"></p></a>
 		</div>
 	</section>

 <!-- Tableaux avec les valeurs modifiables -->

	 <section class ="row" name=\TableauEnseignants\>
				<div class ="col-12">
					<div class="tab_modif">	
						<table class = "table">
							<tr>
								<th>Nom</th>
								<th>Prénom</th>
								<th>E-mail</th>
								<th>Numéro de téléphone</th>
							</tr>

							<?php

							$SQL = "SELECT nom,prenom,email,tel FROM enseignants WHERE eid =:id";

							$eid = intval($_POST["idmodif"]);
							$st = $db->prepare($SQL);
							$st -> execute(["id"=>$eid]);

							/* FORMULAIRE MODIFICATION : 
														-NOM
														-PRENOM
														-EMAIL
														-TEL
							*/
								foreach ($st as $row) 
								{
									echo "<tr>
											<td>
												<form method=post action='Emodifnom.php'>
													<input type=hidden value=$eid name=eid>$row[nom]<input class=modifform type=text name=newnom>
													<br><input type=image id='editpencil'
														src='../PICTURE/penciledit.png' title='Modifier le Nom'>
												</form>
										  	</td>
										  	<td>
												<form method=post action='Emodifprenom.php'>
													<input type=hidden value=$eid name=eid>$row[prenom]<input class=modifform type=text name=newprenom>
													<br><input type=image id='editpencil'  src='../PICTURE/penciledit.png' title='Modifier le Prénom'>
												</form>
										  	</td>
										  	<td>
												<form method=post action='Emodifmail.php'>
													<input type=hidden value=$eid name=eid>$row[email]<input class=modifform type=email name=newemail>
													<br><input type=image id='editpencil' src='../PICTURE/penciledit.png' title='Modifier email'>
												</form>
										  	</td>
										  	<td>
												<form method=post action='Emodiftel.php'>
													<input type=hidden value=$eid name=eid>$row[tel]<input class=modifform type=tel name=newtel>
													<br><input type=image id='editpencil' src='../PICTURE/penciledit.png' title='Modifier le numéro de téléphone'>
												</form>
										  	</td>
										  <tr>";
								}		
							?>


							
						
						</table>
					</div>
				</div>
			</section>

	