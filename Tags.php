<?php
require_once('Connection.php');
require_once('Entity.class.php');

$tab = "<div class='eList' >";
$tab .= "<table>";

$query = "select tag,count(tag) as 'count' from `tags` group by tag order by count(tag) desc";
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());

while( $row = mysql_fetch_assoc($result) )
{
	$tag = $row['tag'];
	$count = $row['count'];
	$tab .= "<tr><td> <div class='tag' ><a href='Search_Engine.php?tags=$tag' > $tag ($count) </a></div> </td></tr>";
}
$tab .= "</table>";
$tab .= "</div>";
?>

<!--Page starts here-->

<?php
require_once("Header.php");

echo $tab;
?>

			</div>
		</div>
	</body>
</html>