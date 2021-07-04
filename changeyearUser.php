<?php
	require "FonctionTool.php";
	session_start();
	if(secure_exit($_POST["year"]))
	{
		write_log("Erreur Radio années : données non transmise");
		die("FATAL ERROR");
	}
	if($_POST["year"]!="2016" && $_POST["year"]!="2015")
	{	
		write_log("Erreur filtre année : Année invalide");
		die("FATAL ERROR");
	}
	$_SESSION["year"] = htmlspecialchars($_POST["year"]);
	header("Location: home_user.php");
?>