<?php
namespace Home\Controller;
use Think\Controller;
use sinacloud\sae\Storage as Storage;
class FileReaderController extends Controller {

    public function getUrl() {
		header("Content-type:text/html;charset=utf-8");
		Storage::setAuth('gxmty:zlkmj4x530','5i4ikkiy24yky2mzy4kh5j1440z2mx40i5im2x4x');
		$fileList=Storage::getBucket('buptfile');
		$fileNum=count($fileList);
		$this->fileList=$fileList;
		$this->num=$fileNum;
		$this->display();
		//dump($fileList);
    }

    public function displayPdf() {
		//将来做成get方式打开
		$url=I('get.url');
        $this->url=$url;
        $this->display();
    }


}