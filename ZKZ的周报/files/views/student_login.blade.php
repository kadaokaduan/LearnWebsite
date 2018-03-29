<form method="POST">
<!-- csrf_field()用于防止csrf攻击，必加，否则报错 -->
{{csrf_field()}}
<span>用户名</span>
<input type="text" name="j_username">
</br>
<span>密&nbsp;&nbsp;&nbsp;码</span>
<input type="password" name="j_password">
</br>
<input type="submit">
</form>