<?php
require_once('Connection.php');
require_once('Entity.class.php');

getStatics();

$display = "";
$patternVal = "";
$tagVal = "";
if( isset( $_GET['pattern'] ) || isset( $_GET['tags'] ) )
{
	$query = "select * from Entity where 1=1";
	if( isset( $_GET['pattern'] ) )
	{
		$query .= " and";
		$query .= " title like '%".$_GET['pattern']."%'";
		$patternVal = $_GET['pattern'];
	}
	if( isset( $_GET['tags'] ) )
	{
		$tags = explode(',', $_GET['tags']);
		foreach($tags as $tag)
		{
			$query .= " and";
			$query .= " tags like '%".$tag."%'";
		}
		$tagVal = $_GET['tags'];
	}
	
	$display .= "<br>".$query;
	$display .= Entity::generateEntityList($query); 
	
}

$stab = "";
$stab = "<div class='eList' ><form action='Search_Engine.php' method='GET' >";
$stab .= "<table>";
$stab .= "<tr><td> Search for: </td><td> <input type='text' name='pattern' value='$patternVal' > </td></tr>";
$stab .= "<tr><td> Tags: </td><td> <input type='text' name='tags' value='$tagVal' > </td></tr>";
//submit
$size = 2*UNIT;						   
$stab .= "<tr><td colspan=2 align='center' >
			<button type='submit' style='background-color:inherit; border:0; cursor:pointer;' >
				<img src='img/search.png' width='$size' height='$size' />
			</button>
		  </td></tr>
		  ";
$stab .= "</table>";
$stab .= "</form></div>"

?>

<!--Page starts here-->

<?php
require_once("Header.php");

echo $stab;
echo $display;

?>

			</div>
		</div>
	</body>
</html>