   <?php 
    //与login.php 进行交互，从而判断用户名和邮箱是否合法
    $dbhost = 'localhost:3306';  // mysql服务器主机地址
    $dbuser = 'root';            // mysql用户名
    $dbpass = '123456';          // mysql用户名密码
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
    if(! $conn )
    {
        die('Could not connect: ' . mysqli_error());
    } 
    $username = $_POST['username']; //获取 id为username的投递函数 
    $flag=$_POST['flag'];
    if($flag==1){//如果是用户名检查
    $sql = "select user_id from sheet1 where user_name='$username'";
    }else if($flag==2){//如果是邮箱检查
    $sql = "select user_id from sheet1 where email='$username'";     
    }
    mysqli_select_db( $conn, "USER");
    $retval = mysqli_query( $conn, $sql );
    $row = mysqli_fetch_array($retval);
    if(!empty($row))echo "already exsit!";
    //else echo "available!";
    
    ///在php中的echo中的文本 就是ajax中的输出文本
    
   