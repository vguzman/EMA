<?php
	
	include "lib/util.php"; 
	include "lib/clases.php"; 
	
	
	
	$query=operacionSQL("SELECT id FROM Item WHERE id_analysis=".$_GET['ana']);
	
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$id_item=mysql_result($query,$i,0);
		operacionSQL("DELETE FROM Sale WHERE id_item=".$id_item);
	}
	
	operacionSQL("DELETE FROM Item WHERE id_analysis=".$_GET['ana']);
	operacionSQL("DELETE FROM Analysis WHERE id=".$_GET['ana']);
	
	
	
	echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='index.php';
		</SCRIPT>";
	
?>