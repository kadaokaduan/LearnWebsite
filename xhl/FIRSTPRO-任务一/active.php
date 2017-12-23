<?php
$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = '123456';          // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}
//echo '连接成功<br />';
mysqli_select_db($conn, 'USER' );              //连接数据库

$verify = stripslashes(trim($_GET['verify']));
$nowtime = time();
$query = mysqli_query($conn ,"select user_id,token_exptime from sheet1 where status='0' and token='$verify'");
$row = mysqli_fetch_array($query);
if($row)
{
    if($nowtime>$row['token_exptime'])
    { 
        $msg = '您的激活有效期已过，请登录您的帐号重新发送激活邮件.';
    }
    else
    {
        mysqli_query($conn,"update sheet1 set status=1 where user_id=".$row['user_id']);
        if(mysqli_affected_rows($conn)!=1) die(0);
        $msg = '激活成功！';
    }
}
else
{
    $msg = 'error.';
}
echo $msg;

