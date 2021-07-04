<!-- Bouton annuler -->
 	<section class ="row" nane="annuler">
 		<div class ="col-1 offset-11">
 			<a href="CRUDgtypes.php"><p><img src="../PICTURE/cancel.png" title ="Annuler"></p></a>
 		</div>
 	</section>

 <!-- Tableaux avec les valeurs modifiables -->

	 <section class ="row" name=\TableauGtypes\>
				<div class ="col-12">
					<div class="tab_modif">	
						<table class = "table">
							<tr>
								<th>Nom</th>
								<th>Nombre d'heure</th>
								<th>Coefficient</th>
							</tr>

							<?php

							$SQL = "SELECT nom,nbh,coeff FROM gtypes WHERE gtid =:id";

							$gtid = intval($_POST["idmodif"]);
							$st = $db->prepare($SQL);
							$st -> execute(["id"=>$gtid]);

							/* FORMULAIRE MODIFICATION :												
														-nom
														-nbh
														-coeff
							*/
								foreach ($st as $row) 
								{
									echo "<tr>
											<td>
												<form method=post action='modifnomgtype.php'>
													<input type=hidden value=$gtid name=gtid>$row[nom]<input class=modifform type=text name=newnom>
													<br><input type=image id='editpencil'
														src='../PICTURE/penciledit.png' title='Modifier le nom'>
												</form>
										  	</td>
										  	<td>
												<form method=post action='modifnbh.php'>
													<input type=hidden value=$gtid name=gtid>$row[nbh]<input class=modifform type=number name=newnbh min='1'>
													<br><input type=image id='editpencil'  src='../PICTURE/penciledit.png' title='Modifier le volume horraire'>
												</form>
										  	</td>
										  	<td>
												<form method=post action='modifcoeff.php'>
													<input type=hidden value=$gtid name=gtid>$row[coeff]<input class=modifform type=number name=newcoeff step='any'>
													<br><input type=image id='editpencil' src='../PICTURE/penciledit.png' title='Modifier le le coefficient'>
												</form>
										  	</td>
										  <tr>";
								}		
							?>


							
						
						</table>
					</div>
				</div>
			</section>