<?php
	require("adm/connect_db.php");
	require("adm/global.php");
	require("adm/access_token.php");
	$Access = new AccessToken();

	// 只获取openid
	if(empty($_GET['code'])){
		// base方法
		header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxc57c569a42953397&redirect_uri=http://wx.cunite.cn/dongrun/100/index.php&response_type=code&scope=snsapi_base&state='.$state.'#wechat_redirect');
		exit(0);
	}else{
		$code = $_GET['code'];
		$state = $_GET['state'];
		
		$content = $Access->get_openid($code);

		$access_token = $content['access_token'];
		$id = $content['openid'];
	}

	if($Access->check($access_token,$id)){
		$content = $Access->info($access_token,$id);

		if(empty($content['openid'])){
			$Access->get('http://wx.cunite.cn/dongrun/100/info.php',$state);
		}

		header("Location:show.php?openid=".$id."");
		exit(0);
	}

	$Access->get('http://wx.cunite.cn/dongrun/100/info.php',$state);
	123

	some change  de
?>