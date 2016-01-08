<?php
namespace Home\Controller;
use Think\Controller;
class WeChatController extends Controller {

	public function hello(){
		echo 'aaa';
	}
	
	public function index(){
		$options = array(
			'token'=>'gxmtyToken', //填写你设定的key
			'encodingaeskey'=>'S3hH8MqXXtNBuomOAnrMOVN3le2PciURw353c9KRCEP', //填写加密用的EncodingAESKey
			'appid'=>'wx4295d3f45a7d51c7', //填写高级调用功能的app id, 请在微信开发模式后台查询
			'appsecret'=>'xxxxxxxxxxxxxxxxxxx' //填写高级调用功能的密钥//
		);
		$weObj = new \Org\WeChat\Wechat($options);
		$weObj->valid();
		$type = $weObj->getRev()->getRevType();
		switch($type) {
			case Wechat::MSGTYPE_TEXT:
				$weObj->text("hello, I'm wechat")->reply();
				exit;
				break;
			case Wechat::MSGTYPE_EVENT:
				break;
			case Wechat::MSGTYPE_IMAGE:
				break;
			default:
				$weObj->text("help info")->reply();
		}
	}
	
	/* public function wechatLogin(){
		if(!empty(session('access_token'))){
			$access_token = session('access_token');
			$openid = session('openid');
			
		}else{
			header('Location: ./oauth');
		}
	} */
	
	public function oauth(){
		define('APPID' , 'wx4295d3f45a7d51c7');
		define('APPSECRET' , '67387dcc3c3dcd5c8118b090daddd687');
		define('REDIRECT_URI' , 'http://www.gxmty.xyz/index.php/Home/WeChat/agreeAuth'); 
		define('SCOPE' , 'snsapi_userinfo');
		$url ='https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . APPID . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&scope='. SCOPE .'&state=123#wechat_redirect' ;
		header('Location: ' . $url);
	}
	
	public function agreeAuth(){
		define('APPID' , 'wx4295d3f45a7d51c7');
		define('APPSECRET' , '67387dcc3c3dcd5c8118b090daddd687');
		$code = I('get.code');
		$state = I('get.state');
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='. APPID .'&secret='. APPSECRET .'&code='. $code .'&grant_type=authorization_code';
		$contents = file_get_contents($url);
		$json = json_decode($contents , true);
		dump($json);
		//session('access_token' , $json['access_token']);
		//session('openid' , $json['openid']);
		$successUrl ='https://api.weixin.qq.com/sns/userinfo?access_token='. $json['access_token'] .'&openid='. $json['openid'] .'&lang=zh_CN';
		$userInfoRes = file_get_contents($successUrl);
		$resJson = json_decode($userInfoRes , true);
		dump($resJson);
	}
}