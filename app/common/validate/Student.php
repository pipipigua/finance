<?php 
namespace app\common\validate;

use think\Validate;

class Student extends Validate
{	

    protected $rule = [
        'snid'  => 'require|unique:Student',
        'name'  => 'require',
        'class'  => 'require',
        'phone'  => 'require',
        'nameid' =>  'require|unique:Student'
    ];
  	 protected	$message = [
        'snid.require'=> '學號不能為空',
        'snid.unique'=>'學號已存在',
        'name'=>'姓名不能為空',
        'class'=> '班級不能為空',
        'phone'=> '手機號碼不能為空',
        'nameid' => '身份證號不能為空',
        'nameid.unique' => '身份證號已存在',

    ];
    // protected $scene = [
    //     'edit'  =>  ['repassword'],
    // ];

}
/**
* 
*/
 ?>