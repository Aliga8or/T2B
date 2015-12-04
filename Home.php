<?php
require_once('Connection.php');
require_once('Entity.class.php');

getStatics();

$view1 = "";
$view2 = "";
$view3 = "";
$view4 = "";
$view5 = "";

$query = "select * from Entity where type='gen' ";
$view1 = Entity::generateEntityList($query);

$query = "select * from Entity where type='tech' ";
$view2 = Entity::generateEntityList($query);

$query = "select * from Entity where type='islam' ";
$view3 = Entity::generateEntityList($query);

$query = "select * from Entity where type='footy' ";
$view4 = Entity::generateEntityList($query);

$query = "select * from Entity where special='1' ";
$view5 = Entity::generateEntityList($query);

?>

<!--Page starts here-->

<?php
require_once("Header.php");

?>
				<ul class="tabs" data-persist="true">
					<li><a href="#view1"> General </a></li>
					<li><a href="#view2"> Technological </a></li>
					<li><a href="#view3"> Islamic </a></li>
					<li><a href="#view4"> Footy </a></li>
					<li><a href="#view5"> Special </a></li>
				</ul>
				<div class="tabcontents">
					<div id="view1">
						<?php echo $view1 ; ?>		
					</div>
					<div id="view2">
						<?php echo $view2 ; ?>                
					</div>
					<div id="view3">
						<?php echo $view3 ; ?> 
					</div>
					<div id="view4">
						<?php echo $view4 ; ?> 
					</div>
					<div id="view5">
						<?php echo $view5 ; ?> 
					</div>
				</div>
			</div>
		</div>
	</body>
</html>