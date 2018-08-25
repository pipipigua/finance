<?php
namespace app\index\controller;
use think\Controller;
use think\captcha\Captcha;

class Index extends Common
{
    public function index()
    {
		return $this->fetch(); 
    }
    public function welcome()
	{
		return $this->fetch('');

	}



}