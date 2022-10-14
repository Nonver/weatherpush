# 微信情侣早安/天气推送    <br> <br>
### 语言使用的是PHP
    只需要修改配置文件config.php里的APPID和app_secret即可，模板id可以复制下面的推送模板内容到测试公众号里添加然后取id粘贴
    
    类型大同小异，只需要配置好config.php文件然后访问index.php即可推送了
    
    此开源代码适合情侣之间使用
    本来不想写的，但是网上好多都是少了点东西，此版本是修复之后可以正常使用的版本

    后面会更新多人推送版本，适合朋友，或者日常提醒等功能
        
    有什么问题可以联系：Noenvy
***
    多人推送版本：
        
    功能：星座运势  多人推送  用户推送天数  用户地区7天天气状况

    有能力的可以继续开发，用户定制推送模板，我注释有怎么实现的
    
    基本上是可以实现很多功能的 看自己如何的去继续开发 我是没什么动力的 做一点是一点而已
***
多人推送模板<br>
```php
{{date.DATA}} 
地区：{{region.DATA}} 
今天：{{today.DATA}}
风向：{{wind_dir.DATA}}
实时天气：{{real.DATA}}
昼夜温差：{{temp.DATA}} 
明天天气：{{speed.DATA}}

星座：{{constella.DATA}}
今天爱情指数：{{love.DATA}}
今天幸运颜色：{{LuckyColor.DATA}}
今天幸运数字：{{Numbers.DATA}}
今天贵人星座：{{constellation.DATA}}
今天是小助手给你提醒的第{{loveDay.DATA}}天哦 

{{chp.DATA}} 
```
`推送模板` <br>
```php
{{date.DATA}} 
地区：{{region.DATA}} 
天气：{{weather.DATA}} 
气温：{{temp.DATA}}  
风向：{{wind_dir.DATA}} 
今天是我们恋爱的第{{love_day.DATA}}天  
{{birthday1.DATA}} 
{{birthday2.DATA}} 
{{love.DATA}} {{sjsj.DATA}} {{chp.DATA}}
```

