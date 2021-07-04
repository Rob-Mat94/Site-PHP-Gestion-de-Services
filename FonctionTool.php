<?php

	function secure_exit($var)
	{
		if(!isset($var) || empty($var))
		{
			return true;
		}
		return false;
	}

	function write_log($message)
	{
		error_log("Erreur : ".date("d-m-Y").'/'.date("H:i").': '.$message.";".PHP_EOL,3,"../error.log");
	}


?>