<?php
	require("adm/connect_db.php");
	require("adm/global.php");
	require("adm/access_token.php");
	$Access = new AccessToken;

	$code = '';
	if(isset($_GET['code'])){
		$code = $_GET['code'];
	}
	$state = '';
	if(isset($_GET['state'])){
		$state = $_GET['state'];
	}

	// 获取用户openid
	$content = $Access->get_openid($code);

	$access_token = $content['access_token'];
	$openid = $content['openid'];

	// 判断用户有没有在本地数据库
	// 获取用户信息
	$content = $Access->info($access_token,$openid);
	
	header("Location:show.php?openid=".$openid."");
?>