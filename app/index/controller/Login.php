<?php
namespace app\index\controller;
use think\Controller;
use think\captcha\Captcha;

class Login extends Controller
{
    public function index()
    {

    	return $this->fetch('');
    }

    public function checkdata()
    {

        $data = input('post.');
        // var_dump($data);
        $captcha = new Captcha();

       if(!$captcha->check($data['captcha'],'')){
            exit(json_encode(['error'=>1,'info'=>"验证码错误"]));
       }

        $user = db('admin')->where(['username'=>$data['username'],'password'=>md5($data['password'])])->find();
        
        // var_dump($user);
        
        	if($user['is_stop']==1){

            	session('aid',$user['aid']);
            	session('username',$user['username']);
            	$ip = get_client_ip();
            	$date= date("Y-m-d h:i:s");
            	$reg=db('admin')->where('aid',session('aid'))->update(['lip' => $ip]);
            	$reg=db('admin')->where('aid',session('aid'))->update(['ltime' => $date]);

            	exit(json_encode(['error'=>0,'info'=>"登錄成功"]));
        	}else{
            	exit(json_encode(['error'=>1,'info'=>"賬號或者密碼錯誤"]));
        	}
        }
    public function loginout()
    {
       session(null);
        $this->error('退出成功','index/login/index');
    }

    public function code()
    {
       $config =    [   
            // 验证码位数
            'length'      =>    3,
            'imageH'      =>  48 
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }


}
