<?php
namespace Home\Model;
use Think\Model;
class ExchangeModel extends Model {
	public function generateExchange($book,$bookStat,$condition1,$condition2,$condition3,$condition4,$publicInfo,$description){
		$exchange=M('Exchange');
		
		$exchangeInfo['book']=$book;
		$exchangeInfo['bookStatement']=$bookStat;
		$exchangeInfo['condition1']=$condition1;
		$exchangeInfo['condition2']=$condition2;
		$exchangeInfo['condition3']=$condition3;
		$exchangeInfo['condition4']=$condition4;
		$exchangeInfo['publicInfo']=$publicInfo;
		$exchangeInfo['description']=$description;
		$exchangeInfo['startTime']=date("Y-m-d H:i:s");
		
		$exchange->data($exchangeInfo)->add();
	}
	
	public function generateStart(){
		$exchange=M('Exchange');
		$latestResult=$exchange->order('excID desc')->find();
		$data['excID']=$latestResult['excid'];
		$data['startUserID']=session('user.id');
		//var_dump($latestResult);
		$start=M('Start');
		$start->data($data)->add();
	}
	
	public function queryAllExchange(){
		$exchange=M('Exchange');
		//$result=$exchange->where('status<>2')->order('excID desc')->limit( (($i-1)*10) . ',10' )->select();
		$result=$exchange->where('status<>2')->order('excID desc')->select();
		return $result;
	}
	
	public function getPage(){
		$data=M('exchange');
		$numberOfResult=$data->where('status<>2')->count();
		$page=(int)(ceil($numberOfResult/10));
		return $page;
	}
	
	public function getDetail($excid){
		$exchange=M('exchange');
		$condition['excID']=$excid;
		$excDetail=$exchange->where($condition)->find();
		
		$start=M('start');
		$startCondition['excID']=$excid;
		$startDetail=$start->where($startCondition)->find();
		
		$user=M('user');
		$userCondition['ID']=$startDetail['startuserid'];
		$userDetail=$user->where($userCondition)->find();
		
		$detail['user']=$userDetail;
		$detail['start']=$startDetail;
		$detail['exchange']=$excDetail;
		return $detail;
	}
	
	public function queryExcStartedByMe(){
		$start=new Model();
		/* $result=$start->query("SELECT * FROM mty_start st,mty_exchange exch 
		WHERE exch.status>=0 
		AND st.startUserID=".session('user.id').' 
		AND st.excID=exch.excID 
		AND (TO_DAYS(NOW())-TO_DAYS(exch.startTime)<=7)
		ORDER BY exch.status,exch.startTime DESC'); */
		
		$result=$start->query("SELECT * FROM mty_start st,mty_exchange exch 
		WHERE exch.status>=0 
		AND st.startUserID=".session('user.id').' 
		AND st.excID=exch.excID 
		ORDER BY exch.status,exch.startTime DESC');
		return $result;
	}
	
	public function queryCompletedExc($excid){
		$exchange=M('exchange');
		$condition['excID']=$excid;
		$excDetail=$exchange->where($condition)->find();
		
		$start=M('start');
		$startCon['excID']=$excDetail['excid'];
		$startDetail=$start->where($startCon)->find();
		
		$apply=M('apply');
		$applyCon['applyStatus']=1;
		$applyCon['excID']=$excid;
		$applyDetail=$apply->where($applyCon)->find();
		
		$user=M('user');
		$applierCon['ID']=$applyDetail['applyuserid'];
		$applierDetail=$user->where($applierCon)->find();
		$starterCon['ID'] = $startDetail['startuserid'];
		$starterDetail=$user->where($starterCon)->find();
		
		$result['exchange']=$excDetail;
		$result['apply']=$applyDetail;
		$result['applier']=$applierDetail;
		$result['starter']=$starterDetail;
		
		return $result;
	}
}