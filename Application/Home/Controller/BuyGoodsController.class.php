<?php
namespace Home\Controller;
use Think\Controller;
class BuyGoodsController extends Controller {
	
	public function index(){
		$this->display();
	}
	
	public function myOrder(){
		echo 'fuck';
	}
	
	public function orderThings(){
		session('order',null);
		session('orderList',null);
		$data=D('item');
		$type=$data->queryType();
		//print_r($type);
		$this->typeNum=count($type);
		$this->type=$type;
		$this->display();
	}
	
	public function orderListByType(){
		$type=I('get.type');
		$data=D('item');
		$goods=$data->queryGoods($type);
		$this->type=$type;
		$this->goods=$goods;
		$this->goodsNum=count($goods);
		$this->display();
	}
	
	public function ajaxAdd(){
		$id=I('get.id');
		$num=I('get.number');
		session('order.'.$id,$num,360);
	}
	
	public function ajaxDec(){
		$id=I('get.id');
		$num=I('get.number');
		session('order.'.$id,$num,360);
	}
	
	public function ajaxCount(){
		$id=I('get.id');
		$count=I('get.count');
		session('order.'.$id,$count,360);
	}
	
	public function confirmOrder(){
		$order=session('order');
		$showtime=date("Y-m-d H:i:s");
		$itemTb=M('item');
		//print_r(session('user'));echo "<br/><br/>";
		$i=0;
		$totalPrice=0;
		foreach($order as $x=>$x_value){
			$condition['itemID']=$x;
			$item=$itemTb->where($condition)->find();
			$totalPrice=$totalPrice+($item['price'])*($x_value);
			
			$orderList[$i]=array(
				'userID'=>session('user.id'),
				'itemID'=>$x,
				'itemName'=>$item['name'],
				'itemNums'=>$x_value,
				'tradeTime'=>$showtime,
				'price'=>$item['price']
			);
			
			$i=$i+1;
		}
		$this->orderList=$orderList;
		$this->orderLength=count($orderList);
		$this->totalPrice=$totalPrice;
		session('orderList',$orderList);
		$this->display();
	}
	
	public function submitOrder(){
		$orderList=session('orderList');
		$i=0;
		$count=count($orderList);
		$buy=M('buy');
		for($i=0;$i<$count;$i++){
			$buy->data($orderList[$i])->add();
		}
		session('orderList',null);
		$this->success('购买成功！','../Index/homePage');
	}
	
}