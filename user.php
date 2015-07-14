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
	
	// 家长姓名
	$parentname = '';
	if(isset($_POST['parentname'])){
		$parentname = addslashes($_POST['parentname']);
	}
	if(isset($_GET['parentname'] && empty($parentname))){
		$parentname = addslashes($_GET['parentname']);
	}
	
	// 家长电话
	$parentphone = '';
	if(isset($_POST['parentphone'])){
		$parentphone = addslashes($_POST['parentphone']);
	}
	if(isset($_GET['parentphone'] && empty($parentphone))){
		$parentphone = addslashes($_GET['parentphone']);
	}

	// 萌娃姓名
	$childname = '';
	if(isset($_POST['childname'])){
		$childname = addslashes($_POST['childname']);
	}
	if(isset($_GET['childname'] && empty($childname))){
		$childname = addslashes($_GET['childname']);
	}

	// 萌娃年龄
	$childage = '';
	if(isset($_POST['childage'])){
		$childage = addslashes($_POST['childage']);
	}
	if(isset($_GET['childage'] && empty($childage))){
		$childage = addslashes($_GET['childage']);
	}

	// 萌娃照片
	$childimg = '';
	if(isset($_POST['childimg'])){
		$childimg = addslashes($_POST['childimg']);
	}
	if(isset($_GET['childimg'] && empty($childimg))){
		$childimg = addslashes($_GET['childimg']);
	}

	// 萌娃宣言
	$childword = '';
	if(isset($_POST['childword'])){
		$childword = addslashes($_POST['childword']);
	}
	if(isset($_GET['childword'] && empty($childword))){
		$childword = addslashes($_GET['childword']);
	}

	$sql = "SELECT * FROM `user` WHERE openid = '$openid'";
	$result = mysql_query($sql);
	$data = array();
	if(is_resource($result)){
		$data = mysql_fetch_array($result);
	}
	if(!empty($data['id'])){
		echo 'error';
		exit();
	}
	$time = time();

	$sql = "INSERT INTO `user` (`openid`,`parentname`,`parentphone`,`childname`,`childage`,`childimg`,`childword`,`inputtime`,`updatetime`) VALUES ('$openid','$parentname','$parentphone','$childname','$childage','$childimg','$childword','$time','$time')";
	mysql_query($sql);
	
	require("adm/close_db.php");
?>