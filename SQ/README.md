## 结构框架
##### 使用数据库
* 登录数据库
* 创建表
	* 用户名
	* 密码
	* 邮箱
	* 状态
```
CREATE TABLE users(
name VARCHAR(30) UNIQUE NOT NULL,//用户名
password VARCHAR(32) NOT NULL,//密码
email VARCHAR(150) UNIQUE NOT NULL PRIMARY KEY,//邮箱
status INT DEFAULT 0 NOT NULL//激活标志
);
```

#### html
* index.html (首页)
	* 登录/注册

#### php
* include.php (共用函数)
	* 连接数据库
* signin.php (登录)
	* 连接数据库
	* 邮箱
	* 密码
	* 验证存在与匹配
* signup.php (注册)
	* 连接数据库
	* 用户名
	* 邮箱(合法性)
	* 密码(格式,长度)
	* 确认密码
	* 等待激活
* check.php (激活账号)
	* 发送激活邮件
	* 确认激活
	* 更改状态

## 小总结
* 用xmapp集成包搭建环境
* 大体上完成表的构建
* 实现登录验证，未实现登录与否状态的改变
* 下一步先写注册然后再构建邮箱验证