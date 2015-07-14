<?php
	// 判断是否微信客户端
	function is_weixin(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){
			return true;
		}
		return false;
	}

	function deal_row($row){
		if(isset($row['grade'])){
			switch($row['grade']){
			case 1:
				$row['grade'] = '金牌置业顾问';
				break;
			case 2:
				$row['grade'] = '高级置业顾问';
				break;
			case 3:
				$row['grade'] = '中级置业顾问';
				break;
			default:
				$row['grade'] = '未知';
				break;
			}
		}
		if(isset($row['constellation'])){
			switch($row['constellation']){
			case 1:
				$row['constellation'] = '白羊座';
				break;
			case 2:
				$row['constellation'] = '金牛座';
				break;
			case 3:
				$row['constellation'] = '双子座';
				break;
			case 4:
				$row['constellation'] = '巨蟹座';
				break;
			case 5:
				$row['constellation'] = '狮子座';
				break;
			case 6:
				$row['constellation'] = '处女座';
				break;
			case 7:
				$row['constellation'] = '天秤座';
				break;
			case 8:
				$row['constellation'] = '天蝎座';
				break;
			case 9:
				$row['constellation'] = '射手座';
				break;
			case 10:
				$row['constellation'] = '摩羯座';
				break;
			case 11:
				$row['constellation'] = '水瓶座';
				break;
			case 12:
				$row['constellation'] = '双鱼座';
				break;
			default:
				$row['constellation'] = '未知';
				break;
			}
		}
		if(isset($row['bloodtype'])){
			switch($row['bloodtype']){
			case 1:
				$row['bloodtype'] = 'A';
				break;
			case 2:
				$row['bloodtype'] = 'B';
				break;
			case 3:
				$row['bloodtype'] = 'O';
				break;
			case 4:
				$row['bloodtype'] = 'AB';
				break;
			default:
				$row['bloodtype'] = '未知';
				break;
			}
		}
		if(isset($row['sex'])){
			switch($row['sex']){
			case 1:
				$row['sex'] = '男';
				break;
			case 2:
				$row['sex'] = '女';
				break;
			default:
				$row['sex'] = '未知';
				break;
			}
		}
		if(isset($row['inputtime'])){
			$time = time();
			$ago = $time - $row['inputtime'];
			if($ago < 60){
				$row['ago'] = $ago.'秒前';
			}else if($ago >= 60 && $ago < 60 * 60){
				$row['ago'] = floor($ago / 60).'分前';
			}else if($ago >= 60 * 60 && $ago < 60 * 60 * 24){
				$row['ago'] = floor($ago / (60 * 60)).'小时前';
			}else if($ago >= 60 * 60 * 24 && $ago < 60 * 60 * 24 * 7){
				$row['ago'] = floor($ago / (60 * 60 * 24)).'天前';
			}else if($ago >= 60 * 60 * 24 * 7 && $ago < 60 * 60 * 24 * 30){
				$row['ago'] = floor($ago / (60 * 60 * 24 * 7)).'周前';
			}else if($ago >= 60 * 60 * 24 * 30 && $ago < 60 * 60 * 24 * 365){
				$row['ago'] = floor($ago / (60 * 60 * 24 * 30)).'月前';
			}else{
				$row['ago'] = floor($ago / (60 * 60 * 24 * 365)).'年前';
			}
			$row['inputtime'] = date('Y-m-d', $row['inputtime']);
		}
		return $row;
	}