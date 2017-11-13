# 目录
* [Windows](#基于Windows)
	* [数据库](#使用数据库)
	* [html](#html)
	* [php](#php)
	* [总结w1](#总结w1)
	* [总结w2](#总结w2)
* [Ubuntu](#基于Ubuntu)
	* [安装Ubuntu](#安装Ubuntu16.04.3)
	* [搭建LAMP环境](#搭建LAMP环境)
	* [配置Laravel](#配置Laravel)
	* [用户认证](#用户认证)
	* [总结u1](#总结u1)


## 基于Windows
#### 使用数据库
* 登录数据库
* 创建表
	* ID
	* 用户名
	* 密码
	* 邮箱
	* 状态
	* 
```
CREATE TABLE users(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,//ID
name VARCHAR(30) UNIQUE NOT NULL,//用户名
password VARCHAR(20) NOT NULL,//密码
email VARCHAR(200) UNIQUE NOT NULL,//邮箱，主键
active INT DEFAULT 0 NOT NULL//激活标志
);
```


#### html
* index.html (首页)
	* 登录/注册


#### php
* include.php (共用函数)
	* 连接数据库
* signin.php (登录)
	* 邮箱
	* 密码
	* 连接数据库
	* 验证存在与匹配
	* 更改登录状态【SESSION未完成】
* signup.php (注册)
	* 用户名
	* 邮箱(合法性)
	* 密码(格式,长度)
	* 确认密码
	* 连接数据库
	* 存入数据
	* 等待激活
* check.php (激活账号)
	* 发送激活邮件
	* 确认激活
	* 更改状态
	* 不允许二次激活
* stmp.php (发送邮件)
	* 邮件类
	* 发送过程
	* 发送函数
	* 参考


## 总结w1
* 用xmapp集成包搭建环境
* 完成表的构建
* 实现登录验证，未实现登录与否状态的改变
* 实现注册功能
* 实现基于socket、STMP的邮件发送
* 实现激活账号后不允许再次激活


## 总结w2
* 更改表的结构
* 功能基本实现
* SESSION未掌握


<br>
<br>

## 基于Ubuntu
#### 安装Ubuntu16.04.3
* 下载镜像包
* 用虚拟机安装

##### Ubuntu技巧
> ctrl+h 显示隐藏文件


#### 搭建LAMP环境
* 管理员身份
	* `sudo su`
* 更新
	* `sudo apt-get update`
* 安装apache
	* `sudo apt-get install apache2`
	* 浏览器访问127.0.0.1验证
* 安装MYSQL
	* `sudo apt-get install mysql-server mysql-client`
	* 设置MYSQL管理员密码
* 测试MYSQL
	* `sudo netstat -tap | grep mysql`
	* 显示监听端口即安装成功
* 安装PHP
	* `sudo apt-get install php7.0 libapache2-mod-php7.0`
* 测试PHP
	* 更改权限
		* `sudo chmod 777 /var/www`
	* 编辑测试php文件
		* `sudo vi /var/www/info.php`
		* `<?php phpinfo(); ?>
		* 按i开始编辑，编辑完成后先按ESC再敲`:wq`保存退出
	* 配置根目录
		* `sudo vi /etc/apache2/sites-available/000-default.conf`
		* 将 `var/www/html`改为`var/www`
	* 浏览器访问127.0.0.1/info.php验证
* 安装phpmyadmin
	* `sudo apt-get install phpmyadmin`
	* 安装会出现三次窗口，前两个选择默认选项即可，最后一个输入MYSQL管理员密码
	* 在`/var/www`下建立phpmyadmin的软连接
		* `sudo ln -s /usr/share/phpmyadmin /var/www/phpmyadmin`
* 验证phpmyadmin
	* 浏览器访问127.0.0.1/phpmyadmin
	* 若出现mbstring错误
		* `sudo apt-get install php-mbstring`
		* 修改php配置文件
			* ```
			* sudo gedit /etc/php/7.0/apache2/php.ini
			* display_errors = On(显示错误日志，出现两次，都要改，不然无效)
			* extension=php_mbstring.dll (开启mbstring)
			* ```
		* 重启apache
			* `sudo /etc/init.d/apache2 restart`
		* 再次用浏览器访问127.0.0.1/phpmyadmin
			* 用户名root
			* 密码是安装时设置的


#### 配置Laravel
* 更新
	* `sudo apt-get update`
* 安装laravel需要的加密算法库
	* `sudo apt-get install mcrypt`
* 安装php扩展
	* `sudo apt-get install curl openssl php-curl php-zip php-dom php-pdo php-xml php-mysql php7.0-mcrypt` 
	* `/etc/php/7.0/apache2`中找到php.ini，开启扩展
* 安装composer
	* `curl -sS https://getcomposer.org/installer | php`
* 移动文件到命令目录
	* `sudo mv composer.phar /usr/local/bin/composer`
* composer命令
	* 不能在root下使用
	* `composer -v` 检测是否安装成功
	* `composer config -g repo.packagist composer https://packagist.phpcomposer.com`配置国内镜像
* 安装laravel
	* `composer global require "laravel/installer"`
	* `export PATH="~/.config/composer/vendor/bin:$PATH"`配置环境变量
* 使用laravel新建项目
	* `laravel new project` project是项目名称
* 设置目录权限
	* `sudo chmod 0777 project -R` 简单方式
* 开启重写模块
	* `sudo a2enmod rewrite` 
* 重启apache
	* `service apache2 restart`
* 生成key
	* `php artisan key:generate`
	* `'key' => env('APP_KEY', 'key')`project/config/app.php
* 测试
	* 进入project目录
	* `php artisan serve`
	* 浏览器访问localhost:8000



#### 用户认证
参考文档：

* [Laravel 5.1用户认证](http://laravelacademy.org/post/1258.html)
* [Laravel 5.4用户认证](http://laravelacademy.org/post/6803.html)


#### 总结u1
* 配置好Laravel环境
* 搭建完LAMP环境再搭建Laravel更方便
* 尚未弄懂框架