<?php
	require("adm/connect_db.php");
	require("adm/global.php");
	
	$content = "姓名,电话,学校,奖品,职业顾问,入库时间\r\n";
	$sql = "SELECT a.*,b.name as ad_name,c.title FROM `user` as a LEFT JOIN `admin` as b ON a.aid = b.id LEFT JOIN `prize_type` as c ON a.prize = c.id WHERE 1";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		if(empty($row['aid'])){
			$row['ad_name'] = '未选择';
		}
		if(empty($row['prize'])){
			$row['title'] = '未抽奖';
		}
		$content .= $row['name'].','.$row['phone'].','.$row['school'].','.$row['title'].','.$row['ad_name'].','.date('Y-m-d',$row['inputtime'])."\r\n";
	}
	$content = iconv("UTF-8","GB2312",$content);
	file_put_contents('user.csv',$content);
	
	header("Content-type: text/html; charset=utf-8");
	echo '<a href="user.csv">下载</a>';

	require("adm/close_db.php");
?>