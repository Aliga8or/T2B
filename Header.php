<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/Main.css" />
	<link href="css/Tabcontent.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery.js" ></script>
	<script type="text/javascript" src="js/tabcontent.js" ></script>
	<script type="text/javascript" >
	function confirmReq()
	{
		var ret = confirm("You Shirley Wanna Go Ahead?");
		return ret;
	}
	</script>
	<script type="text/javascript" src="js/jquery.jeditable.js" ></script>
	<script type="text/javascript" >
	$(document).ready(function() {
     $('.edit').editable('Edit.php',
		{
		 cancel    : 'Cancel',
         submit    : 'OK',
		 onblur	   : 'ignore',
		 event	   : 'dblclick',
		 loadurl   : 'Input.php'
		}
	  );
	});
	</script>
</head>
	<body>
		<div id="container" >
		<div id="header" ></div>
		<div id="navBar" >
			<div class='navtabs' ><a href='Home.php' > Home </a></div>
			<div class='navtabs' ><a href='New_Post.php' > New </a></div>
			<div class='navtabs' ><a href='Search_Engine.php' > Search </a></div>
			<div class='navtabs' ><a href='Tags.php' > Tags </a></div>
		</div>
		<div id="main" >