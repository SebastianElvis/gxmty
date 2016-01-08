<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model {
    public function register($data){
     	$User=M('User');
        $User->add($data);
		$result = M('user')->where('phone='. $data['phone'])->find();
		return $result;
    }
    
    public function login($phone,$password){
    	$User=M('User');
        $data['phone']=$phone;
        $data['password']=$password;
        $result=$User->where($data)->find();
        if($result != null){
            return $result;
        }
		else {
			return false;
		}
    }
	
	public function registerPhone($phone){ //判断是否被注册
		$User=M('user');
		$data['phone']=$phone;
		$result=$User->where($data)->find();
		if($result == null){
			return true;
		}
		else{
			return false;
		}
	}
}