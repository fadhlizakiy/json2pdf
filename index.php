<?php
if($_POST)
{
	$title  = $_POST["title"];
	$layout = $_POST["layout"];
	$data   = json_decode($_POST["json"]);
	
	include('fzPOST.php');
}
else
{
	include('fzFORM.php');
}
?>