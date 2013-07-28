<?
	session_start();
	
	include "lib/util.php"; 
	include "lib/clases.php"; 
	
	verificarSesion();
	
	$ana=new Analysis($_GET['ana']);
	
	
	error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

	// API request variables
	$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
	$version = '1.0.0';  // API version supported by your application
	$appid = 'vitoquen-9950-46c7-8268-54def9eb7d07';  // Replace with your own AppID
	$globalid = 'EBAY-US';  // Global ID of the eBay site you want to search (e.g., EBAY-DE)
	$query = $ana->search_keywords;  // You may want to supply your own query
	$safequery = urlencode($query);  // Make the query URL-friendly
	$i = '0';  // Initialize the item filter index to 0
	
	// Create a PHP array of the item filters you want to use in your request
	$filterarray =
	  array(
		array(
		'name' => 'Condition',
		'value' => 'New',
		'paramName' => '',
		'paramValue' => ''),
		array(
		'name' => 'FreeShippingOnly',
		'value' => 'true',
		'paramName' => '',
		'paramValue' => ''),
		array(
		'name' => 'ListingType',
		'value' => array('FixedPrice','StoreInventory'),
		'paramName' => '',
		'paramValue' => ''),
	  );

 	// Generates an indexed URL snippet from the array of item filters
	function buildURLArray ($filterarray) {
	  global $urlfilter;
	  global $i;
	  // Iterate through each filter in the array
	  foreach($filterarray as $itemfilter) {
		// Iterate through each key in the filter
		foreach ($itemfilter as $key =>$value) {
		  if(is_array($value)) {
			foreach($value as $j => $content) { // Index the key for each value
			  $urlfilter .= "&itemFilter($i).$key($j)=$content";
			}
		  }
		  else {
			if($value != "") {
			  $urlfilter .= "&itemFilter($i).$key=$value";
			}
		  }
		}
		$i++;
	  }
	  return "$urlfilter";
	} // End of buildURLArray function
	
	// Build the indexed item filter URL snippet
	buildURLArray($filterarray);
	
	// Construct the findItemsByKeywords HTTP GET call 
	$apicall = "$endpoint?";
	$apicall .= "OPERATION-NAME=findItemsByKeywords";
	$apicall .= "&SERVICE-VERSION=$version";
	$apicall .= "&SECURITY-APPNAME=$appid";
	$apicall .= "&GLOBAL-ID=$globalid";
	$apicall .= "&keywords=$safequery";
	$apicall .= "&paginationInput.entriesPerPage=50";
	$apicall .= "$urlfilter";
	
	
	//echo $apicall;
	//echo "<br><br><br>";
	$results = '';
	
	$resp = simplexml_load_file($apicall);
	$pages=$resp->paginationOutput->totalPages;
	
	if ($pages>10)
		$pages=10;
	
	for ($i=1;$i<=$pages;$i++)
	{
		
		$apicall .= "&paginationInput.pageNumber=".$i;		
		$resp = simplexml_load_file($apicall);
		
		
		
		
		// Check to see if the request was successful, else print an error
		if ($resp->ack == "Success") {
		 
		  // If the response was loaded, parse it and build links  
		  foreach($resp->searchResult->item as $item) {
			$pic   = $item->galleryURL;
			$link  = $item->viewItemURL;
			$title = $item->title;
			$price = $item->sellingStatus->currentPrice;
			$title = $item->title;
			$itemId = $item->itemId;
			
			
			$query2=operacionSQL("SELECT id FROM Item WHERE id_ebay='".trim($itemId)."' AND id_analysis=".$ana->id);
			if (mysql_num_rows($query2)==0)
				$img='<a href="javascript:selectItem('.chr(39).$itemId.chr(39).','.chr(39).$ana->id.chr(39).','.chr(39).'add'.chr(39).')"><img src="img/revision_no.gif" width="20" height="20" border="0" /></a>';
			else
				$img='<a href="javascript:selectItem('.chr(39).$itemId.chr(39).','.chr(39).$ana->id.chr(39).','.chr(39).'del'.chr(39).')"><img src="img/revision_si.gif" width="20" height="20" border="0" /></a>';
			
		  
			// For each SearchResultItem node, build a link and append it to $results
			$results .= '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
						  <tr>
							<td width="200"><img src="'.$pic.'" /></td>
							<td width="450" class="Tahoma15Negro">'.$itemId.'<br><a href="'.$link.'" target="_blank" class="LinkFuncionalidad15">'.$title.'</a></td>
							<td width="100"  class="Tahoma15Negro">US $'.$price.'</td>
							<td width="50" id="select_'.$itemId.'">'.$img.'</td>
						  </tr>
						</table>';
		  }
		}
		// If the response does not indicate 'Success,' print an error
		else {
		  $results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
		  $results .= "AppID for the Production environment.</h3>";
		}
		
		
		//echo "Page ".$i."<br><br>";
		
		
		
	}
	
	
	
	
	
	//echo $resp->paginationOutput->totalEntries." -- ".$resp->paginationOutput->totalPages;
	
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript" src="/lib/ajax.js"> </script>
<SCRIPT LANGUAGE="JavaScript">
	

function now()
{
	fecha = new Date();
	hora=""+fecha.getFullYear()+"-"+fecha.getMonth()+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
	return hora;
}
function chr(AsciiNum)
{

	return String.fromCharCode(AsciiNum)

}


var item_id;
var global_tipo;
var ana_id;
function selectItem(id,id_ana,tipo)
{
	global_tipo=tipo;
	item_id=id;
	ana_id=id_ana;
	
	document.getElementById('select_'+item_id).innerHTML='<img src="img/bigrotation2.gif" width="20" height="20" />';
	
	if (tipo=="add")
		url="itemsAdd.php?new_item="+id+"&ana_id="+id_ana+"&hora="+now()+"&tipo=choose";
	if (tipo=="del")
		url="itemsDelete.php?ebay_item="+id+"&ana="+id_ana+"&hora="+now()+"&tipo=choose";
	
	
	/*req=getXMLHttpRequest();
	req.onreadystatechange=process_selectItem;
	req.open("GET",url,true);
	req.send(null);*/
	
	if (global_tipo=='add')
	{
		var inner='<a href="javascript:selectItem('+chr(39)+item_id+chr(39)+','+chr(39)+ana_id+chr(39)+','+chr(39)+'del'+chr(39)+')"><img src="img/revision_si.gif" width="20" height="20" border="0" /></a>';
				//window.alert(inner);
		document.getElementById('select_'+item_id).innerHTML=inner;		
	}
	if (global_tipo=='del')
	{
		var inner='<a href="javascript:selectItem('+chr(39)+item_id+chr(39)+','+chr(39)+ana_id+chr(39)+','+chr(39)+'add'+chr(39)+')"><img src="img/revision_no.gif" width="20" height="20" border="0" /></a>';
				//window.alert(inner);
		document.getElementById('select_'+item_id).innerHTML=inner;		
	}
	
	window.open(url,url,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350");
	
	
}

function process_selectItem()
{
	if (req.readyState==4)
	{
		if (req.status==200)
		{	
			var response=req.responseText;
			//window.alert(global_tipo+item_id);
			
		} 
		else
			window.alert("Ha ocurrido un problema");      
	}
}

	
	
	
	
</SCRIPT>


<LINK REL="stylesheet" TYPE="text/css" href="lib/basicos.css">


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ebay Market Analytics (EMA)</title>
</head>

<body>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="border-bottom:3px solid #999; margin-bottom:25px;">
  <tr>
    <td width="770" class="Tahoma15Negro"><strong>Choose items for analysis: "<? echo $ana->name ?>"</strong></td>
    <td width="30" class="Tahoma15Negro"><a href="index.php" class="linkFuncionalidad">&lt;&lt;&lt;&lt;</a></td>
  </tr>
</table>
<? echo $results ?>
</body>
</html>
