<?php
/**
 * XDING WeChat Public Platform
 * 微信公众号 PHP 版推送信息
 *作者QQ:1825703954
 * @copyright  Copyright (c) 2022 XDING  (https://wxnljun.asia)
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
	'user' => array('') //接收公众号消息的微信号，如果有多个，需要在()里用英文逗号间隔，例如('君临','小君')
);

/** 微信程序信息配置 */
$INFOconfig=array(
	'region' => '', //所在地区，可为城市，区，县，同时支持国外城市，例如伦敦
	'birthday1' => array('name'=>'名字','birthday'=>'日期'), //修改名字为对应需要显示的名字，生日为公历哦~ 格式：2022-8-3
	'birthday2' => array('name'=>'','birthday'=>''), //同上
	'love_date'=>'', //同上
	"note_ch"=>'早~宝贝，14亿人我就通知了你，所以请在新的一天里开开心心！快快乐乐！顺顺利利哦~ 爱你', // 金句中文，如果设置了，则会显示这里的。
	"note_en"=>'I never stopped loving you, I just unshowing it.' //金句英文
);

