<!-- Bouton annuler -->
 	<section class ="row" nane="annuler">
 		<div class ="col-1 offset-11">
 			<a href="CRUDgroupes.php"><p><img src="../PICTURE/cancel.png" title ="Annuler"></p></a>
 		</div>
 	</section>

 <!-- Tableaux avec les valeurs modifiables -->

	 <section class ="row" name=\TableauGroupe\>
				<div class ="col-12">
					<div class="tab_modif">	
						<table class = "table">
							<tr>
								<th>MID (module)</th>
								<th>Nom</th>
								<th>GTID (gtype)</th>
							</tr>

							<?php

							$SQL = "SELECT mid,nom,gtid FROM groupes WHERE gid =:id";

							$gid = intval($_POST["idmodif"]);
							$st = $db->prepare($SQL);
							$st -> execute(["id"=>$gid]);

							/* FORMULAIRE MODIFICATION : 
														-MID
														-Nom
														-GTID
							*/
								foreach ($st as $row) 
								{
									echo "<tr>
											<td>
												<form method=post action='modifmid.php'>
													<input type=hidden value=$gid name=gid>$row[mid]<input class=modifform type=number name=newmid min='1'>
													<br><input type=image id='editpencil'
														src='../PICTURE/penciledit.png' title='Modifier le module'>
												</form>
										  	</td>
										  	<td>
												<form method=post action='modifnom.php'>
													<input type=hidden value=$gid name=gid>$row[nom]<input class=modifform type=text name=newnom>
													<br><input type=image id='editpencil'  src='../PICTURE/penciledit.png' title='Modifier le Nom'>
												</form>
										  	</td>
										  	<td>
												<form method=post action='modifgtid.php'>
													<input type=hidden value=$gid name=gid>$row[gtid]<input class=modifform type=number name=newgtid min='1'>
													<br><input type=image id='editpencil' src='../PICTURE/penciledit.png' title='Modifier le gtype'>
												</form>
										  	</td>
										  <tr>";
								}		
							?>


							
						
						</table>
					</div>
				</div>
			</section>