<?php
namespace Home\Model;
use Think\Model;
class FastExcModel extends Model {
	public function generate($wechat,$book,$description){
		$data['startWeChat']=$wechat;
		$data['book']=$book;
		$data['description']=$description;
		$fastExc=M('FastExc');
		$fastExc->data($data)->add();
		return $data;
	}
	
	public function listExc(){
		$fastExc=M('FastExc');
		$data = array();
		$result=$fastExc->where($data)->select();
		//$result=$fastExc->where('TO_DAYS(NOW())-TO_DAYS(startDate)<=7')->select();
		return $result;
	}
	
	public function getBigId(){
		$fastExc = M('fastExc');
		$data = array();
		$result = $fastExc->where($data)->order('id desc')->find();
		//$result = $fastExc->where('TO_DAYS(NOW())-TO_DAYS(startDate)<=7')->order('id desc')->find();
		if($result == NULL){
			return false;
		}
		else return $result['id'];
	}
	
	public function getSmallId(){
		$fastExc = M('fastExc');
		$data = array();
		$result = $fastExc->where($data)->order('id asc')->find();
		//$result = $fastExc->where('TO_DAYS(NOW())-TO_DAYS(startDate)<=7')->order('id asc')->find();
		if($result == NULL){
			return false;
		}
		else return $result['id'];
	}
	
	public function getResultById($id){
		$fastExc = M('fastExc');
		$result = $fastExc->where('ID=' . $id)->find();
		return $result;
	}
}

?>