<?php
	
	session_start();
	
	include "lib/util.php"; 
	
	verificarSesion();
	
	
	if (isset($_POST['new_item']))
		$item_id=$_POST['new_item'];
	if (isset($_GET['new_item']))
		$item_id=$_GET['new_item'];
	
	if (isset($_POST['ana_id']))
		$ana_id=$_POST['ana_id'];
	if (isset($_GET['ana_id']))
		$ana_id=$_GET['ana_id'];
	
	
	
	$query=operacionSQL("SELECT * FROM Item WHERE id_ebay='".$item_id."' AND id_analysis=".$ana_id);
	if (mysql_num_rows($query)>0)
	{
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			window.alert('ERROR: Item is already added');
			document.location.href='items.php?ana=".$ana_id."';
		</SCRIPT>";
		exit;
	}
	
	echo $url="http://www.ebay.com/itm/".$item_id;
	echo "<br>";
	$text=file_get_contents($url);


	
	$title=textBetween($text,"<title>","|");
	
	echo $title;
	echo "<br>";
	
	
	$price=textBetween($text,'style="">US $','</span>');
	
	echo $price;
	echo "<br>";
	
	
	
	$seller=textBetween($text,'class="mbg-nw">','</span>');
	echo $seller;
	echo "<br>";
	
	
	$location=textBetween($text,'location:</span>','</div>');
	$pos=strpos($location,"United States");
	
	if ($pos===false)
		$location="NUSA";
	else
		$location="USA";
	
	
	echo $location;
	echo "<br>";
	
	
	
	//AHORA VAMOS CON LA INFO DEL VENDEDOR
	
	$text=file_get_contents("http://myworld.ebay.com/".$seller);
	
	$score=textBetween($text,'xmlns="">','</a>');
	echo "Score: ".$score;
	echo "<br>";
	
	
	echo $url="http://www.ebay.com/sch/".$seller."/m.html?_armrs=1";
	echo "<br>";
	$text=file_get_contents($url);
	$listed=textBetween($text,'class="rcnt">','</span>');
	$listed=str_replace(",","",$listed);
	echo "Listed: ".$listed;
	echo "<br>";
	
	
	
	//AHORA LA CARGA EN BD
	//PRIMERO EL VENDEDOR
	$query=operacionSQL("SELECT * FROM Seller WHERE nick='".trim($seller)."'");
	if (mysql_num_rows($query)==0)
		operacionSQL("INSERT INTO Seller VALUES (null,'".trim($seller)."',".$score.",".$listed.")");
	
	$query=operacionSQL("SELECT id FROM Seller WHERE nick='".trim($seller)."'");
		$id_seller=mysql_result($query,0,0);	
	
	
	//AHORA CON LA CERTEZA DEL VENDEDOR CARGADO VOY CON EL ARTICULO
	$query=operacionSQL("SELECT * FROM Item WHERE id_ebay='".$item_id."' AND id_analysis=".$ana_id);
	if (mysql_num_rows($query)==0)
		operacionSQL("INSERT INTO Item VALUES (null,".$ana_id.",".$id_seller.",'".$item_id."','".$title."',".$price.",'".$location."','A')");
	else
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			window.alert('ERROR: Item is already added');
		</SCRIPT>";
		
		
	if ($_GET['tipo']=="choose")
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			window.close();
		</SCRIPT>";
	else	
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='items.php?ana=".$ana_id."';
		</SCRIPT>";
	




?>