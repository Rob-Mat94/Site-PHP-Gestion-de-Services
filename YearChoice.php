<?php
	if($_SESSION["year"]=="2016")
	{
		echo "<form method=\"post\" action=\"changeyearUser.php\">
   			 <input class=\"btn btn-secondary\" type=\"submit\" id=\"year\"
    		 name=\"year\" value=\"2015\">";
	}
	else if($_SESSION["year"]=="2015")
	{
		echo "<form method=\"post\" action=\"changeyearUser.php\">
   			 <input class=\"btn btn-secondary\" type=\"submit\" id=\"year\"
    		 name=\"year\" value=\"2016\">";
	}

?>