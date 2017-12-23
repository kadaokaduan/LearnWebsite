<?php
//处理登陆
$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = '123456';          // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(!$conn) 
{
die('连接失败: '.mysqli_error($conn));
}
//echo '连接成功<br />';
mysqli_select_db($conn, 'USER' );             //选择相应数据库
$username = $_POST['name'];
$password = md5($_POST['password']);
$query = mysqli_query($conn ,"select user_id,status from sheet1 where user_name ='$username' and password='$password'");
$row = mysqli_fetch_array($query);
if(!empty($row)) 
{
    if($row['status']==1)echo "登陆成功";
    else echo "您的账号还未进行激活,请激活后再进行登录";
}
else  echo "登陆失败 请检查输入是否正确";

 
    

