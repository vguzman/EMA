<?php
	
	include "lib/util.php"; 
	
	operacionSQL("INSERT INTO Analysis VALUES (NULL,'".trim($_POST['analysis_name'])."','".trim($_POST['analysis_name'])."',CURDATE(),'A')");
	
	
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='index.php';
		</SCRIPT>";

?>