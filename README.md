# 微信情侣早安/天气推送    <br> <br>
### 语言使用的是PHP
    只需要修改配置文件config.php里的APPID和app_secret即可，模板id可以复制下面的推送模板内容到测试公众号里添加然后取id粘贴
***
`推送模板` <br>
```html
{{date.DATA}} <br> 
地区：{{region.DATA}} <br> 
天气：{{weather.DATA}} <br> 
气温：{{temp.DATA}} <br> 
风向：{{wind_dir.DATA}} <br> 
今天是我们恋爱的第{{love_day.DATA}}天 <br> 
{{birthday1.DATA}} <br> 
{{birthday2.DATA}}<br> 
{{love.DATA}} {{sjsj.DATA}} {{chp.DATA}}
```
