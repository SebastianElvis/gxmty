<?php
namespace Home\Controller;
use Think\Controller;
class FastExcController extends Controller {
	public function startExc(){
		$this->display();
	}

	public function generateFastExc(){
		$wechat=I('post.wechat');
		$book=I('post.book');
		$desc=I('post.description');
		//echo $wechat.$book.$desc;
		$fastExc=D('FastExc');
		$fastExc->generate($wechat,$book,$desc);
		$this->success('发布快速交易成功！','./viewExc',2);
	}
	
	public function viewExc(){
		$fastExc = D('FastExc');
		$min = $fastExc->getSmallId();
		$max = $fastExc->getBigId();
		$range = $max - $min;
		$range = min( $range , 4 );
		$this->range = $range;
		$this->display();
	}

    public function a(){
        echo 'a';
    }
	
	public function getSomeResults(){
		$fastExc = D('FastExc');
		$min = $fastExc->getSmallId();
		$max = $fastExc->getBigId();
		//echo $min . "\n" . $max . "\n";
		if( ($min == false) || ($max == false) ){
			$result['status'] = false;
		}
		else{
			$rand = range($min , $max );
			shuffle($rand);
			for($i=0; ( $i<4 ) && ($i < count($rand) ) ;$i++){
				$result['data'][$i] = $fastExc->getResultById($rand[$i]);
			}
			$result['status'] = true;
		}
		$this->ajaxReturn($result);
	}
	
	public function AndroidFastExc(){
		header("Content-type: text/html; charset=utf-8");
		//$_SERVER['REQUEST_METHOD']
		$verb=$_SERVER['REQUEST_METHOD'];
		//echo $verb;
		switch( strtolower($verb) ){
			case 'post':  //增
				$wechat=I('post.wechat');
				$book=I('post.book');
				$desc=I('post.description');
				$fastExc=D('FastExc');
				$newData=$fastExc->generate($wechat,$book,$desc);
				$json['status']=1;
				$json['data']=$newData;
				echo json_encode($json);
				break;
				
			case 'get':   //查
				$fastExc=D('FastExc');
				$result=$fastExc->listExc();
				$json['status']=1;
				$json['data']=$result;
				echo json_encode($json);
				break;
				
			case 'put':   //改
			
			
				break;
				
			case 'delete': //删
			
			
				break;
				
			default:
				break;
			
		}
	}
}

?>