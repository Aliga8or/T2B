<?php
const UNIT = 20;
const FONT = 30;

class Entity
{
	public $id;
	public $title;
	public $description;
	public $type;
	//public $imageObjs;
	public $commentObjs;
	public $commentList;
	public $tags;
	public $nxtSeqNo;
	public $created;
	public $updated;
	public $status;
	public $level;
	public $rating;
	public $special;
	//public $myComments;
	public static $nxtEntity;
	
	public function __construct($id, $title, $description, $type, $commentList, $tags, $nxtSeqNo, $created, $updated, $status, $level, $rating, $special)
	{
		$this->id = $id; 						
		$this->title = $title;
		$this->description = $description;
		$this->type = $type;
		$this->commentList = $commentList;
		$this->tags = $tags;
		$this->nxtSeqNo = $nxtSeqNo; 			
		$this->created = $created;			
		$this->updated = $updated;
		$this->status = $status;
		$this->level = $level;
		$this->rating = $rating;
		$this->special = $special;
	}
	
	public static function addEntity($title, $description, $type, $tags, $status, $level, $rating, $special)
	{
		$id = Entity::$nxtEntity++;
		$commentList = "";
		$nxtSeqNo = 1;
		$created = time();
		$updated = $created;
		$entityObj = new Entity($id,
								$title,
								$description,
								$type,
								$commentList,
								$tags,
								$nxtSeqNo,
								$created,
								$updated,
								$status,
								$level,
								$rating,
								$special
								);
		$entityObj->persist();
		return $entityObj;
	}
	
	/*public function addLink($image, $restart)
	{
		$imageObj = new Link(self::$nxtLink++, $image, $this->id, $restart, $this->nxtSeqNo++, time());
		$imageObj->persist();
		return $imageObj;
	}*/
	
	public function addComment($image, $comment, $rating, $special)
	{
		$eid = $this->id;
		$cid = Comment::$nxtComment++;
		$seqNo = $this->nxtSeqNo++;
		$time = time();
		$this->commentObjs[$cid] = new Comment($cid,
											   $image,
											   $comment,
											   $eid, $seqNo,
											   $time,
											   $rating,
											   $special
											   );
		$this->addToList($cid);
		$this->updated = $time;
		$this->commentObjs[$cid]->persist();
		$this->persist();
		return $this->commentObjs[$cid];
	}
	
	public function deleteComment($cid)
	{
		$this->reincarnateComments();
		$this->commentObjs[$cid]->deleteImage();
		foreach($this->commentObjs as $comment)
		{
			if($comment->seqNo > $this->commentObjs[$cid]->seqNo){
				$comment->seqNo--;
				$comment->timeStamp = time();
				$comment->persist();
			}
		}
		$this->delFromList($cid);
		$this->nxtSeqNo--;
		$this->updated = time();
		$this->persist();
		$query = "delete from Comment where id = '".$cid."' ";
		mysql_query($query) or die ("Error in query: $query. ".mysql_error());
	}
	
	public function changeSeqNo($cid, $newSeq)
	{
		if($newSeq >= $this->nxtSeqNo)
		{
			return 0;
		}
		else
		{
			$this->reincarnateComments();
			$com = $this->commentObjs[$cid];
			$oldSeq = $com->seqNo;
			
			if($newSeq == $oldSeq)
			{
				return $oldSeq;
			}
			else if ($newSeq < $oldSeq)
			{
				foreach($this->commentObjs as $c)
				{
					if( ($c->seqNo >= $newSeq) && ($c->seqNo < $oldSeq) )
					{
						$c->seqNo++;
						//$c->timeStamp = time();
						$c->persist();
					}
				}
				$com->seqNo = $newSeq;
				//$com->timeStamp = time();
				$com->persist();
				//$this->updated = $com->timeStamp;
				$this->persist();
				return $newSeq;
			}
			else if ($newSeq > $oldSeq)
			{
				foreach($this->commentObjs as $c)
				{
					if( ($c->seqNo <= $newSeq) && ($c->seqNo > $oldSeq) )
					{
						$c->seqNo--;
						//$c->timeStamp = time();
						$c->persist();
					}
				}
				$com->seqNo = $newSeq;
				//$com->timeStamp = time();
				$com->persist();
				//$this->updated = $com->timeStamp;
				$this->persist();
				return $newSeq;
			}
		}
	}
	
	public function persist()
	{
		$query = "select * from Entity where id = '".$this->id."' ";
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		
		if (mysql_num_rows($result)==0)
		{
			$query = "insert into Entity (id,
										  title,
										  description,
										  type,
										  commentList,
										  tags,
										  nxtSeqNo,
										  created,
										  updated,
										  status,
										  level,
										  rating,
										  special
										  )
											 values('".$this->id."',
													'".mysql_real_escape_string($this->title)."',
													'".mysql_real_escape_string($this->description)."',
													'".$this->type."',
													'".$this->commentList."',
													'".$this->tags."',
													'".$this->nxtSeqNo."',
													'".$this->created."',
													'".$this->updated."',
													'".$this->status."',
													'".$this->level."',
													'".$this->rating."',
													'".$this->special."'
													)
					 ";
			/*echo $query;*/
		}
		else
		{
			$query = "update Entity set title = '".mysql_real_escape_string($this->title)."',
										description = '".mysql_real_escape_string($this->description)."',
										type = '".$this->type."',
										commentList = '".$this->commentList."',
										tags = '".$this->tags."',
										nxtSeqNo = '".$this->nxtSeqNo."',
										created = '".$this->created."',
										updated = '".$this->updated."',
										status = '".$this->status."',
										level = '".$this->level."',
										rating = '".$this->rating."',
										special = '".$this->special."'
										where id = '".$this->id."'
						";
		}
		mysql_query($query) or die ("Error in query: $query. ".mysql_error());
	}
	
	public static function reincarnate($id)
	{
		$query = "select * from Entity where id =".$id;
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		$row = mysql_fetch_assoc($result);
		$entityObj = new Entity($id,
								$row['title'],
								$row['description'],
								$row['type'],
								$row['commentList'],
								$row['tags'],
								$row['nxtSeqNo'],
								$row['created'],
								$row['updated'],
								$row['status'],
								$row['level'],
								$row['rating'],
								$row['special']
								);
		return $entityObj;
	}
	
	public static function reincarnateByCid($cid)
	{
		$query = "select entityId from Comment where id =".$cid;
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		$row = mysql_fetch_assoc($result);
		$entity = Entity::reincarnate($row['entityId']);
		$entity->commentObjs[$cid] = Comment::reincarnate($cid);
		return $entity;
	}
	
	public static function generateEntityList($query)
	{
		$ttab = "";
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		if(mysql_num_rows($result)==0)
		{
			return $ttab;
		}
		
		while($row = mysql_fetch_assoc($result))
		{
			$entityObjs[ $row['id'] ] = Entity::reincarnate( $row['id'] );
		}

		//Header Table
		$ttab .= "<div class='eList'>";
		$ttab .= "<table>";
		$ttab .= "<tr>";
		
		//type
		$size = 3*UNIT;
		$ttab .= "<td rowspan=2 width='$size' align='center' ><u><i> Type </i></u></td>";
		//id
		$size = 2*UNIT;
		$ttab .= "<td width='$size' align='center' ><u><i> Id </i></u></td>";
		//title
		$ttab .= "<td align='center' ><u><i> Title </i></u></td>";
		//updated
		$size = 6*UNIT;
		$ttab .= "<td width='$size' align='center' ><u><i> Updated </i></u></td>";
		//level
		$size = 2*UNIT;
		$ttab .= "<td width='$size' align='center' ><u><i> Lvl </i></u></td>";
		//rating
		$ttab .= "<td width='$size' align='center' ><u><i> Rate </i></u></td>";
		//status
		$size = 3*UNIT;
		$ttab .= "<td width='$size' align='center' ><u><i> Status </i></u></td>";
		
		$ttab .= "</tr>";
		$ttab .= "</table>";
		$ttab .= "</div>";
		
		//Content Table
		foreach($entityObjs as $entity)
		{
			$class = $entity->special ? "special" : "eList" ;
			$ttab .= "<div class='$class' title='$entity->description' >";
			
			$ttab .= "<table>";
			$ttab .= "<tr >";
			
			//type
			$type = $entity->type;
			$size = 3*UNIT;
			$ttab .= "<td rowspan=2 width='$size' > <img src='img/$type.png' width='$size' height='$size' /> </td>";
			//id
			$size = 2*UNIT;
			$ttab .= "<td rowspan=2 width='$size' align='center' > $entity->id </td>";
			//title
			$ttab .= "<td style='text-transform:uppercase; ' > <a href='Post_Central.php?id=$entity->id' ><b> $entity->title </b></a> </td>";
			//updated
			$size = 6*UNIT;
			$up = getFmtdDate($entity->updated, 'jS M Y');
			$ttab .= "<td width='$size' align='center' > $up </td>";
			//level
			$size = 2*UNIT;
			$ttab .= "<td width='$size' align='center' > $entity->level </td>";
			//rating
			$ttab .= "<td width='$size' align='center' > $entity->rating </td>";
			//status
			$status = $entity->status;
			$size = UNIT;
			$tdSize = 3*UNIT;
			$ttab .= "<td width='$tdSize' align='center' > <img src='img/$status.png' width='$size' height='$size' /> </td>";
			
			$ttab .= "</tr>";
			$ttab .= "<tr>";
			
			//tags
			$ttab .= "<td colspan=7>";
			$tags = $entity->getTags();
			foreach($tags as $tag)
			{
				$ttab .= "<div class='tag' ><a href='Search_Engine.php?tags=$tag'> $tag </a></div>";
			}
			$ttab .= "</td>";
			
			$ttab .= "</tr>";
			$ttab .= "</table>";
			
			$ttab .= "</div>";
		}
		
		return $ttab;
	}
	
	public function reincarnateComments()
	{
		$cids = explode(",", $this->commentList);
		foreach($cids as $cid)
		{
			$this->commentObjs[$cid] = Comment::reincarnate($cid);
		}
		
	}
	
	public function commentsBySeq()
	{
		$clist;
		foreach( $this->commentObjs as $comment )
		{
			$clist[$comment->seqNo] = $comment;
		}
		return $clist;
	}
	
	public function tagify()
	{
		$tags = explode(",", $this->tags);
		
		$query = "select * from Tags where entityId = '".$this->id."' ";
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		while($row = mysql_fetch_assoc($result))
		{
			if( !(in_array($row['tag'], $tags)) )
			{
				$query = "delete from tags where entityId = '".$this->id."' and tag = '".$row['tag']."' ";
				mysql_query($query) or die ("Error in query: $query. ".mysql_error());
			}
		}
		
		foreach($tags as $tag)
		{
			$query = "select * from Tags where entityId = '".$this->id."' and tag = '".$tag."' ";
			$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
			if ( (mysql_num_rows($result)==0) && ($tag != "") )
			{
				$query = "insert into Tags(entityId, tag) values('".$this->id."',
																 '".$tag."'
																 )
						 ";
				mysql_query($query) or die ("Error in query: $query. ".mysql_error());
			}
		}
		
	}
	
	public function getTags()
	{
		$tags = explode(",", $this->tags);
		return $tags;
	}
	
	public function addToList($cid)
	{
		if( $this->commentList == "" ){
			$this->commentList .= $cid ;
		}
		else{
			$this->commentList .= ",".$cid ;
		}
	}
	
	public function delFromList($cid)
	{
		$this->commentList = str_replace( (",".$cid), "", $this->commentList);
		$this->commentList = str_replace( ($cid.","), "", $this->commentList);
		$this->commentList = str_replace( ($cid), "", $this->commentList);
	}
	
	public static function delete($id)
	{
		$query = "delete from Entity where id=".$id;
		mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		$query = "delete from Comment where entityId=".$id;
		mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		$query = "delete from tags where entityId=".$id;
		mysql_query($query) or die ("Error in query: $query. ".mysql_error());
	}
}

class Comment
{
	public $id;
	public $image;
	public $comment;
	public $entityId;
	//public $restart;
	public $seqNo;
	public $timeStamp;
	public $rating;
	public $special;
	public static $nxtComment;
	
	public function __construct($id, $image, $comment, $entityId, $seqNo, $timeStamp, $rating, $special)
	{
		$this->id = $id; 					
		$this->image = $image;
		$this->comment = $comment;
		$this->entityId = $entityId;
		//$this->restart = $restart;
		$this->seqNo = $seqNo;
		$this->timeStamp = $timeStamp; 			
		$this->rating = $rating;
		$this->special = $special;
	}
	
	public function deleteImage()
	{
		unlink($this->image);
		$this->image = "";
		$this->timeStamp = time();
	}
	
	public function persist()
	{
		$query = "select * from Comment where id = '".$this->id."' ";
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		
		if (mysql_num_rows($result)==0)
		{
			$query = "insert into Comment(id,
										  image,
										  comment,
										  entityId,
										  seqNo,
										  timeStamp,
										  rating,
										  special
										  )
										  values('".$this->id."',
												 '".$this->image."',
												 '".mysql_real_escape_string($this->comment)."',
												 '".$this->entityId."',
												 '".$this->seqNo."',
												 '".$this->timeStamp."',
												 '".$this->rating."',
												 '".$this->special."'
												 )
					  ";
		}
		else
		{
			$query = "update Comment set image = '".$this->image."',
										 comment = '".mysql_real_escape_string($this->comment)."',
										 entityId = '".$this->entityId."',
										 seqNo = '".$this->seqNo."',
										 timeStamp = '".$this->timeStamp."',
										 rating = '".$this->rating."',
										 special = '".$this->special."'
										 where id = '".$this->id."'
					 ";
		}
		mysql_query($query) or die ("Error in query: $query. ".mysql_error());
	}
	
	public static function reincarnate($id)
	{
		$query = "select * from Comment where id = '".$id."' ";
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		$row = mysql_fetch_assoc($result);
		$comment = new Comment($row['id'],
							   $row['image'],
							   $row['comment'],
							   $row['entityId'],
							   $row['seqNo'],
							   $row['timeStamp'],
							   $row['rating'],
							   $row['special']
							   );
		return $comment;
	}
}

/*class Link
{
	public $id;
	public $link;
	public $entityId;
	public $restart;
	public $seqNo;
	public $timeStamp;
	public static $nxtLink;
	
	public function __construct($id, $link, $entityId, $restart, $seqNo, $timeStamp)
	{
		$this->id = $id; 						//self::$nxtLink++;
		$this->link = $link;
		$this->entityId = $entityId;
		$this->restart = $restart;
		$this->seqNo = $seqNo;
		$this->timeStamp = $timeStamp; 			//time();
	}
	
	public function persist()
	{
		$result = mysql_query("select * from Link where id = '".$this->id."' ");
		if (mysql_num_rows($result)==0)
		{
			mysql_query("insert into Link values('".$this->id."', '".$this->link."', '".$this->entityId."', '".$this->restart."', '".$this->seqNo."', '".$this->timeStamp."') ");
		}
		else
		{
			mysql_query("update Link set link = '".$this->link."', entityId = '".$this->entityId."', restart = '".$this->restart."', seqNo = '".$this->seqNo."', timeStamp = '".$this->timeStamp."' where id = '".$this->id."' ");
		}
	}
}*/

function initializeStatics()
{
	$query = "select * from Statics where id = 0 ";
	$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		
	if (mysql_num_rows($result)==0)
	{
		$query = "insert into Statics (id, nxtEntity, nxtComment) values(0,1,1)";
		mysql_query($query) or die ("Error in query: $query. ".mysql_error());
	}
}

function getStatics()
{
	$query = "select * from Statics";
	$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
	$row = mysql_fetch_assoc($result);
	
	Entity::$nxtEntity = $row['nxtEntity'];
	//Link::$nxtLink = $row['nxtLink'];
	Comment::$nxtComment = $row['nxtComment'];
}

function setStatics()
{
	$query = "update Statics set nxtEntity = '".Entity::$nxtEntity."',
								 nxtComment = '".Comment::$nxtComment."'
								 where id = 0
			 ";
	mysql_query($query) or die ("Error in query: $query. ".mysql_error());
}

function getFmtdDate($ts, $fmt)
{
	$date = new DateTime();
	$date->setTimezone( new DateTimeZone('Asia/Kolkata') );
	$date->setTimestamp( $ts );
	$dateStr = $date->format($fmt);
	return $dateStr;
}

function makeLinks($ip)
{
	$op = preg_replace( '/(http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', '<a href="\0">\0</a>', $ip );
	return $op;
}

/*function makeStorable($ip)
{
	$op = str_replace( "\"", "\\\"", $ip);
	$op = str_replace( "'", "\'", $op);
	return $op;
}*/

?>