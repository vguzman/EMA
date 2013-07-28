<?php
	
	session_start();
	
	include "lib/util.php"; 
	
	verificarSesion();
	
	
	operacionSQL("UPDATE Analysis SET name='".trim($_POST['name'])."', search_keywords='".trim($_POST['url'])."' WHERE id=".$_POST['ana']);
	
	
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='index.php';
		</SCRIPT>";

?>