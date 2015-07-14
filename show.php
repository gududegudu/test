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
	
	

	include("model/index.html");
	require("adm/close_db.php");
?>