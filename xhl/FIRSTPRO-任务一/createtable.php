<?php
// 创建数据表
$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = '123456';          // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}
echo '连接成功<br />';
$sql = "CREATE TABLE sheet1( ".
        "user_id       INT NOT NULL AUTO_INCREMENT, ".//用户id
        "user_name     VARCHAR(40) NOT NULL, ".//用户名
        "password      VARCHAR(40) NOT NULL, ".//用户密码
        "email         VARCHAR(60) NOT NULL, ".//邮箱
        "token         VARCHAR(40) NOT NULL, ".//激活码
        "token_exptime INT(10) NOT NULL, ".//激活码有效期
        "status        TINYINT(1) NOT NULL, ".//激活状态
        "regtime       INT(10) NOT NULL, ".//注册时间
        "PRIMARY KEY ( user_id ))ENGINE=InnoDB DEFAULT CHARSET=utf8; ";
mysqli_select_db( $conn, 'USER' );
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
    die('数据表创建失败: ' . mysqli_error($conn));
}
echo "数据表创建成功\n";
mysqli_close($conn);
?>