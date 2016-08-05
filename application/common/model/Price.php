<?php
namespace app\common\model;

use \think\Model;
use \think\Db;
use \PDOException;

class Price extends Model
{
	protected $autoWriteTimestamp = true;
    public function areaFrom(){
        return $this->hasOne('Area','id','from');
    }
    public function areaTo(){
        return $this->hasOne('Area','id','to');
    }
    public function add($data){
        return $this->save($data);
    }
    public function edit($data){
        return $this->save($data,['id'=>$data['id']]);
    }
    public function del($data){
        return db('price')->delete($data);
    }
    //获取行程价格
    public function getPrice($data){
        return model('price')->where('from',$data)->select();
    }
}
