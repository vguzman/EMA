<?php 
	
	include "lib/util.php"; 
	include "lib/clases.php"; 
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<SCRIPT LANGUAGE="JavaScript">
	
	function del(id)
	{
		var dec=window.confirm("Are you sure sure very sure?");
		
		if (dec==true)
			document.location.href="delete.php?ana="+id;
	}

</SCRIPT>


<LINK REL="stylesheet" TYPE="text/css" href="lib/basicos.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ebay Market Analytics (EMA)</title>
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style=" margin-top:30px; ">
  <tr>
    <td align="left"><form id="form1" name="form1" method="post" action="new.php">
      <label for="analysis_name"></label>
      <input name="analysis_name" type="text" id="analysis_name" size="40" />
      <input type="submit" name="button" id="button" value="Create new analysis" />
    </form></td>
  </tr>
</table>
<?
	$query=operacionSQL("SELECT id FROM Analysis");
	
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$ana=new Analysis(mysql_result($query,$i,0));
		
		
		$query2=operacionSQL("SELECT id FROM Item WHERE id_analysis=".$ana->id);
		$query3=operacionSQL("SELECT DISTINCT(A.nick) FROM Seller A, Item B, Analysis C WHERE A.id=B.id_seller AND B.id_analysis=C.id AND C.id=".$ana->id);
		
		echo '<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border-top:1px solid #999">
				  <tr>
					<td width="414" class="Tahoma15Negro"><strong>'.$ana->name.'</strong>
					<br>
					Search keywords: "'.$ana->search_keywords.'"
					<br>
					
					'.mysql_num_rows($query2).' items / '.mysql_num_rows($query3).' sellers
					<br>
					
					Created at '.$ana->date.'
					</td>
					<td width="186"><a href="items.php?ana='.$ana->id.'" class="linkFuncionalidad13">View items</a> <br /> <a href="chooseItems.php?ana='.$ana->id.'" class="linkFuncionalidad13">Choose items</a> <br /> <a href="sales.php?ana='.$ana->id.'" class="linkFuncionalidad13">Read item sales</a> <br /> <a href="reports.php?ana='.$ana->id.'" class="linkFuncionalidad13">View Reports and Analysis</a> <br /> <a href="edit.php?ana='.$ana->id.'" class="linkFuncionalidad13">Edit analysis</a>  <br /> <a href="javascript:del('.$ana->id.')" class="linkFuncionalidad13">Delete</a></td>
				  </tr>
				</table>';
		 
	}


?>
`



</body>
</html>
