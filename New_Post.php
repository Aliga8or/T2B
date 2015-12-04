<?php
require_once('Connection.php');
require_once('Entity.class.php');

if( isset($_POST['submit']) ) {
	initializeStatics();
	getStatics();
	$entity = Entity::addEntity($_POST['title'],
								$_POST['description'],
								$_POST['type'],
								$_POST['tags'],
								$_POST['status'],
								$_POST['level'],
								$_POST['rating'],
								$_POST['special']
								);
	$entity->tagify();
	setStatics();
	
	$host = $_SERVER['HTTP_HOST'];
	$page = "T2B/Post_Central.php";
	$query = "id=".$entity->id;
	header("Location: http://$host/$page?$query");
}
?>

<!--Page starts here-->

<?php
require_once("Header.php");
?>
				<div class='eList' >
					<form name="mainForm" method="POST" action="New_Post.php">
						<table>
							<tr>
								<td>Title</td> <td><input name="title" type="text" style=" width:582px; "/></td>
							</tr>
							<tr>
								<td>Description</td> <td><textarea name="description" cols="70" rows="4" ></textarea></td>
							</tr>
							<tr>
								<td>Type</td>
								<td>
									<select name="type">
										<option value="gen" >General</option>
										<option value="tech" >Technical</option>
										<option value="islam" >Islamic</option>
										<option value="footy" >Footy</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Tags</td> <td><input name="tags" type="text" style=" width:582px; "/></td>
							</tr>
							<tr>
								<td>Status</td>
								<td>
									<select name="status">
										<option value="pend" >Pending</option>
										<option value="open" >Open</option>
										<option value="closed" >Closed</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Level</td>
								<td>
									<select name="level">
										<option value="1" >1</option>
										<option value="2" >2</option>
										<option value="3" >3</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Rating</td>
								<td>
									<select name="rating">
										<option value="1" >1</option>
										<option value="2" >2</option>
										<option value="3" >3</option>
										<option value="4" >4</option>
										<option value="5" >5</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Special</td>
								<td>
									<select name="special">
										<option value="0" >No</option>
										<option value="1" >Special</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align='center' colspan='2' >
									<button type='submit' name='submit' value='submit' style='background-color:inherit; border:0; cursor:pointer;' >
										<img src='img/add-post.png' width='40' height='40' />
									</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>