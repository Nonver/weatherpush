/*
*多少个人就执行多少次
*可以配置个人对应推送模板
*把template_id字段移动到returnJson数组里的个人信息里就好了
*在推送的时候选择模板id就选择returnJson数组个人信息里的template_id
*/ 
var returnJson = [
	[
		birthday1 = {
			'name': '阿羡',
			'birthday': '2023-02-02',
			'region': '杭州',
		},
		love_date = '2022-10-10',
		note_ch = '', // 金句中文，如果设置了，则会显示这里的，如果为空，默认会读取金山的每日金句
		note_en = '', //金句英文
		userId = '', //微信id
		template_id = '-A', //模板消息id
	],
	[
		
		birthday1 = {
			'name': '小明',
			'birthday': '2023-10-10',
			'region': '东莞',
		},
		love_date = '2022-10-12',
		note_ch = '', // 金句中文，如果设置了，则会显示这里的，如果为空，默认会读取金山的每日金句
		note_en = '', //金句英文
		userId = '',微信id
		template_id = '-A', //模板消息id
	],
];


var WXconfig = [
	app_id = '', //公众号appId
	app_secret = '', //公众号appSecret
	template_id = '', //模板消息id
];

$('#get_login').on('click', function WeChat() {
	returnJson.map((res,index)=>{
		$.post("../test/php/index.php", {
			WXconfig:JSON.stringify(WXconfig),
			json:JSON.stringify(returnJson[index]),
			sum:index,
		},
			function(data) {
				// console.log(data)
				if (data.code == 0) {
					let sum = index+1;
					layer.msg(data.msg + sum +"条");
					return;
				}
				layer.msg('登录失败，请检查数据');
			});
	})
})
