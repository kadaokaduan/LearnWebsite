<?php 
$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = '123456';          // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error());
}
//echo '数据库连接成功！';

mysqli_select_db( $conn, 'USER' );                        //选择数据库
$username = stripslashes(trim($_POST['username']));   
$password = md5(trim($_POST['password']));                 //加密密码 
$email = trim($_POST['email']);                            //邮箱 
$regtime = time();                                         //注册时间
$token = md5($username.$password.$regtime);                //创建用于激活识别码 
$token_exptime = time()+60*60*24;                          //设置激活码有效时间,过期时间为24小时后 
 

$sql = "INSERT INTO sheet1 ".
    "(user_name,password, email,token,token_exptime,regtime) ".
    "VALUES ".
    "('$username','$password','$email','$token','$token_exptime','$regtime')";

$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
    die('无法插入数据: ' . mysqli_error($conn));
}
//echo "数据插入成功\n";

include_once "class.phpmailer.php";//获取一个外部文件的内容
include_once "class.smtp.php";
$mail=new PHPMailer();
$mail->SMTPDebug = 2;              //设置调试信息  如果设置为1或者2 发送不成功会输出报错信息
$body = "亲爱的".$username."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/>
    <a href='http://localhost:8080/FIRSTPRO/active.php?verify=".$token."' target=            //相应激活账号的php文件url
'_blank'>http://localhost:8080/FIRSTPRO/active.php?verify=".$token."</a><br/>
    如果以上链接无法点击，我也没有办法。";
//设置smtp参数
$mail->IsSMTP();
$mail->SMTPAuth=true;
$mail->SMTPKeepAlive=true;
$mail->SMTPSecure= "ssl";
//$mail->SMTPSecure= "tls";
$mail->Host="smtp.qq.com";
$mail->Port=465;
//$mail->Port=587;

//填写email账号和密码
$mail->Username="2939906971@qq.com";  //设置发送方
$mail->Password="ctyujctajtgbdgef";   //注意这里也要填写授权码就是我在上面QQ邮箱开启SMTP中提到的，不能填邮箱登录的密码哦。
$mail->From="2939906971@qq.com";      //设置发送方
$mail->FromName="梧桐树";
$mail->Subject="梧**发来的一封邮件";
$mail->AltBody=$body;
$mail->WordWrap=50;                  // 设置自动换行
$mail->MsgHTML($body);
$mail->AddReplyTo("2939906971@qq.com","梧**");//设置回复地址
$mail->AddAddress($email,"hello");  //设置邮件接收方的邮箱和姓名
$mail->IsHTML(true);                //使用HTML格式发送邮件
if(!$mail->Send()){//通过Send方法发送邮件,根据发送结果做相应处理
    echo "Mailer Error:".$mail->ErrorInfo;
}else{
    echo "Message has been sent"; }
