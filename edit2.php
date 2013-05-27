<?php
	
	include "lib/util.php"; 
	
	operacionSQL("UPDATE Analysis SET name='".trim($_POST['name'])."', search_keywords='".trim($_POST['url'])."' WHERE id=".$_POST['ana']);
	
	
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='index.php';
		</SCRIPT>";

?>