# PM2.5告警
当PM2.5浓度在订阅者们**指定的时间**达到**一定数值**时分别进行告警。   
    
![示例3](http://ww3.sinaimg.cn/mw690/69e23056gw1fbdafftyowj20690b43yq.jpg)  ![示例2](http://ww3.sinaimg.cn/mw690/69e23056gw1fb8ous7x1aj20690b4gmd.jpg)  ![示例1](http://ww2.sinaimg.cn/mw690/69e23056gw1fb8ourtu4cj20690b43zq.jpg) 
# 要求  
PHP>=5.4  
composer  
cron

# 安装  
执行`composer create-project -s dev peinhu/pm25alert`  

执行`crontab -e`，在末尾增加一行`* * * * * /usr/bin/php /path-to-project/index > /dev/null 2>&1`，注意`/usr/bin/php`请以实际为准，`path-to-project`替换成项目文件夹的路径  

# 配置  
config/users.php 设置订阅者  
config/notification.php 设置通知方式  
config/contact.php 设置服务提供者的联系方式（可选）  

# 说明   
按PM2.5浓度而非AQI（空气质量指数）进行计算分级，分级标准参照国内标准，结果仅反映PM2.5的污染情况。   

默认使用pm25.in提供的api，也可换用其它api，整理为core/DefaultData.php中的标准数据格式即可。   

默认使用email进行通知，也可自行扩展其它通知服务。
# 许可证
使用GPLv2许可证, 查看LICENCE文件以获得更多信息。
