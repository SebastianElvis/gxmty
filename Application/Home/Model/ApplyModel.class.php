<?php
namespace Home\Model;
use Think\Model;
class ApplyModel extends Model {
	public function generateApply($excid,$applyUserID,$satisfy,$description){
		$data['applyUserID']=$applyUserID;
		$data['excID']=$excid;
		$data['satisfy1']=$satisfy[1];
		$data['satisfy2']=$satisfy[2];
		$data['satisfy3']=$satisfy[3];
		$data['satisfy4']=$satisfy[4];
		$data['applyTime']=date("Y-m-d H:i:s");
		$data['applyStatus']=0;
		$data['description']=$description;
		
		$apply=M('apply');
		$apply->data($data)->add();
		
		$exc=M('exchange');
		$change['status']=1;
		$exc->where('excID='.$excid)->save($change);
	}
	
	public function queryApply($excid){
		$data=M('apply');
		$result=$data->where('excID='.$excid.' AND applyStatus <>-1')->select();
		return $result;
	}
	
	public function acceptApply($applyid){
		$apply=M('apply');
		$exchange=M('exchange');
		$applyData['applyStatus']=1;
		$exchangeData['status']=2;
		$apply->where('applyID='.$applyid)->save($applyData);
		$applyDetail=$apply->where('applyID='.$applyid)->find();
		$excid=$applyDetail['excid'];
		$exchange->where('excID='.$excid)->save($exchangeData);
	}
	
	public function refuseApply($applyid){
		$apply=M('apply');
		$applyData['applyStatus']=-1;
		$apply->where('applyID='.$applyid)->save($applyData);
	}
	
	public function myApply($myID){
		$model=new Model();
		$result['refused']=$model->query('SELECT * 
		FROM mty_apply apply,mty_exchange exc 
		WHERE apply.applyUserID='.$myID.' 
		AND apply.excID=exc.excID 
		AND apply.applyStatus=-1');
		$result['unfinished']=$model->query('SELECT * 
		FROM mty_apply apply,mty_exchange exc 
		WHERE apply.applyUserID='.$myID.' 
		AND apply.excID=exc.excID 
		AND exc.status=1
		AND apply.applyStatus=0');
		$result['finished']=$model->query('SELECT * 
		FROM mty_apply apply,mty_exchange exc 
		WHERE apply.applyUserID='.$myID.' 
		AND apply.excID=exc.excID 
		AND exc.status=2 
		AND apply.applyStatus=1');
		return $result;
	}
}