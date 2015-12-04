<?php
require_once('Connection.php');
require_once('Entity.class.php');

getStatics();

if( isset( $_POST['img'] ) )
{
	$cid = $_POST['img'];
	$entity = Entity::reincarnateByCid($cid);
	$entity->commentObjs[$cid]->deleteImage();
	$entity->updated = $entity->commentObjs[$cid]->timeStamp;
	$entity->commentObjs[$cid]->persist();
	$entity->persist();
}
else if( isset( $_POST['cid'] ) )
{
	$cid = $_POST['cid'];
	$entity = Entity::reincarnateByCid($cid);
	$entity->deleteComment($cid);
	
	//redirect
	$host = $_SERVER['HTTP_HOST'];
	$page = "T2B/Post_Central.php";
	$query = "id=".$entity->id;
	header("Location: http://$host/$page?$query");
}
else if( isset( $_POST['eid'] ) )
{
	$Eid = $_POST['eid'];
	Entity::delete($Eid);
	
	//redirect
	$host = $_SERVER['HTTP_HOST'];
	$page = "T2B/Home.php";
	header("Location: http://$host/$page");
}

setStatics();
?>