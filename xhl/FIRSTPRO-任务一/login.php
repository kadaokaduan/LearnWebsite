<html>  
<!-- 注册页面 -->
<head>  
<meta http-equiv="content-type" content="text/html;charset=gb2312" />  
<title>用户注册</title>  
<script type="text/javascript"> 
 IUA=1;     //页面内全局变量    设置的状态栏 判断用户名是否可用
 IEA=1;     //状态标签 判断邮箱是否已经被注册了
 CB=1;      //回调函数的输出参数
 STATE=false;
function getXmlHttpObject(){  
    if(window.ActiveXObject){    
        xmlHttpRequest=new ActiveXObject("Microsoft.XMLHTTP");  
        }  
    else{  
        xmlHttpRequest=new XMLHttpRequest();  
        }  
    return xmlHttpRequest;  
}  
var myXmlHttpRequest=""; 
function checkName(flag){ //作用就是获得本页面的相应数据并进行检验  参数flag用于判断检验邮箱或者用户
	if(STATE)return ;
	STATE=true;
    myXmlHttpRequest=getXmlHttpObject();// 调用该函数来创建对象 
    if(myXmlHttpRequest){    
        var url="http://localhost:8080/FIRSTPRO/index.php";              //更改为相应的PHP文件，用于查询是否已经存在相同的用户名
        var f="&flag="+flag;  //标志位
        if(flag==1){  
        var data="username="+$("user").value;    //获得本页面用户输入的数据  并且确定投递时使用的键值
        myXmlHttpRequest.onreadystatechange=chuli;
        }else if(flag==2){
        var data="username="+$("email").value;
        myXmlHttpRequest.onreadystatechange=chuli2;
        }
        CB=flag;  //设置回掉函数的输出框
        myXmlHttpRequest.open("post",url,true); 
        myXmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  
        //myXmlHttpRequest.onreadystatechange=chuli;  
        myXmlHttpRequest.send(data+f); //通过send 一次传送多个参数 
        
        }  

}

//回调函数  1
function chuli(){ 
    if(xmlHttpRequest.readyState==4){
     STATE=false; 
     document.getElementById("txtHint").innerHTML=xmlHttpRequest.responseText;
     text=xmlHttpRequest.responseText;//判断文本内容是否为空，从而判断用户名是否可用
     if(text.length!=3)// 把3当成空的状态  我也不知道为什么我明明什么都不显示还会有返回的长度
	  {
         IUA=0;//设置为不通过状态
     }
     else
     {
         IUA=1; 
     }
    }
}    
//回调函数  2
function chuli2(){ 
    if(xmlHttpRequest.readyState==4){
     STATE=false;    
     document.getElementById("txtHint2").innerHTML=xmlHttpRequest.responseText;
     text=xmlHttpRequest.responseText;//判断文本内容是否为空，从而判断用户名是否可用
     if(text.length!=3)// 把3当成空的状态  我也不知道为什么我明明什么都不显示还会有返回的长度
	 {
         IEA=0;//设置为不通过状态
         //alert(IUA);
     }
     else
     {
         IEA=1; 
     }
    }
}    

   



function $(id){  
    return document.getElementById(id);  //根据名称即可理解 就是根据id返回对应的元素
 } 

 
function formCheck(){
    var pwd1 = document.getElementById("pass").value;    //获得输入的密码
    var pwd2 = document.getElementById("pass2").value;   //获得再次输入的密码
    var Email = document.getElementById("email").value;  //获得Email
    var isRight = chkEmail(Email);                       //检验邮箱格式是否合格
    var isUsernameAvailable =IUA;                          //检查用户名是否可用
    var isEmailAvailable = IEA;                             //检查邮箱是否已经被注册过
                        
     if(isUsernameAvailable==0){
         alert("用户名已经被注册！ ");
         return false;
     }
     else if(isEmailAvailable==0){
         alert("邮箱已经被注册过！");
         return false;
     }
     else if(pwd1!=pwd2){                                   
         alert("两次密码输入不一致！");
         return false;
     }
     else if(!isRight){
         alert("邮箱格式不正确！");
         return false;
     }
     return true;      
 }
 
 function chkEmail(strEmail) //使用正则表达式判断邮箱格式是否合法
 {
 	if (!/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(strEmail)){
 	return false;
 	}
 	else {
 	return true;
 	}
 } 	
 
</script>  
</head>  
<body>  
   <form id="reg" action="register.php" method="post" onsubmit= "return formCheck() ">
  <p>User Name： <input type="text" onblur="checkName(1)" required="required"  class="input" name="username" id="user"> </p>
  <div  id="txtHint" style="color:red;"><b ></b></div>    
<!--     这里显示是否已经注册的信息 -->
  
  <p>E-Mail: <input type="text" onblur="checkName(2)" required="required" class="input" name="email" id="email"></p>
   <div  id="txtHint2" style="color:red;"><b ></b></div>
 <!--     这里显示是否已经注册的信息 -->
   
  <p>Password： <input  type="password" required="required" class="input" name="password" id="pass"></p>
  <p>Confirm Password： <input  type="password" required="required" class="input" name="password" id="pass2"></p>
  
  
   
  <p><input id="checkemail" type="submit" class="but" value="提交注册"></p>
 </form> 
 
</body>  
</html>







    
