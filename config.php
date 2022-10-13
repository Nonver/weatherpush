<?php
/**
 * 微信公众号 PHP 版推送信息
 * @page      配置页
 */

/** 开启 Session 配置 */
session_start();
require 'function.php';

/** 微信公众号信息配置 */
$WXconfig=array(
	'app_id' => '', //公众号appId
	'app_secret' => '', //公众号appSecret
	'template_id' => '', //模板消息id
	'user' => array('') //接收公众号消息的微信号，如果有多个，需要在()里用英文逗号间隔，例如('小明','小丁')
);
/** 微信程序信息配置 */
$INFOconfig=array(
	'region' => '武汉', //所在地区，可为城市，区，县，同时支持国外城市，例如伦敦
	'birthday1' => array('name'=>'菁菁','birthday'=>'2000-01-01','region'=>'台湾'), //修改名字为对应需要显示的名字，生日为公历哦~ 格式：2022-8-3
	'birthday2' => array('name'=>'阿羡','birthday'=>'2000-01-01','region'=>'香港'), //同上
	'love_date'=>'2022-10-12', //同上
	"note_ch"=>'', // 金句中文，如果设置了，则会显示这里的，如果为空，默认会读取金山的每日金句
	"note_en"=>'' //金句英文
);

