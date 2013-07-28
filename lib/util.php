<?php



function operacionSQL($aux)
{
	$link=mysql_connect ("localhost","root","123456") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db("EMA");	
	$query=mysql_query($aux,$link);
	
	//mysql_close($link);
	
	
	if (!($query))
	{
		echo $error=mysql_error();
		echo "<br><br>";
		//mysql_query("INSERT INTO errormysql VALUES ('".$aux."','".$error."')",$link);
		mysql_close($link);
	}
	else
	{
		mysql_close($link);
		return $query;	
	}
}


function textBetween($text,$begin,$end)
{
	$aux=explode($begin,$text);
	$aux=explode($end,$aux[1]);
	
	return trim($aux[0]);	
	
}




function verificarSesion()
{
	if (!session_is_registered('granted'))
	{
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			window.alert('ERROR');
			document.location.href='sesion.php';
		</SCRIPT>";
		exit;
	}
	

}


?>
