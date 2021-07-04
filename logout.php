<?php

require("auth/EtreAuthentifie.php");

$auth->clear();
$idm->clear();
// j'ai ajouté // 
unset($_SESSION["year"]);
redirect($pathFor['root']);