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







<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ebay Market Analytics (EMA)</title>
</head>

<body>

<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:20px;">
  <tr>
    <td><a href="index.php" class="linkFuncionalidad">&lt;&lt;&lt;&lt;</a></td>
  </tr>
</table>
<form id="form1" name="form1" method="post" action="edit2.php">

<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="133" class="Tahoma13Negro"><strong>Name
      <input name="ana" type="hidden" id="ana" value="<? echo $ana->id ?>" />
    </strong></td>
    <td width="467"><label for="name"></label>
      <input name="name" type="text" id="name" value="<? echo $ana->name ?>" size="50" /></td>
  </tr>
  <tr>
    <td class="Tahoma13Negro"><strong>Search Keywords</strong></td>
    <td><label for="url"></label>
      <input name="url" type="text" id="url" value="<? echo $ana->search_keywords ?>" size="50" /></td>
  </tr>
</table>
<p align="center">
  <input type="submit" name="button" id="button" value="Edit" />
</p>
</form>
</body>
</html>