<?php
require_once('Connection.php');
require_once('Entity.class.php');

getStatics();

if( isset($_POST['id']) )
{
	$req = explode('-', $_POST['id'] );
	$obj = $req[0]; //object to be modified (e or c)
	$oid = $req[1]; //object Id
	$atr = $req[2]; //object attribute to modify
	$val = $_POST['value']; //attribute's new value
	
	if( $obj == "e" ) //Entity
	{
		$entity = Entity::reincarnate($oid);
		switch($atr)
		{
			case "type":
				$entity->type = $val;
				$entity->updated = time();
				$entity->persist();
				$size = 3*UNIT;
				echo "<img src='img/$val.png' width='$size' height='$size' />";
				break;
				
			case "title":
				$entity->title = $val;
				$entity->updated = time();
				$entity->persist();
				echo $val;
				break;
				
			case "status":
				$entity->status = $val;
				$entity->updated = time();
				$entity->persist();
				$size = UNIT;
				$status = $entity->status;
				echo "<img src='img/$status.png' width='$size' height='$size' />";
				break;
				
			case "special":
				$entity->special = $val;
				$entity->updated = time();
				$entity->persist();
				echo $val;
				break;
				
			case "level":
				$entity->level = $val;
				$entity->updated = time();
				$entity->persist();
				echo $val;
				break;
				
			case "rating":
				$entity->rating = $val;
				$entity->updated = time();
				$entity->persist();
				echo $val;
				break;
				
			case "description":
				$entity->description = $val;
				$entity->updated = time();
				$entity->persist();
				echo $val;
				break;
				
			case "tags":
				$entity->tags = $val;
				$entity->tagify();
				$entity->updated = time();
				$entity->persist();
				$tags = $entity->getTags();
				$tlist = "";
				foreach($tags as $tag)
				{
					$tlist .= "<div class='tag' ><a href='Search_Engine.php?tags=$tag' > $tag </a></div>";
				}
				echo $tlist;
				break;
				
		}
	}
	else //$obj == "c" Comment
	{
		$entity = Entity::reincarnateByCid($oid);
		$com = $entity->commentObjs[$oid];
		switch($atr)
		{
			case "seqNo":
				$nval = $entity->changeSeqNo($oid, $val);
				echo $nval;
				break;
			
			case "special":
				$com->special = $val;
				$com->timeStamp = time();
				$entity->updated = $com->timeStamp;
				$com->persist();
				$entity->persist();
				echo $val;
				break;
			
			case "rating":
				$com->rating = $val;
				$com->timeStamp = time();
				$entity->updated = $com->timeStamp;
				$com->persist();
				$entity->persist();
				echo $val;
				break;
			
			case "comment":
				$com->comment = $val;
				$com->timeStamp = time();
				$entity->updated = $com->timeStamp;
				$com->persist();
				$entity->persist();
				echo $val;
				break;
				
		}
	}
}
?>