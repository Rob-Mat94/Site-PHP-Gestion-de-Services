<!-- Bouton annuler -->
 	<section class ="row" nane="annuler">
 		<div class ="col-1 offset-11">
 			<a href="CRUDmodule.php"><p><img src="../PICTURE/cancel.png" title ="Annuler"></p></a>
 		</div>
 	</section>

 <!-- Tableaux avec les valeurs modifiables -->

	 <section class ="row" name=\TableauGroupe\>
				<div class ="col-12">
					<div class="tab_modif">	
						<table class = "table">
							<tr>
								<th>Intitulé</th>
								<th>Code</th>
								<th>EID (enseignant)</th>
								<th>CID (catégorie)</th>
							</tr>

							<?php

							$SQL = "SELECT intitule,code,eid,cid FROM modules WHERE mid =:id";

							$mid = intval($_POST["idmodif"]);
							$st = $db->prepare($SQL);
							$st -> execute(["id"=>$mid]);

							/* FORMULAIRE MODIFICATION : 
														-Intitule
														-Code
														-EID
														-CID
							*/
								foreach ($st as $row) 
								{
									echo "<tr>
											<td>
												<form method=post action='modifintitule.php'>
													<input type=hidden value=$mid name=mid>$row[intitule]<input class=modifform type=text name=newintitule>
													<br><input type=image id='editpencil'
														src='../PICTURE/penciledit.png' title='Modifier intitulé''>
												</form>
										  	</td>
										  	<td>
												<form method=post action='modifcode.php'>
													<input type=hidden value=$mid name=mid>$row[code]<input class=modifform type=text name=newcode>
													<br><input type=image id='editpencil'  src='../PICTURE/penciledit.png' title='Modifier le Code'>
												</form>
										  	</td>
										  	<td>
												<form method=post action='modifeid.php'>
													<input type=hidden value=$mid name=mid>$row[eid]<input class=modifform type=number name=neweid min='1'>
													<br><input type=image id='editpencil' src='../PICTURE/penciledit.png' title='Modifier le l'enseignant>
												</form>
										  	</td>
										  	<td>
												<form method=post action='modifcid.php'>
													<input type=hidden value=$mid name=mid>$row[cid]<input class=modifform type=number name=newcid min='1'>
													<br><input type=image id='editpencil' src='../PICTURE/penciledit.png' title='Modifier la catégorie'>
												</form>
										  	</td>
										  <tr>";
								}		
							?>


							
						
						</table>
					</div>
				</div>
			</section>