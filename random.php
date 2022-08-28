<?php

/*
	Copyright 2022 梓宸.
	Blog:https://zichen.zone/
	Licensed under MIT (https://github.com/zichenace/PHP-Random-Pic-API/blob/main/LICENSE)
	Ver:1.2.0.20220828
*/

#配置项目
$APIname='ZiC API';		//API名称自定义
$image_file='./img.txt';	//API数据文件

#文件不见了
if(!file_exists($image_file)) {
	die($image_file.'数据文件不存在');
}

#随机API链接处理
$data = file_get_contents($image_file);
$data = explode(PHP_EOL, $data);
$randKey = rand(0, count($data));
$imgurl = $data[$randKey];
$imgurl = str_replace(array("\r","\n","\r\n",), '', $imgurl);

//输出API内容
$returnType = $_GET['return'];
switch ($returnType) {

	default:				//默认情况下，直接返回链接
	header("Location:" . $imgurl);

	case 'json':				//当检测到参数为json
		$json['API_name'] = $APIname;
		$json['id'] = $randKey;
		$json['imgurl'] = $imgurl;

		/*
		#检测图片状态码（按需开启）
		$code = curl_init ($imgurl);
		curl_setopt ($code,CURLOPT_RETURNTRANSFER,1);
		curl_exec ($code);
		$httpcode = curl_getinfo ( $code, CURLINFO_HTTP_CODE );
		curl_close ($code);
		*/

		$imageInfo = getimagesize($imgurl);
		$json['width'] = "$imageInfo[0]";
		$json['height'] = "$imageInfo[1]";
		header('Content-type:text/json');
		echo json_encode($json,JSON_PRETTY_PRINT);
		break;

}

?>
