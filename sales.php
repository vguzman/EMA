<?php	
	session_start();
	set_time_limit(0);
	
	
	include "lib/util.php"; 
	include "lib/clases.php"; 
	
	verificarSesion();
	
	$ana_id=$_GET['ana'];
	
	$query=operacionSQL("SELECT id FROM Item WHERE id_analysis=".$ana_id);
	
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$item=new Item(mysql_result($query,$i,0));
		
		$url="http://offer.ebay.com/ws/eBayISAPI.dll?ViewBidsLogin&rt=nc&item=".$item->id_ebay;
		$text=file_get_contents($url);
		
		
		echo $url;
		echo "<br>";
		$aux=explode('class="contentValueFont">US $',$text);
		
		//echo "<br>".count($aux)."<br>";
		
		
		for ($e=1;$e<count($aux);$e++)
		{
			$price=explode("</td>",$aux[$e]);
			$price=$price[0];
			
			echo $price." -- ";
			
			
			$qty=explode('"contentValueFont">',$aux[$e]);
			$qty=$qty[1];
			$qty=explode('</td>',$qty);
			$qty=$qty[0];
			
			
			echo $qty." -- ";
			
			
			
			
			
			
			$date=explode('"contentValueFont">',$aux[$e]);
			$date=$date[2];
			$date=explode('</td>',$date);
			$date=trim($date[0]);
			$date=explode('P',$date);
			$date=trim($date[0]);
			
			//TRANSLATE DATE TO MYSQL FORMAT
			$time=explode(' ',$date);
			$date=$time[0];
			$time=$time[1];
			
			
			
			$auxx=explode('-',$date);
			$year="20".$auxx[2];
			$dom=$auxx[1];
			$month=$auxx[0];
			
			if ($month=="Jan")
				$month="01";
			if ($month=="Feb")
				$month="02";
			if ($month=="Mar")
				$month="03";
			if ($month=="Apr")
				$month="04";
			if ($month=="May")
				$month="05";
			if ($month=="Jun")
				$month="06";
			if ($month=="Jul")
				$month="07";
			if ($month=="Aug")
				$month="08";
			if ($month=="Sep")
				$month="09";
			if ($month=="Oct")
				$month="10";
			if ($month=="Nov")
				$month="11";
			if ($month=="Dec")
				$month="12";
			
			
			
			echo $date=$year."-".$month."-".$dom." ".$time;
			echo "<br>";
			
			
			
			$query2=operacionSQL("SELECT * FROM Sale WHERE id_item=".$item->id." AND date='".$date."'");
			if (mysql_num_rows($query2)==0)
				operacionSQL("INSERT INTO Sale VALUES (null,".$item->id.",'".$date."',".$qty.",".$price.")");
			
		}
		
		echo "<br><br><br>";
	}
	
	echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='index.php';
		</SCRIPT>";
	
?>