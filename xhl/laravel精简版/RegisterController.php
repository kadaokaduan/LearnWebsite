<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use DB;
use Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }



  public function active(array $data)
  {//如果激活码未到期且 verify正确 就对数据库进行数据更新 激活用户
    $token = $data['verify'];
    $user = DB::select('select * from users where token = ?', [$token]);
    $zero1=strtotime (date("y-m-d h:i:s")); //当前时间  ,注意H 是24小时 h是12小时
    $zero2=strtotime ($user[0]->created_at);  //过年时间，不能写2014-1-21 24:00:00  这样不对
    $left_time=($zero1-$zero2)/3600; //60s*60min
    if($user)
    {
      if($left_time<=24)
      {
        $affected = DB::update('update users set status= 1 where token = ?', [$token]);
        echo "激活成功";
      }
      else
      {
        echo "激活码已过期";
      }
    }
 }

    public function send(array $data)
    {
     $name = $data['name'];//第一个参数是包含邮件信息的视图名称；第二个参数是你想要传递到该视图的数组数据；第三个参数是接收消息实例的闭包回调
     $email = $data['email'];
     $token  = $data['token'];                                              //　第三个参数是匿名函数，变量名不可与第二个参数一样，可用 use 来连接函数外部的
     $flag = Mail::send('emails.test',['name'=>$name,'token'=>$token],           //第二个参数是一维数组 只能是1维数组 传入视图的参数
     function($message) use($email)        //此处发送邮件      第一个参数是view页面 可以在view  里添加blade文件 输入相应的代码来显示文件
     {                                            //此处意味 view文件夹下的 emails 文件夹下的test 页面
        $to =$email;
        $message ->to($to)->subject('请您激活账户');
      }
    );
      if(!$flag){
        echo '邮件发送成功    ';
      }
else {
        echo '邮件未能成功发送   ';
      }
      }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'status',
            'token'

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {
       $status = 0;
      // $rand = str_random(40);//随即生成字符串 用于激活标志
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' =>$status,
            'token'=>$data['token']
        ]);

    }
}
