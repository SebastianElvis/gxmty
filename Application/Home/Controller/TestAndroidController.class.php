<?php
namespace Home\Controller;
use Think\Controller;
class TestAndroidController extends Controller {
	public function index(){
		$json[0]='aaa';
		$json[1]=123;
		echo json_encode($json);
	}
	
	public function user(){
		header("Content-type: text/html; charset=utf-8");
		//$_SERVER['REQUEST_METHOD']
		$verb=$_SERVER['REQUEST_METHOD'];
		//echo $verb;
		$user=D('user');
		
		switch( strtolower($verb) ){
		
			case 'get': //查
				
				break;
			
			case 'post': //增
				
				$do = I('post.do');
				
				if( $do == 'login' ){
					$phone=I('post.phone');
					$password=I('post.password');
					$result = $user->login($phone , $password);
					
					if($result != false){
						$json['status']=true;
						$json['user']=$result;
					}
					else{
						$json['status']=false;
					}
					$json['do'] = 'login';
					echo json_encode($json);
				}
				
				else if ($do == 'register' ){
					$data['phone']=I('post.phone');
					$data['password']=I('post.password');
					$data['school']=I('post.school');
					$data['sex']=I('post.sex');
					$register = $user->register($data);
					if($register == true){
						$json['status']=true;
					}
					else{
						$json['status']=false;
					}
					$json['do']= 'register';
					echo json_encode($json);
				}
				break;
				
			case 'put':  //改
				break;
				
			case 'delete':  //删
				break;
				
			default:
				break;
		}
	}
}