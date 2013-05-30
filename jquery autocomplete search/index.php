<?php
	session_start();
	$_SESSION['user_id'] = '01';

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Autocomplete by TARUN</title>
		<link rel="stylesheet" href="css/jquery-ui.css" />
		<link rel="stylesheet" href="css/jquery.ui.all.css" />
		<style>
			 .ui-autocomplete {
				max-height: 180px;
				overflow-y: auto;
				/* prevent horizontal scrollbar */
				overflow-x: hidden;
			}
			html .ui-autocomplete {
				height: 180px;
				font-size:12px;
			}
			.chosenKeyword{float:left; margin-right:20px;}
			.hideButton{color:blue; cursor:pointer;}
			.autocompleteGrid{height:28px;}
		</style>
		<script src="js/jquery-1.9.1.js"></script>
		<script src="js/jquery-ui.custom.js"></script>
		<script src="js/myautocomplete.js"></script>
</head>
<body>
		<input type='hidden' id='noData' value='Match' >
		<input type='hidden' id='keywordType' value='skill' >
		<input type='hidden' id='userId' value='<?php echo $_SESSION['user_id']; ?>' >
		
		<div id='autocompleteGrid' class='autocompleteGrid'>
		</div>
		<input type='text' id='keyValue' onkeyup="getKeywords('skill',this);" autocomplete='off' placeholder='skill or interest'>
		
</body>
</html>
