<?php 
	
	include "lib/util.php"; 
	include "lib/clases.php";
	
	$ana=new Analysis($_GET['ana']);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<LINK REL="stylesheet" TYPE="text/css" href="lib/basicos.css">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ebay Market Analytics (EMA)</title>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="border-bottom:3px solid #999; margin-bottom:25px;">
  <tr>
    <td width="496" class="Tahoma15Negro"><strong><? echo $ana->name ?></strong></td>
    <td width="10" class="Tahoma15Negro"><a href="index.php" class="linkFuncionalidad">&lt;&lt;&lt;&lt;</a></td>
  </tr>
</table>
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#CCFF66">
  <tr>
    <td width="200" height="30" class="Tahoma15Negro" align="center"><strong class="Tahoma15Negro">Semana</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Total Qty</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Total US$</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Average price</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Sellers</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Qty/Sellers</strong></td>
  </tr>
</table>
<p>
  <?
	
	$query=operacionSQL("SELECT WEEKDAY(NOW())");
	$resta=mysql_result($query,0,0);
		
	$query=operacionSQL("SELECT (CURDATE() - INTERVAL ".$resta." DAY)");
	$principio=mysql_result($query,0,0);
		
	
	$z=1;
	$s1=0;$s2=0;$s3=0;$s4=0;$s5=0;
	
	while (true)
	{
		
		$query=operacionSQL("SELECT ('".$principio."' - INTERVAL ".$z." WEEK)");
		$inicio_semana=mysql_result($query,0,0);
		
		$query=operacionSQL("SELECT ('".$inicio_semana."' + INTERVAL 7 DAY)");
		$fin_semana=mysql_result($query,0,0);
		
		
		$query=operacionSQL("SELECT SUM(A.qty), SUM(A.qty*A.price), AVG(A.price) FROM Sale A,Item B,Analysis C WHERE A.id_item=B.id AND C.id=B.id_analysis AND C.id=".$ana->id." AND A.date>'".$inicio_semana."' AND A.date<'".$fin_semana."'");
		
		//echo "<br><br>";
		$aux="SELECT DISTINCT(B.id_seller) FROM Sale A,Item B,Analysis C WHERE A.id_item=B.id AND C.id=B.id_analysis AND C.id=".$ana->id." AND A.date>'".$inicio_semana."' AND A.date<'".$fin_semana."'";
		//echo "<br><br>";
		$query2=operacionSQL($aux);
		
		
		
		echo '<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" style="border-bottom:solid 1px #999999;">
			  <tr>
				<td width="200" class="Tahoma13Negro" height="30">'.$inicio_semana.' - '.$fin_semana.'</td>
				<td width="100" class="Tahoma13Negro" align="center">'.mysql_result($query,0,0).'</td>
				<td width="100" class="Tahoma13Negro" align="center">'.mysql_result($query,0,1).'</td>
				<td width="100" class="Tahoma13Negro" align="center">'.number_format(mysql_result($query,0,2),2).'</td>
				<td width="100" class="Tahoma13Negro" align="center">'.mysql_num_rows($query2).'</td>
				<td width="100" class="Tahoma13Negro" align="center">'.number_format(mysql_result($query,0,0)/mysql_num_rows($query2),2).'</td>
			  </tr>
			</table>';
		
		
		$z++;
		
		
		$s1=$s1+mysql_result($query,0,0);
		$s2=$s2+mysql_result($query,0,1);
		$s3=$s3+mysql_result($query,0,2);
		$s4=$s4+mysql_num_rows($query2);
		$s5=$s5+(mysql_result($query,0,0)/mysql_num_rows($query2));
		
		
		if ($z>12)
			break;
		
	}
	
	echo '<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" style="border-bottom:solid 3px #999999;">
			  <tr>
				<td width="200" class="Tahoma13Negro" height="30"><strong>Totales</strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong>'.number_format($s1,2).'</strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong>'.number_format($s2,2).'</strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong></strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong></strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong></strong></td>
			  </tr>
			</table>';
	
	echo '<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" style="border-bottom:solid 3px #999999;">
			  <tr>
				<td width="200" class="Tahoma13Negro" height="30"><strong>Promedios</strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong>'.number_format($s1/12,2).'</strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong>'.number_format($s2/12,2).'</strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong>'.number_format($s3/12,2).'</strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong>'.number_format($s4/12,2).'</strong></td>
				<td width="100" class="Tahoma13Negro" align="center"><strong>'.number_format($s5/12,2).'</strong></td>
			  </tr>
			</table>';


?>
  
  
</p>
<p>&nbsp;</p>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCFF66">
  <tr>
    <td width="530" height="30" class="Tahoma15Negro" align="center"><strong class="Tahoma15Negro">Item</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Price</strong></td>
    <td width="70" class="Tahoma15Negro" align="center"><strong>Qty sold</strong></td>
  </tr>
</table>
<?
	$query=operacionSQL("SELECT ('".$principio."' - INTERVAL 12 WEEK)");
	$final=mysql_result($query,0,0);
	
	$begin=$final;
	$end=$principio;
	
	
	
	$query=operacionSQL("SELECT B.id,SUM(qty) AS CUENTA FROM Sale A,Item B, Analysis C WHERE A.id_item=B.id AND B.id_analysis=C.id AND C.id=".$ana->id." AND A.date>'".$begin."' AND A.date<'".$end."' GROUP BY B.id ORDER BY CUENTA DESC");
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$item=new Item(mysql_result($query,$i,0));
		
		echo '<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:solid 1px #999999;">
			  <tr>
				<td width="30" align="left" class="Tahoma13Negro">'.($i+1).'</td>
				<td width="500" height="30" align="left"><a href="http://www.ebay.com/itm/'.$item->id_ebay.'" class="linkFuncionalidad13" target="_blank">'.$item->title.'</a></td>
				<td width="100" align="left" class="Tahoma13Negro">US $'.$item->price.'</td>
				<td width="70" class="Tahoma13Negro" align="center">'.mysql_result($query,$i,1).'</td>
			  </tr>
			</table>';
	}

?>

<p>&nbsp;</p>

<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCFF66">
  <tr>
    <td width="230" height="30" class="Tahoma15Negro" align="center"><strong class="Tahoma15Negro">Seller</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Feed score</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>It listed</strong></td>
    <td width="70" class="Tahoma15Negro" align="center"><strong>Qty sold</strong></td>
  </tr>
</table>


  <?	
	$query=operacionSQL("SELECT B.id_seller,SUM(qty) AS CUENTA FROM Sale A,Item B, Analysis C WHERE A.id_item=B.id AND B.id_analysis=C.id AND C.id=".$ana->id." AND A.date>'".$begin."' AND A. date<'".$end."' GROUP BY B.id ORDER BY CUENTA DESC");
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$seller=new Seller(mysql_result($query,$i,0));
		
		echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:solid 1px #999999;">
			  <tr>
				<td width="30" align="left" class="Tahoma13Negro">'.($i+1).'</td>
				<td width="200" height="30" align="left"><a href="http://myworld.ebay.com/'.$seller->nick.'" class="linkFuncionalidad13" target="_blank">'.$seller->nick.'</a></td>
				<td width="100" align="center" class="Tahoma13Negro">'.number_format($seller->feedback_score,0,'.',',').'</td>
				<td width="100" align="center" class="Tahoma13Negro">'.number_format($seller->items_listed,0,'.',',').'</td>
				<td width="70" class="Tahoma13Negro" align="center">'.mysql_result($query,$i,1).'</td>
			  </tr>
			</table>';
	}

?>

<p>&nbsp; </p>

<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCFF66">
  <tr>
    <td width="200" height="30" class="Tahoma15Negro" align="center"><strong class="Tahoma15Negro">Price Rank</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Qty (%) </strong></td>
  </tr>
</table>
<p>
  <?
	$total_qty=$s1;
	$aux="SELECT DISTINCT(A.price) FROM Sale A, Item B WHERE A.id_item=B.id AND B.id_analysis=".$ana->id." AND date>'".$begin."' AND date<'".$end."' ORDER BY price ASC";
	//echo "<br>";
	$query=operacionSQL($aux);
	$total=mysql_num_rows($query);
	//echo $total." precios <br>";
	
	
	
	$z=-1;
	while (true)
	{
		
		$inicio=$z+1;
		$fin=$z+4;
		
		$z=$z+4;
		
		
		if ($z>=($total-1))
			$fin=$total-1;
		
		
		//echo $inicio." -- ".$fin."<br>";
		
		
		$inicio=mysql_result($query,$inicio,0);
		$fin=mysql_result($query,$fin,0);
		
		
		
		$query2=operacionSQL("SELECT SUM(qty) FROM Sale A, Item B WHERE A.id_item=B.id AND A.price>=".$inicio." AND A.price<=".$fin." AND date>'".$begin."' AND date<'".$end."' AND B.id_analysis=".$ana->id);
		$resul=mysql_result($query2,0,0);
		
		
		echo '<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:solid 1px #999999;">
			  <tr>
				<td width="200" height="30" align="left" class="Tahoma13Negro">US $'.$inicio.' - US $'.$fin.'</td>
				<td width="100" align="center" class="Tahoma13Negro">'.mysql_result($query2,0,0).' ('.number_format($resul*100/$s1,2).'%) </td>
			  </tr>
			</table>';
			
		if ($z>=($total-1))
			break;
			
	}
	
	
	

?>
  
</p>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCFF66">
  <tr>
    <td width="200" height="30" class="Tahoma15Negro" align="center"><strong class="Tahoma15Negro">Seller feedback score</strong></td>
    <td width="100" class="Tahoma15Negro" align="center"><strong>Qty </strong></td>
  </tr>
</table>
<?

	$aux="SELECT DISTINCT(feedback_score) FROM Sale A, Item B, Seller C WHERE A.id_item=B.id AND B.id_seller=C.id AND B.id_analysis=".$ana->id." AND date>'".$begin."' AND date<'".$end."' ORDER BY feedback_score ASC";
	//echo "<br>";
	$query=operacionSQL($aux);
	$total=mysql_num_rows($query);
	//echo $total." precios <br>";
	
	
	
	$z=-1;
	while (true)
	{
		
		$inicio=$z+1;
		$fin=$z+4;
		
		$z=$z+4;
		
		
		if ($z>=($total-1))
			$fin=$total-1;
		
		
		//echo $inicio." -- ".$fin."<br>";
		
		
		$from=mysql_result($query,$inicio,0);
		$to=mysql_result($query,$fin,0);
		
		
		
		
		
		
		$aux="SELECT SUM(qty) FROM Sale A, Item B, Seller C WHERE A.id_item=B.id AND B.id_seller=C.id AND feedback_score>=".$from." AND feedback_score<=".$to." AND date>'".$begin."' AND date<'".$end."' AND B.id_analysis=".$ana->id;
		//echo "<br><br>";
		$query2=operacionSQL($aux);
		$resul=mysql_result($query2,0,0);
		
		
		echo '<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:solid 1px #999999;">
			  <tr>
				<td width="200" height="30" align="left" class="Tahoma13Negro">'.number_format($from,0,',','.').' - '.number_format($to,0,',','.').'</td>
				<td width="100" align="center" class="Tahoma13Negro">'.mysql_result($query2,0,0).' ('.number_format($resul*100/$s1,2).'%) </td>
			  </tr>
			</table>';
			
			
		if ($z>=($total-1))
			break;
			
	}
	
	
	

?>
</body>
</html>
