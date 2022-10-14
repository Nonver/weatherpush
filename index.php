<?php
/**
 * 微信公众号 PHP 版推送信息
 * @page      Main页
 */
require './config.php';
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$WXconfig['app_id']."&secret=".$WXconfig['app_secret'];
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

$lunar=new Lunar();
$today=$lunar->convertSolarToLunar(date('Y'),date('m'),date('d'));
$month=$lunar->getJieQi(date('Y'),date('m'),date('d'));//获取当前节气

$url = "http://autodev.openspeech.cn/csp/api/v2.1/weather?openId=aiuicus&clientType=android&sign=android&city=".$INFOconfig['region']."&needMoreData=false&pageNo=1&pageSize=1";
$weather = json_decode(file_get_contents($url,true),true);

if($weather["code"]!="0"){
	$return = array(
		"code"=> $weather['code'],
		"msg"=> "[".$weather["msg"]."]推送消息失败，请检查地区名是否有误！",
	);
	exit(Json($return));
}

$love = file_get_contents("https://api.vvhan.com/api/love");
$sjsj = file_get_contents("https://api.vvhan.com/api/love");
$chp = file_get_contents("https://apibug.cn/api/chp/&apiKey=4149df55b24e216ef55035c73162a78e");
$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
$posts = array(
	"template_id"=>$WXconfig['template_id'],
	"url"=>"http://www.cnhack6.com",
	"topcolor"=>"#FF0000",
	"data"=>array(
		"date"=>array(
			"value"=> "今天是".date("Y年m月d日")." 农历".$today[1].$today[2]." ".$month["name2"]."哦~",
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
		"chp"=>array(
			"value"=>$chp,
			"color"=>random_color()
		),
		"note_en"=>array(
			"value"=>$sjsj,
			"color"=>random_color()
		),
		"note_ch"=>array(
			"value"=>$love,
			"color"=>random_color()
		),
	),
);

for ($catOid = 0; $catOid < count($WXconfig['user']); $catOid++) {
	$posts["touser"] = $WXconfig['user'][$catOid];
	$post = json_encode($posts, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	// echo $post;
	// return;
	$returnJson = json_decode(request($url,true,'post',$post),true); //post请求
	    if($returnJson['errcode']=='0'){
			$return = array(
				"code"=> 0,
				"msg"=> "消息推送成功 共".count($WXconfig['user'])."条",
			);
		}else{
			$return = array(
				"code"=> $returnJson['errcode'],
				"msg"=> "第".$catOid."条消息推送失败",
			);
			exit(Json($return));
		}
	
	// $return = array(
	// 	"code"=> 200,
	// 	"msg"=> '前端执行post请求',
	// 	"data" => $post,
	// 	"url" => $url
	// );
 
}
// 封装request curl方法发送post请求
function request($url,$https,$method,$data){
	  $ch = curl_init($url);//1.初始化url
	  //2.设置请求参数
	  //把数据以文件流形式保存，而不是直接输出
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  //支持http和https协议
	  //https协议  ssl证书
	  //绕过证书验证
	  if($https === true){
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	  }
	  
	  if($method === 'post'){
	    curl_setopt($ch, CURLOPT_POST, true);
	    //发送的post数据
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	  }
	  //3.发送请求
	  $content = curl_exec($ch);
	  //4.关闭请求
	  curl_close($ch);
	  return $content;
	}
exit(Json($return));
