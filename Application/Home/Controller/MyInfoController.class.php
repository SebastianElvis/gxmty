<?php
namespace Home\Controller;
use Think\Controller;
class MyInfoController extends Controller {
	public function index(){
		$this->result = session('user');
		$this->display();
	}
	
	public function testUpload(){
		$this->display();
	}
	
	public function checkLogin(){
		$UserData=D('User');
		$phone=I('post.phone');
		$password=I('post.password');
		$userInfo=$UserData->login($phone,$password);
		if($userInfo != false){
			$time = 3600 * 24 * 7;
			cookie('id' , $userInfo['id'] , $time);
			session('user',$userInfo);
			$this->success('登陆成功','../Index/homePage');
			//echo 'Success';
		}
		else{
			$this->error('登录失败，请重新输入！','../Index/login',1);
			//echo 'Fail';
		}
	}
    /*
     *注册
     */

	public function checkRegister(){
		$UserData=D('user');
		$data['phone']=I('post.phone');
		$data['password']=I('post.password');
		$data['school']=I('post.school');
		$data['sex']=I('post.sex');
		$isRegistered = $UserData->registerPhone($data['phone']);
		if($isRegistered == true){
			$result = $UserData->register($data);
			cookie('id',$result['id']);
			$this->success('注册成功！','../Index/hello',1);
		}
		else{
			$this->error('此手机已被使用，请更换手机号','../Index/register',1);
		}
	}
	
	public function changeInfo(){
		$this->result = session('user');
		$this->display();
	}
	
	public function submitChange(){
		$UserData=M('user');
		$data['nickName']=I('post.nickName')  ;
		$data['phone']=I('post.phone');
		$data['password']=I('post.password');
		$data['school']=I('post.school');
		$data['sex']=I('post.sex');
		$data['studentNumber']=I('post.studentNumber');
		$UserData->where( 'ID='.session('user.id') )->save($data);
		session('user' , NULL);
		$this->success('修改成功！','../Index/hello',1);
	}
	
	public function information(){
		dump(session('user'));
	}
	
	/*
	public function checkRegisterPhone(){
		$UserData=D('user');
		$phone=I('get.phone');
		$isPhoneValid['status']=$UserData->registerPhone($phone);
		$this->ajaxReturn($isPhoneValid,'JSON');
	}
	*/
	
	
    

}