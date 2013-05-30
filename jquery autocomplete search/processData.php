<?php
	ini_set('display_errors', 'Off');
	define('DB_HOST', 'localhost');
    define('DB_USER', 'tarun');
    define('DB_PASSWORD', 'tarun');
    define('DB_DATABASE', 'testajax');
	
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	
	if(isset($_GET['type']))
	{
		$arr = array();
		$type = $_GET['type'];
		$keyword = $_GET['keyword'];
		$qry = "SELECT keyword FROM keywords WHERE type='".$type."' AND keyword LIKE '%".$keyword."%'";
		//echo $qry;
		//$qry = "SELECT login FROM users where type='".$type."'";
		$result=mysql_query($qry);
		$new_array = array();
		while ($row = mysql_fetch_assoc($result)) {
			 $new_array[] = $row;
		}
		foreach($new_array as $row)
		{
			array_push($arr, $row['keyword']);
		} 
		if(sizeof($arr) == 0 )
		{
			$arr = array('0' => 'NoMatch');
		}
		echo json_encode($arr);
		//var_dump($arr);
	}
	
	//to insert new keywords into database
	if(isset($_GET['reqType']) && $_GET['reqType'] == 'newKeyword')
	{
		$reqType = $_GET['reqType'];
		$userId = $_GET['userId'];
		$keyword = $_GET['keyword'];
		$keywordType = $_GET['keywordType'];
		
		$query = "INSERT INTO  keywords (user_id, keyword, type ,approved) VALUES ('".$userId."', '".$keyword."', '".$keywordType."' , 'N')";
		mysql_query($query);
		$lastInsertedId = mysql_insert_id();
		$query = "INSERT INTO  user_keywords (user_id, key_id, type) VALUES ('".$userId."', '".$lastInsertedId."', '".$keywordType."')";
		//echo $query;
		mysql_query($query);
	}
	elseif(isset($_GET['reqType']) && $_GET['reqType'] == 'storeKeyword')
	{
		$reqType = $_GET['reqType'];
		$userId = $_GET['userId'];
		$keyword = $_GET['keyword'];
		$keywordType = $_GET['keywordType'];
		
		$query = "SELECT key_id FROM keywords WHERE type='".$keywordType."' AND keyword='".$keyword."'";
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			 $new_array[] = $row;
		}
		foreach($new_array as $row)
		{
			$keyId = $row['key_id'];
		} 
		//echo "here".$keyId;
		$query = "INSERT INTO  user_keywords (user_id, key_id, type) VALUES ('".$userId."', '".$keyId."', '".$keywordType."')";
		//echo $query;
		mysql_query($query);
	}
	//mysql_close($link);
?>