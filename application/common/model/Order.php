<?php
namespace app\common\model;

use \think\Model;
use \think\Db;
use \PDOException;

class Order extends Model
{
	protected $table = 'orders';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public function areaFrom(){
        return $this->hasOne('Area','id','from');
    }
    public function areaTo(){
        return $this->hasOne('Area','id','to');
    }
    public function brand(){
        return $this->hasOne('brand','id','bid');
    }
    public function price(){
        return $this->hasOne('price','id','price_id');
    }
    public function getList($data){
        $pageSize = 5;
        $list = db("orders")
            ->alias('o')
            ->field(['o.id','o.name','o.phone','o.go_time','o.status','f.name'=>'from','t.name'=>'to','p.price'])
            ->join('__AREA__ f','o.from = f.id')
            ->join('__AREA__ t','o.to = t.id')
            ->join('__PRICE__ p','o.price_id = p.id')
            ->where(['mid'=>session('userMember')->id])
            ->limit($data['page']*$pageSize,$pageSize)
            ->order('id desc')
            ->select();
        return $list;
    }

}
