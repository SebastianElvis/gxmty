<?php
namespace Home\Controller;
use Think\Controller;
class OldBookController extends Controller {
	public function index(){
		$this->display();
	}
	
	public function startExchange(){
		$this->display();
	}
	
	public function submitExchange(){
		header("Content-type:text/html;charset=utf-8");
		$exchangeInfo['book']=I('post.book');
		$exchangeInfo['bookStatement']=I('post.bookStat');
		$exchangeInfo['condition1']=I('post.condition1');
		$exchangeInfo['condition2']=I('post.condition2');
		$exchangeInfo['condition3']=I('post.condition3');
		$exchangeInfo['condition4']=I('post.condition4');
		$publicInfo=I('post.publicInfo');
		$exchangeInfo['publicInfo']=$publicInfo[0];
		$exchangeInfo['description']=I('post.description');
		$exchange=D('Exchange');
		$exchange->generateExchange(
					$exchangeInfo['book'],
					$exchangeInfo['bookStatement'],
					$exchangeInfo['condition1'],
					$exchangeInfo['condition2'],
					$exchangeInfo['condition3'],
					$exchangeInfo['condition4'],
					$exchangeInfo['publicInfo'],
					$exchangeInfo['description']);
		$exchange->generateStart();
		$this->success('发布交换成功！','../Index/homePage');
	}
	
	public function allExchange(){
		//$page=(I('get.page')==null)?1:I('get.page');
		$exchange=D('Exchange');
		$result=$exchange->queryAllExchange();
		$this->resultCount = count($result);
		$this->result=$result;
		$this->display();
	}
	
	public function exchangeDetail(){  //查看交易细节、申请
		$excid=I('get.excid');
		$exchange=D('exchange');
		$detail=$exchange->getDetail($excid);
		//dump($detail);
		$this->detail=$detail;
		$this->excid=$detail['start']['excid'];
		$this->applyUserID=session('user.id');
		$this->display('exchangeDetail1');
	}
	
	public function submitApply(){
		$excid=I('post.excid');
		$applyUserID=I('post.applyuserid');
		$condition1=I('post.condition1');
		$condition2=I('post.condition2');
		$condition3=I('post.condition3');
		$condition4=I('post.condition4');
		$satisfy[1]=$condition1[0]==1?1:0;
		$satisfy[2]=$condition2[0]==1?1:0;
		$satisfy[3]=$condition3[0]==1?1:0;
		$satisfy[4]=$condition4[0]==1?1:0;
		$description=I('post.description');
		$apply=D('apply');
		$apply->generateApply($excid,$applyUserID,$satisfy,$description);
		$this->success('申请成功！','../Index/homePage',1);
	}
	
	public function excStartedByMe(){  //我发起的
		//echo '我发起的';
		$data=D('exchange');
		//dump( session('user') );
		$result=$data->queryExcStartedByMe();
		//dump($result);
		$this->result=$result;
		$this->resultCount=count($result);
		$this->display();
	}
	public function applyDetail(){
		$excid=I('get.excid');
		$data=D('apply');
		
		$exchange=M('exchange');
		$excDetail=$exchange->where('excID='.$excid)->find();
		//dump($excDetail);
		$result=$data->queryApply($excid);
		//dump($result);
		
		$this->excDetail=$excDetail;
		$this->result=$result;
		$this->resultCount=count($result);
		$this->display();
	}
	
	public function acceptApply(){
		$applyID=I('get.applyid');
		$apply=D('apply');
		$apply->acceptApply($applyID);
		$this->success('已达成交易！',"../../excStartedByMe",1);
	}
	
	public function refuseApply(){
		$applyID=I('get.applyid');
		$apply=D('apply');
		$apply->refuseApply($applyID);
		$this->success('已拒绝交易！',"../../excStartedByMe",1);
	}
	public function completedExcDetail(){
		$excid=I('get.excid');
		$exchange=D('exchange');
		$result=$exchange->queryCompletedExc($excid);
		//dump($result);
		$this->result = $result;
		$this->display();
	}
	public function excAppliedByMe(){  //我申请的
		$myID=session('user.id');
		$apply=D('apply');
		$result=$apply->myApply($myID);
		//dump($result);
		$this->result=$result;
		$this->numFinished=count($result['finished']);
		$this->numUnfinished=count($result['unfinished']);
		$this->numRefused=count($result['refused']);
		$this->display();
	}
}
