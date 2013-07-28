<?php
	
	session_start();
	
	include "lib/util.php"; 
	include "lib/clases.php"; 

	verificarSesion();
	
	if (isset($_GET['item']))
		$id_item=$_GET['item'];
	if (isset($_GET['ebay_item']))
	{
		$query=operacionSQL("SELECT id FROM Item WHERE id_ebay='".$_GET['ebay_item']."'");
		$id_item=mysql_result($query,0,0);
	}
	
	operacionSQL("DELETE FROM Sale WHERE id_item=".$id_item);
	operacionSQL("DELETE FROM Item WHERE id=".$id_item);
	
	if ($_GET['tipo']=="choose")
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			window.close();
		</SCRIPT>";
	else	
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='items.php?ana=".$_GET['ana']."';
		</SCRIPT>";
	
?>