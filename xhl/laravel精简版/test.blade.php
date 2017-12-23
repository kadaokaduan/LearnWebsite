<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>激活邮件</title>
</head>
<body>
    <p>您好, {{$name}}  ！ 请点击下面链接完成注册:</p>
    <a href="http://localhost/activeAccount/?verify={{$token}}">激活链接</a>

</body>
</html>
