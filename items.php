<?php 
	
	session_start();
	
	include "lib/util.php"; 
	include "lib/clases.php";
	
	verificarSesion();
	
	$ana=new Analysis($_GET['ana']); 
	
	$query=operacionSQL("SELECT id FROM Item WHERE id_analysis=".$ana->id);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<LINK REL="stylesheet" TYPE="text/css" href="lib/basicos.css">



<SCRIPT LANGUAGE="JavaScript">
	
	function del(id,ana)
	{
		var dec=window.confirm("Are you sure sure very sure?");
		
		if (dec==true)
			document.location.href="itemsDelete.php?ana="+ana+"&item="+id+"&tipo=add";
	}

</SCRIPT>






<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ebay Market Analytics (EMA)</title>
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:20px;">
  <tr>
    <td><a href="index.php" class="linkFuncionalidad"><<<<</a></td>
  </tr>
</table>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border-bottom:3px solid #999; margin-bottom:15px;">
  <tr>
    <td width="376" class="Tahoma15Negro"><strong><? echo $ana->name ?></strong></td> 
    <td width="224"><form id="form1" name="form1" method="post" action="itemsAdd.php?tipo==add">
      <label for="new_item"></label>
      <input name="new_item" type="text" id="new_item" size="15" />
      <input type="submit" name="button" id="button" value="Add item" />
      <input type="hidden" name="ana_id" id="ana_id" value="<? echo $ana->id ?>" />
    </form></td>
  </tr>
</table>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="Tahoma13Negro"><? echo mysql_num_rows($query) ?> results    </td>
  </tr>
</table>



<?
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$item=new Item(mysql_result($query,$i,0));
		
		
		echo '<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
			  <tr>
				<td style="padding:5px;" class="Tahoma13Negro">'.$item->id_ebay.' (<a href="javascript:del('.$item->id.','.$item->id_analysis.')" class="linkFuncionalidad">eliminar</a>)<br><a href="http://www.ebay.com/itm/'.$item->id_ebay.'" class="linkFuncionalidad13" target="_blank">'.$item->title.'</a> - US $'.$item->price.'  </td>
			  </tr>
			</table>';
	}

?>
</body>
</html>