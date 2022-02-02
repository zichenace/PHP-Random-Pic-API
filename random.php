<?php

/*
By:梓宸
WEB:https://zichen.zone/
*/

$APIname='ZiC API';
$image_file = 'img.txt';

//文件不见了
if(!file_exists($image_file)) {
	die($image_file.'数据文件不存在');
}

$data = file_get_contents($image_file);
$data = explode(PHP_EOL, $data);
$randKey = rand(0, count($data));
$imgurl = $data[$randKey];
$imgurl = str_replace(array("/r","/n","/r/n",), '', $imgurl);

//输出
$returnType = $_GET['get'];
switch ($returnType) {
	case 'json':
		$json['API_name'] = $APIname;
		$json['id'] = $randKey;
		$json['imgurl'] = $imgurl;
		//检测图片状态码
		#$code = curl_init ($imgurl);
		#curl_setopt ($code,CURLOPT_RETURNTRANSFER,1);
		#curl_exec ($code);
		#$httpcode = curl_getinfo ( $code, CURLINFO_HTTP_CODE );
		#curl_close ($code);
		$imageInfo = getimagesize($imgurl);
		$json['width'] = "$imageInfo[0]";
		$json['height'] = "$imageInfo[1]";
		header('Content-type:text/json');
		echo json_encode($json,JSON_PRETTY_PRINT);
		break;
		
	default:
		header("Location:" . $imgurl);
	break;
}


?>