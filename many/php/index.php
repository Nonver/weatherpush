<?php
/**
 * 微信公众号 PHP 版推送信息
 * @page      Main页
 */
require './config.php';

$INFOconfig = json_decode(trim($_REQUEST["json"]),true); //前端过来的需要发送到达的人的信息
$WXconfig = json_decode(trim($_REQUEST["WXconfig"]),true); //前端过来的需要发送到达的人的信息
/* 星座运势 */
$constellation = "http://api.tianapi.com/star/index?key=".$DayLineKey["key"]."&astro=".constellation($INFOconfig[0]['birthday']);
$constJson = json_decode(file_get_contents($constellation),true);

/* 天气数据 */
$dayLien = "http://api.tianapi.com/tianqi/index?key=".$DayLineKey["key"]."&city=".$INFOconfig[0]['region']."&type=".$DayLineKey["type"]."";
$dayJson = json_decode(file_get_contents($dayLien),true);

/*---------------------获取token开始---------------------*/
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$WXconfig[0]."&secret=".$WXconfig[1];
$returnJson = file_get_contents($url); //get请求获取
$arr = json_decode($returnJson,true); //转数组
$token = $arr["access_token"]; //取token
if(!$token){
	$return = array(
		"code"=> $returnJson['errcode'],
		"msg"=> "获取access_token失败，请检查app_id和app_secret是否正确",
	);
	exit(Json($return));
}
/*---------------------获取token结束---------------------*/

$lunar=new Lunar();
$today=$lunar->convertSolarToLunar(date('Y'),date('m'),date('d'));
$month=$lunar->getJieQi(date('Y'),date('m'),date('d'));//获取当前节气	
$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;

for ($catOid = 0; $catOid < 1 ; $catOid++) {
	$posts = array(
		"template_id"=>$WXconfig[2],
		"url"=>"www.baidu.com",
		"topcolor"=>"#FF0000",
		"data"=>array(
			"date"=>array(
				"value"=> "今天是".date("Y年m月d日")." 农历".$today[1].$today[2]." ".$month["name2"]."哦~",
				"color"=>random_color()
			),
			"region"=>array(
				"value"=>$INFOconfig[0]['region'],
				"color"=>random_color()
			),
			"today"=>array( //星期几
				"value"=>$dayJson["newslist"][0]["week"]."-".$dayJson["newslist"][0]["weather"],
				"color"=>random_color()
			),
			"real"=>array(
				"value"=>$dayJson["newslist"][0]["real"]."°",
				"color"=>random_color()
			),
			"tomorrow"=>array(
				"value"=>$dayJson["newslist"][1]["real"],
				"color"=>random_color()
			),
			"temp"=>array(
				"value"=>$dayJson["newslist"][0]["lowest"]."~".$dayJson["newslist"][0]["highest"]."",
				"color"=>random_color()
			),
			"wind_dir"=>array(
				"value"=>$dayJson["newslist"][0]["wind"],
				"color"=>random_color()
			),
			"speed"=>array(
				"value"=>$dayJson["newslist"][1]["windspeed"]."°",
				"color"=>random_color()
			),
			"speed1"=>array(
				"value"=>$dayJson["newslist"][2]["windspeed"]."°",
				"color"=>random_color()
			),
			"birthday1"=>array(
				"value"=>XDINGsr($INFOconfig[0]['birthday'],$INFOconfig[0]['name']),
				"color"=>random_color()
			),
			"loveDay"=>array(
				"value"=>PassTime($INFOconfig['1']),
				"color"=>random_color()
			),
			"LuckyColor"=>array(
				"value"=>$constJson["newslist"][5]["content"],
				"color"=>random_color()
			),
			"Numbers"=>array(
				"value"=>$constJson["newslist"][6]["content"],
				"color"=>random_color()
			),
			"constellation"=>array(
				"value"=>$constJson["newslist"][7]["content"],
				"color"=>random_color()
			),
			"love"=>array(
				"value"=>$constJson["newslist"][1]["content"],
				"color"=>random_color()
			),
			"constella"=>array(
				"value"=>constellation($INFOconfig[0]['birthday']),
				"color"=>random_color()
			),
			
			"chp"=>array(
				"value"=>$constJson["newslist"][8]["content"],
				"color"=>random_color()
			),
				
		),
	);
	$posts["touser"] = $INFOconfig[4];
	$post = json_encode($posts, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	$returnJson = json_decode(request($url,true,'post',$post),true); //post请求
	    if($returnJson['errcode']=='0'){
			$return = array(
				"code"=> 0,
				"msg"=> "消息推送成功",
			);
		}else{
			$return = array(
				"code"=> $returnJson['errcode'],
				"msg"=> "第".$catOid."条消息推送失败",
			);
			exit(Json($return));
		}
}
// 封装request curl方法发送post请求
function request($url,$https,$method,$data){
	  $ch = curl_init($url);//1.初始化url
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  if($https === true){
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	  }
	  
	  if($method === 'post'){
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	  }
	  $content = curl_exec($ch);
	  curl_close($ch);
	  return $content;
	}
exit(Json($return));