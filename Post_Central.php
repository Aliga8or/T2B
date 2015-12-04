<?php
require_once('Connection.php');
require_once('Entity.class.php');

$font = FONT;

getStatics();

/*Post header setup*/
$Eid = $_GET['id'];
$entity = Entity::reincarnate($Eid);
$ttab = "<div class='eList' >";
$ttab .= "<table>";
//delete
$size = UNIT;
$ttab .= "<tr><td colspan=7 align='right' ><form action='Delete.php' method='POST' onsubmit='return confirmReq()'>
			<button type='submit' name='eid' value='$Eid' style='background-color:inherit; border:0; cursor:pointer;' >
				<img src='img/delete.png' width='$size' height='$size' />
			</button>
		  </form></td></tr>
		  ";
//Type image
$ttab .= "<tr>";
$type = $entity->type;
$size = 3 * UNIT;
$ttab .= "<td rowspan=3 ><div class='edit' id='e-$Eid-type' > <img src='img/$type.png' width='$size' height='$size' /> </div></td>";
//Id
$ttab .= "<td align='center' style='font-size:$font' > $entity->id </td>";
//Title
$ttab .= "<td colspan=4 style='text-transform:uppercase; ' ><b><div class='edit' id='e-$Eid-title' > $entity->title </div></b></td>";
//Status
$status = $entity->status;
$size = UNIT;
$ttab .= "<td><div class='edit' id='e-$Eid-status' > <img src='img/$status.png' width='$size' height='$size' /> </div></td>";
$ttab .= "</tr>";
//Special,level,rating
$ttab .= "<tr>";
$ttab .= "<td>Special:</td> <td><div class='edit' id='e-$Eid-special' > $entity->special </div></td>";
$ttab .= "<td>Level:</td> <td><div class='edit' id='e-$Eid-level' > $entity->level </div></td>";
$ttab .= "<td>Rating:</td> <td align='center' style='font-size:$font' ><div class='edit' id='e-$Eid-rating' > $entity->rating </div></td>";
$ttab .= "</tr>";
//Created,updated
$ttab .= "<tr>";
$c = getFmtdDate($entity->created, 'g:ia \o\n l jS F Y');
$ttab .= "<td>Created:</td> <td> $c </td>";
$u = getFmtdDate($entity->updated, 'g:ia \o\n l jS F Y');
$ttab .= "<td>Updated:</td> <td> $u </td>";
$ttab .= "</tr>";
//Description
$ttab .= "<tr >";
$ttab .= "<td colspan=7 style='border-top:1px dotted black; border-bottom:1px dotted black; ' >
			<div class='edit' id='e-$Eid-description' > $entity->description </div>
		  </td>
		  ";
$ttab .= "</tr>";
//Tags
$ttab .= "<tr><td colspan=7><div class='edit' id='e-$Eid-tags' >";
$tags = $entity->getTags();
foreach($tags as $tag)
{
	$ttab .= "<div class='tag' ><a href='Search_Engine.php?tags=$tag' > $tag </a></div>";
}
$ttab .= "</div></td></tr>";
/*Post header setup done*/
$ttab .= "</table>";
$ttab .= "</div>";

/*Comments*/
$entity->reincarnateComments();
$com = $entity->commentsBySeq();
$ctab = "";
for( $i = 1 ; $i < $entity->nxtSeqNo ; $i++ )
{
	/*Comment table setup*/
	$Cid = $com[$i]->id;
	$class = $com[$i]->special ? "special" : "cList" ;
	$ctab .= "<div class='$class' >";
	$ctab .= "<table>";
	//delete
	$size = UNIT;
	$ctab .= "<tr><td colspan=7 align='right' ><form action='Delete.php' method='POST' onsubmit='return confirmReq()'>
				<button type='submit' name='cid' value='$Cid' style='background-color:inherit; border:0; cursor:pointer;' >
					<img src='img/delete.png' width='$size' height='$size' />
				</button>
			  </form></td></tr>
			  ";
	//seqNo
	$ctab .= "<tr>";
	$seqNo = $com[$i]->seqNo;
	$ctab .= "<td align='center' style='font-size:$font' ><div class='edit' id='c-$Cid-seqNo'> $seqNo </div></td>";
	//timeStamp
	$updated = getFmtdDate($com[$i]->timeStamp, 'g:ia \o\n l jS F Y');
	$ctab .= "<td align='right' > Updated: </td><td> $updated </td>";
	//special
	$special = $com[$i]->special;
	$ctab .= "<td align='right' > Special: </td><td><div class='edit' id='c-$Cid-special'> $special </div></td>";
	//rating
	$rating = $com[$i]->rating;
	$ctab .= "<td align='right' > Rating: </td><td align='center' style='font-size:$font' ><div class='edit' id='c-$Cid-rating'> $rating </div></td>";
	$ctab .= "</tr>";
	//image
	$img = $com[$i]->image;
	if($img != "")
	{
		$ctab .= "<tr>";
		$ctab .= "<td colspan=7  align='center' >";
		$size = 30 * UNIT;
		$ctab .= "<div style='float:left; margin-left:100px; ' >";
		$ctab .= "<img src='$img' width='$size' height='$size' />";
		$ctab .= "</div>";
		$size = UNIT;
		$ctab .= "<div style='float:left; ' >";
		$ctab .= "<form action='Delete.php' method='POST' onsubmit='return confirmReq()'>
					<button type='submit' name='img' value='$Cid' style='background-color:inherit; border:0; cursor:pointer;' >
						<img src='img/delete.png' width='$size' height='$size' />
					</button>
				  </form>
				  ";
		$ctab .= "</div>";
		$size = UNIT;
		$ctab .= "<form action='Add_Comment.php' method='POST' onsubmit='return confirmReq()' enctype='multipart/form-data' >
					<input type='file' name='file' >
					<button type='submit' name='submit' value='$Cid' style='background-color:inherit; border:0; cursor:pointer;' >
						<img src='img/replace.png' width='$size' height='$size' />
					</button>
				  </form>
				  ";
		$ctab .= "</td>";
		$ctab .= "</tr>";
	}
	else
	{
		$ctab .= "<tr>";
		$ctab .= "<td colspan=7  align='center' >";
		$size = UNIT;
		$ctab .= "<form action='Add_Comment.php' method='POST' onsubmit='return confirmReq()' enctype='multipart/form-data' >
					<input type='file' name='file' >
					<button type='submit' name='submit' value='$Cid' style='background-color:inherit; border:0; cursor:pointer;' >
						<img src='img/add-img.png' width='$size' height='$size' />
					</button>
				  </form>
				  ";
		$ctab .= "</td>";
		$ctab .= "</tr>";
	}
	//comment
	$ctab .= "<tr>";
	$comment = makeLinks($com[$i]->comment);
	$ctab .= "<td colspan=7 style='border-top:1px dotted black;' ><div class='edit' id='c-$Cid-comment'> $comment </div></td>";
	$ctab .= "</tr>";
	/*Comment table setup Done*/
	$ctab .= "</table>";
	$ctab .= "</div>";
}

/*New Comment*/
$ntab = "<div class='cList' ><form action='Add_Comment.php' method='POST' enctype='multipart/form-data' onsubmit='return confirmReq()' >";
$ntab .= "<table>";
//image
$ntab .= "<tr><td> Image: </td><td> <input type='file' name='file' > </td></tr>";
//comment
$ntab .= "<tr><td valign='top' > Comment: </td><td> <textarea name='comment' cols='70' rows='4' ></textarea> </td></tr>";
//rating
$ntab .= "<tr><td> Rating: </td><td> <select name='rating'>
										<option value='1' >1</option>
										<option value='2' >2</option>
										<option value='3' >3</option>
										<option value='4' >4</option>
										<option value='5' >5</option>
									</select>
						  </td></tr>";
//special							
$ntab .= "<tr><td> Special: </td><td> <select name='special'>
									 	 <option value='0' >No</option>
										 <option value='1' >Special</option>
									 </select>
						   </td></tr>";
//submit
$size = 2*UNIT;						   
$ntab .= "<tr><td colspan=2 align='center' >
			<button type='submit' name='submit' value='0' style='background-color:inherit; border:0; cursor:pointer;' >
				<img src='img/add.png' width='$size' height='$size' />
			</button>
		  </td></tr>
		  ";
$ntab .= "</table>";
$ntab .= "<input type='hidden' name='eid' value='$entity->id' >";
$ntab .= "</form></div>"

?>

<!--Page starts here-->

<?php
require_once("Header.php");

echo $ttab;
echo $ctab;
echo $ntab;
?>

			</div>
		</div>
	</body>
</html>