<?php
/**
 * XDING WeChat Public Platform
 * 微信公众号 PHP 版推送信息
 *作者QQ:1825703954
 * @copyright  Copyright (c) 2022 XDING  (https://wxnljun.asia)
 * @page      Main页
 */
require './config.php';
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$WXconfig['app_id']."&secret=".$WXconfig['app_secret'];
$returnJson = json_decode(Request_curl($url,''),true);
$token = $returnJson["access_token"];
if(!$token){
	$return = array(
		"code"=> $returnJson['errcode'],
		"msg"=> "获取access_token失败，请检查app_id和app_secret是否正确",
	);
	exit(Json($return));
}

$lunar=new Lunar();
$today=$lunar->convertSolarToLunar(date(Y),date(m),date(d));
$month=$lunar->getJieQi(date(Y),date(m),date(d));//获取当前节气

$url = "http://autodev.openspeech.cn/csp/api/v2.1/weather?openId=aiuicus&clientType=android&sign=android&city=".$INFOconfig['region']."&needMoreData=false&pageNo=1&pageSize=1";
$weather = json_decode(file_get_contents($url,true),true);

if($weather["code"]!="0"){
	$return = array(
		"code"=> $weather['code'],
		"msg"=> "[".$weather["msg"]."]推送消息失败，请检查地区名是否有误！",
	);
	exit(Json($return));
}

$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
$posts = array(
	"template_id"=>$WXconfig['template_id'],
	"url"=>"http://wxnljun.asia",
	"topcolor"=>"#FF0000",
	"data"=>array(
		"date"=>array(
			"value"=> "今天是".date("Y年m月d日")." 农历".$today[1].$today[2]." ".$month[name2]."哦~",
			"color"=>random_color()
		),
		"region"=>array(
			"value"=>$INFOconfig['region'],
			"color"=>random_color()
		),
		"weather"=>array(
			"value"=>$weather["data"]["list"][0]["weather"],
			"color"=>random_color()
		),
		"temp"=>array(
			"value"=>$weather["data"]["list"][0]["temp"]."~".$weather["data"]["list"][0]["high"]."℃",
			"color"=>random_color()
		),
		"wind_dir"=>array(
			"value"=>$weather["data"]["list"][0]["wind"],
			"color"=>random_color()
		),
		"birthday1"=>array(
			"value"=>XDINGsr($INFOconfig['birthday1']['birthday'],$INFOconfig['birthday1']['name']),
			"color"=>random_color()
		),
		"birthday2"=>array(
			"value"=>XDINGsr($INFOconfig['birthday2']['birthday'],$INFOconfig['birthday2']['name']),
			"color"=>random_color()
		),
		"love_day"=>array(
			"value"=>PassTime($INFOconfig['love_date']),
			"color"=>random_color()
		),
		"note_en"=>array(
			"value"=>$INFOconfig['note_en'],
			"color"=>random_color()
		),
		"note_ch"=>array(
			"value"=>$INFOconfig['note_ch'],
			"color"=>random_color()
		),
	),
);

for ($catOid = 0; $catOid < count($WXconfig['user']); $catOid++) {
	$posts["touser"] = $WXconfig['user'][$catOid];
	$post = json_encode($posts, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $returnJson = json_decode(Request_curl($url,$post),true);
    if($returnJson['errcode']=='0'){
		$return = array(
			"code"=> 0,
			"msg"=> "取码网提示：消息推送成功 共".count($WXconfig['user'])."条",
		);
	}else{
		$return = array(
			"code"=> $returnJson['errcode'],
			"msg"=> "取码网提示：第".$catOid."条消息推送失败",
		);
		exit(Json($return));
	}
	//usleep(500000);
}

exit(Json($return));