<?php
require_once('Connection.php');
require_once('Entity.class.php');

getStatics();

if( isset($_GET['id']) )
{
	$req = explode('-', $_GET['id'] );
	$obj = $req[0]; //object to be requested (e or c)
	$oid = $req[1]; //object Id
	$atr = $req[2]; //object attribute to return
	
	if( $obj == "e" ) //Entity
	{
		$entity = Entity::reincarnate($oid);
		$val = $entity->$atr;
		echo $val;
	}
	else //$obj == "c" Comment
	{
		$entity = Entity::reincarnateByCid($oid);
		$com = $entity->commentObjs[$oid];
		$val = $com->$atr;
		echo $val;
	}
}
?>