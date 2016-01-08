<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        ;
    }
    public function testAndroid(){
		$json["a"]='asd';
		$json["b"]='3333';
		echo json_encode($json);
	}
    /*
     *第一次进入页面
     */
    public function hello(){
		$id = cookie('id');
		//dump($id);
        if( empty($id) ){      ////////////////
            header('Location: ' . U('Home/Index/login') );
        }
        else{
            header('Location: ' . U('Home/Index/homePage') );
        }
        //echo 'fuck';
    }
    
    /*
     *登陆
     */
    public function login(){
		$this->display();
    }
    
	public function logout(){
		session(NULL);
		cookie('id' , null);
		$this->success('已退出登陆' , U('Home/Index/login') , 1 );
	}
	
    /*
     *注册
     */
    public function register(){
    	$this->display();
    }
    
    /*
     *主界面
     */
    public function homePage(){
		header("Content-type: text/html; charset=utf-8");
		$id = cookie('id');
		//echo $id;
		if( (!empty($id)) && ( session('user') == NULL ) ){
			$UserModel = M('user');
			$data['ID'] = $id;
			$user = $UserModel->where($data)->find();
			session( 'user' , $user );
		}
    	//var_dump(session('user'));
		$this->display();
    }
	
	public function mainPage(){
		$this->display();
	}
}