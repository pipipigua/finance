<?php
namespace app\index\controller;
use think\Controller;
use think\captcha\Captcha;

class User extends Common
{
	public function index()
	{	 

        $where=$tempwhere=input('');
        // var_dump($where);
        if(empty($where['name'])){
            unset($where['name']);
        }
        if(empty($where['snid'])){
            unset($where['snid']);
        }
        

        if(!empty($where['start'])){
            $where['ctime'][]=[">=",strtotime($where['start'])];
            
        }

        if(!empty($where['end'])){
            $where['ctime'][]=["<=",strtotime($where['end'])+86400];
           
        }
        unset($where['start']);
        unset($where['end']);
        unset($where['page']);
  		// unset($where['snid']);
        
        if(isset($where['ctime']) && count($where['ctime'])==1){
            $where['ctime'] = $where['ctime'][0];
        }
        // var_dump($where);

		$student=db('student')->where($where)->paginate(1,null,['query'=>$tempwhere]);
        $res=db('student')->count();
        // var_dump($student);
        // var_dump($res);

		return $this->fetch('',['res'=>$res,'student'=>$student,'where'=>$tempwhere]);
	}
	public function stop()
		{
			$data=input('post.');
			// var_dump($data);
			
			$res=db('student')->where('snid',$data['snid'])->find();

			$ctime=time();
			if($res['is_stop']==0){
				$res=db('student')->where('snid',$data['snid'])->setField('is_stop','1');
				$res=db('student')->where('snid',$data['snid'])->update(['ctime' => $ctime]);
				if($res){
				
					exit(json_encode(['error'=>0,'info'=>"停用成功"]));
					}else{
						exit(json_encode(['error'=>1,'info'=>"停用失败
						"]));
				}
			}else{
				$res=db('student')->where('snid',$data['snid'])->setField('is_stop','0');
				if($res){
				
					exit(json_encode(['error'=>0,'info'=>"启用成功"]));
					}else{
						exit(json_encode(['error'=>1,'info'=>"启用失败"]));				
			}
		}
}
	public function revise()
    {
    	$data = input('sid');
    	// var_dump($data);
    	$res= db('student')->where('sid',$data)->find();
    	// var_dump($res);

		return $this->fetch('',['res'=>$res]);
    }
    public function alter()
    {
    	$data = input('post.');
// var_dump($data); 
    	$validate = validate('student');

		if(!$validate->check($data)){
			exit(json_encode(['error'=>1,'info'=>$validate->getError()]));
		}else{


			$res=db('student')->where('sid',$data['sid'])->update($data);
			
			exit(json_encode(['error'=>0,'info'=>'修改成功']));

			}
  }
   	public function list()
   	{	
   		$list=input('post.');
   		// var_dump($list);exit;
   		return $this->fetch('');
   	}

   	public function data()
   	{	
	   	// $list=input('post.');
	   	// $id = $_GET['sid'];
	   	// var_dump($list);
	   	// $list=$id['sid'];
	   	var_dump($lsit);
	   // exit();
	   	if (!empty($list)) {
	   			$data=db('student')->where('snid',$list)->select();
	   			$count=db('student')->where('snid',$list)->count();
	   		}else{
	   			$data=db('student')->where('sid','>=',1)->select();
	   			$count=db('student')->where('sid','>=',1)->count();
	   		}	;
   		// var_dump($data);
   		$arr = array();
   		$arr['code']=0;
   		$arr['msg']="";
   		$arr['count']=$count;
   		$arr['data']=$data;
   		$arr_json = json_encode($arr);
   		exit($arr_json);
   	}
   	public function add()
   	{	
   		$arr=db('model')->where('mid','>=',1)->select();
   		return $this->fetch('',['arr'=>$arr]);
   	}
   	public function addst()
   	{	
   		$data = input('post.');
   		// var_dump($data);
   		$validate = validate('student');
		if(!$validate->check($data)){
			exit(json_encode(['error'=>1,'info'=>$validate->getError()]));
			}
		$data['ctime']=time();
		// var_dump($data);exit;
		
		$res=db('student')->insert($data);
 		// var_dump($res);
		// $reg=db('student')->where('username',$data['username'])->field('aid')->find();

		if($res){
				
			exit(json_encode(['error'=>0,'info'=>"添加成功"]));
					
		}else{
			exit(json_encode(['error'=>1,'info'=>"添加失败"]));}
   	}

   	public function pay()
   	{
   		return $this->fetch('');
   	}
   	public function payfor()
   	{
   		// $where=$tempwhere=input('');
   		// var_dump($data);
   		$data=db('student')->where('is_stop',0)->select();

   		// var_dump($data);
   		
   		$count=db('student')->where('is_stop',0)->count();
   		$arr = array();
   		$arr['code']=0;
   		$arr['msg']="";
   		$arr['count']=$count;
   		$arr['data']=$data;
   		$arr_json = json_encode($arr);
   		exit($arr_json);
   	}
   	public function ex ()
   	{
   		return $this ->fetch('');
   	}
}