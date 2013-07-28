<?
	session_start();

	include "lib/util.php";
	
	if (trim($_POST['check'])=="oliver1983")
	{
		$_SESSION['granted']="OK";
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='index.php';
		</SCRIPT>";
	}
	else
	{
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			window.alert('ERROR');
			document.location.href='sesion.php';
		</SCRIPT>";
	}
	

?>