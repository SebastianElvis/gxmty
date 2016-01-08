<?php
namespace Home\Model;
use Think\Model;
class ItemModel extends Model {
    public function queryType() {
        $Item=new Model();
        $type=$Item->query("SELECT B.typeChn AS typeName,A.type AS typeEng 
		FROM mty_item A,mty_itemType B 
		WHERE A.type=B.typeEng GROUP BY typeName");
        return $type;
    }

    public function queryGoods($type) {
        $Item=M('item');
		$data['type']=$type . "";
        $goods=$Item->where($data)->select();
        return $goods;
    }

}