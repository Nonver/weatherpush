<?php
/**
 * 微信公众号 PHP 版推送信息
 * @page      配置页
 */

/** 开启 Session 配置 */
session_start();
require 'function.php';
/** 天行数据key **/
$DayLineKey = array(
	'key' => '',
	'type' => 7 // 1当天 7 未来7天
);
