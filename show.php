<?php
	require("adm/connect_db.php");
	require("adm/global.php");
	
	$openid = '';
	if(isset($_GET['openid'])){
		$openid = addslashes($_GET['openid']);
	}
	if(empty($openid)){
		exit(0);
	}
	echo $openid;
	
	$sql = "SELECT * FROM `user` WHERE openid = '$openid'";
	$result = mysql_query($sql);
	$data = array();
	if(is_resource($result)){
		$data = mysql_fetch_array($result);
	}

	//include("model/index.html");
	require("adm/close_db.php");
?>