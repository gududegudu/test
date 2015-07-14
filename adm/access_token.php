<?php
	class AccessToken{
		private $appId = '';
		private $appSecret = '';
		public function __construct(){
			$this->appId = 'wxc57c569a42953397';
			$this->appSecret = '66d4d038a6f1f9b70952b97a9657d5f5';
		}

		function get_openid($code){
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
			curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appId."&secret=".$this->appSecret."&code=".$code."&grant_type=authorization_code");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);

			$content = json_decode($file_contents, TRUE);
			return $content;
		}

		// 获取access_token
		//
		// $url 为回调地址
		// $openid 为参数
		function get($url, $state = ''){
			header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxc57c569a42953397&redirect_uri='.$url.'&response_type=code&response_type=code&scope=snsapi_userinfo&state='.$state.'#wechat_redirect');
			exit(0);
		}

		// 检查access_token是否有效
		function check($access_token, $openid = ''){
			$url = "https://api.weixin.qq.com/sns/auth?access_token=".$access_token."&openid=".$openid;
			//echo $url.'<br><br><br>';

			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch,CURLOPT_HEADER,0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);

			//echo $file_contents;die;

			if($file_contents == '{"errcode":0,"errmsg":"ok"}'){
				return true;
			}else{
				return false;
			}
		}
		
		// 利用refresh_token获取access_token
		function refresh($refresh_token){
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
			curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$this->appId."&grant_type=refresh_token&refresh_token=".$refresh_token);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
			
			$content = json_decode($file_contents, TRUE);
			return $content;
		}

		// 直接获取用户信息
		function info($access_token, $openid){
			// 获取用户信息
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
			curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
			
			$content = json_decode($file_contents, TRUE);
			$openid = $content['openid'];
			$nickname = $content['nickname'];
			$sex = $content['sex'];
			$province = $content['province'];
			$city = $content['city'];
			$country = $content['country'];
			$headimgurl = $content['headimgurl'];
			$time = time();
			if(!empty($openid)){
				$sql = "SELECT * FROM `wei_user` WHERE `openid` = '".$openid."'";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				if(empty($row)){
					$sql = "INSERT INTO `wei_user` (`openid`,`nickname`,`sex`,`city`,`country`,`province`,`headimgurl`,`inputtime`,`updatetime`) VALUES ('".$openid."','".$nickname."','".$sex."','".$city."','".$country."','".$province."','".$headimgurl."','".$time."','".$time."')";
					mysql_query($sql);
				}else{
					$sql = "UPDATE `wei_user` SET `nickname`='".$nickname."',`sex`='".$sex."',`city`='".$city."',`country`='".$country."',`province`='".$province."',`headimgurl`='".$headimgurl."',`updatetime`='".$time."' WHERE `openid`='".$openid."'";
					mysql_query($sql);
				}
			}
			return $content;
		}
	};