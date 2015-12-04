<?php
require_once('Connection.php');
require_once('Entity.class.php');

if( isset( $_POST['submit'] ) )
{
	getStatics();
	$cid = $_POST['submit'];
	
	if($cid == 0)
	{
		$entity = Entity::reincarnate($_POST['eid']);
		$com = $entity->addComment("",
								   $_POST['comment'],
								   $_POST['rating'],
								   $_POST['special']
								   );
		//File upload
		$cid = $com->id;
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		
		if ( !($_FILES["file"]["error"] > 0) )
		{
			$image = "store/img-$cid.$extension";
			move_uploaded_file($_FILES["file"]["tmp_name"], $image);
			
			$com->image = $image;
			$com->timeStamp = time();
			$entity->updated = $com->timeStamp;
			$com->persist();
			$entity->persist();
		}
		
		setStatics();
	}
	else
	{
		$entity = Entity::reincarnateByCid($cid);
		$com = $entity->commentObjs[$cid];
		
		//File upload
		$cid = $com->id;
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		
		if ( !($_FILES["file"]["error"] > 0) )
		{
			$image = "store/img-$cid.$extension";
			move_uploaded_file($_FILES["file"]["tmp_name"], $image);
			
			$com->image = $image;
			$com->timeStamp = time();
			$entity->updated = $com->timeStamp;
			$com->persist();
			$entity->persist();
		}
	}
	//redirect
	$host = $_SERVER['HTTP_HOST'];
	$page = "T2B/Post_Central.php";
	$query = "id=".$entity->id;
	header("Location: http://$host/$page?$query");
}
?>