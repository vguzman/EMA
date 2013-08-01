<?
	set_time_limit(0);
	
	
	include "lib/util.php"; 
	include "lib/clases.php";
	
	
	$query=operacionSQL("SELECT COUNT(*) FROM Analysis");
	$total=mysql_result($query,0,0);
	
	
	$query=operacionSQL("SELECT * FROM Aux");
	$indice=mysql_result($query,0,0);
	
	
	$query=operacionSQL("SELECT id FROM Analysis WHERE status='A'");
	$analysis=mysql_result($query,$indice,0);
	
	
	echo $url="http://ema.vitoquen.com/sales.php?ana=".$analysis;
	echo "<br>";
	
	if (($indice+1)>=$total)
		$nuevo=0;
	else
		$nuevo=$indice+1;
	
	operacionSQL("UPDATE Aux SET var1=".$nuevo);
	
	$data=file_get_contents($url);
	
	echo $data;
	

?>