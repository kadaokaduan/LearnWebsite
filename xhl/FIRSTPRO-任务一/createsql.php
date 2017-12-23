<?php 
//创建数据库
$dbhost = 'localhost:3306';   //mysql服务器主机地址
$dbuser = 'root';             //mysql用户名
$dbpass = '123456';            //mysql用户名密码
$link = mysqli_connect($dbhost,$dbuser,$dbpass);
if(!$link)
{
    die('连接错误'.mysqli_error($link));
}
echo "连接成功！";
$sql = 'CREATE DATABASE USER';
$retval = mysqli_query($link, $sql);
if(!$retval)
{
    die('创建数据表: '.mysqli_error($link));
}
echo "数据库 USER 创建成功\n";
mysqli_close($link);
