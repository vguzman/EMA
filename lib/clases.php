<?php
	
	include_once "util.php";
	

	class Analysis
	{
		var $id;
		var $name;
		var $search_keywords;
		var $date;
		var $status;
		
		function Analysis($id)
		{
			$this->id=$id;
			$query=operacionSQL("SELECT * FROM Analysis WHERE id=".$id);
			$this->name=mysql_result($query,0,1);
			$this->search_keywords=mysql_result($query,0,2);
			$this->date=mysql_result($query,0,3);
			$this->status=mysql_result($query,0,2);
		} 
	}
	
	class Item
	{
		var $id;
		var $id_analysis;
		var $id_seller;
		var $id_ebay;
		var $title;
		var $price;
		var $location;
		var $status;
		
		function Item($id)
		{
			$this->id=$id;
			$query=operacionSQL("SELECT * FROM Item WHERE id=".$id);
			$this->id_analysis=mysql_result($query,0,1);
			$this->id_seller=mysql_result($query,0,2);
			$this->id_ebay=mysql_result($query,0,3);
			$this->title=mysql_result($query,0,4);
			$this->price=mysql_result($query,0,5);
			$this->location=mysql_result($query,0,6);
			$this->status=mysql_result($query,0,7);
		} 
	}
	
	
	class Sale
	{
		var $id;
		var $id_item;
		var $date;
		var $qty;
		var $price;
		
		function Sale($id)
		{
			$this->id=$id;
			$query=operacionSQL("SELECT * FROM Sale WHERE id=".$id);
			$this->id_item=mysql_result($query,0,1);
			$this->date=mysql_result($query,0,2);
			$this->qty=mysql_result($query,0,3);
			$this->price=mysql_result($query,0,4);
		} 
	}
	
	
	class Seller
	{
		var $id;
		var $nick;
		var $feedback_score;
		var $items_listed;
		
		function Seller($id)
		{
			$this->id=$id;
			$query=operacionSQL("SELECT * FROM Seller WHERE id=".$id);
			$this->nick=mysql_result($query,0,1);
			$this->feedback_score=mysql_result($query,0,2);
			$this->items_listed=mysql_result($query,0,3);
		} 
	}
	


?>