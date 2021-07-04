<?php

require("auth/EtreAuthentifie.php");

$title = 'Accueil';
include("header.php");
// echo "Hello " . $idm->getIdentity() .". Your uid is: ". $idm->getUid() .". Your role is: ".$idm->getRole();
?>


<!-- Traitement du rôle -->

<?php

if($idm->getRole()=='admin')	
{
	header("Location: home_admin.php");
}
else if($idm->getRole()=='user')
{
	header("Location: home_user.php");
}
else
{
	trigger_error("Rôle non déterminé",E_USER_ERROR);
	write_log("Problème de redirection : ".'('.$idm->getUid().')');
	exit(1);
}

//echo "Escaped values: ".$e_($ci->idm->getIdentity());


include("footer.php");