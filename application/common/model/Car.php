<?php
namespace app\common\model;

use \think\Model;
use \think\Db;
use \PDOException;

class Car extends Model
{
	protected $autoWriteTimestamp = true;
    protected $insert = ['create_time'];
    protected $update = ['update_time'];

	public function parent(){
		return $this->hasMany('brand','id','bid');
	}
	public function areaFrom(){
		return $this->hasOne('Area','id','from');
	}
	public function areaTo(){
		return $this->hasOne('Area','id','to');
	}
    // 车辆添加
    public function getCar($id){
        $data = $this->find($id);
        $data['gallery'] = json_encode(db('car_gallery')->where(['cid'=>$id])->select());
        return $data;
    }
	public function add($data){
		return Db::transaction(function () use ($data) {
            $id = $this->save([
                'bid'=>$data['bid'],
                'type'=>$data['type'],
                'color'=>$data['color'],
                'number'=>$data['number'],
                'name'=>$data['name'],
                'phone'=>$data['phone'],
                'from'=>$data['from'],
                'to'=>$data['to'],
                'go_time'=>$data['go_time'],
                'thumb'=>$data['thumb'][0],
            ]);

            if ($id === false) {
                throw new PDOException($this->getError());
            }

            if (isset($data['thumb']) && is_array($data['thumb']) && !empty($data['thumb'])) {
                for ($i=0; $i < count($data['thumb']); $i++) { 
                	db('car_gallery')->insert([
                        'cid'=>$id,
                        'gallery'=>$data['thumb'][$i]
                		]);
                }
            }

            return $id;
        });
	}
    public function edit($data){
        return Db::transaction(function () use ($data) {
            $id = $this->save([
                'bid'=>$data['bid'],
                'type'=>$data['type'],
                'color'=>$data['color'],
                'number'=>$data['number'],
                'name'=>$data['name'],
                'phone'=>$data['phone'],
                'from'=>$data['from'],
                'to'=>$data['to'],
                'go_time'=>$data['go_time'],
                'thumb'=>$data['thumb'][0],
            ],['id'=>$data['id']]);

            if ($id === false) {
                throw new PDOException($this->getError());
            }
            db('car_gallery')->where(['cid'=>$data['id']])->delete();
            if (isset($data['thumb']) && is_array($data['thumb']) && !empty($data['thumb'])) {
                for ($i=0; $i < count($data['thumb']); $i++) {
                    db('car_gallery')->insert([
                        'cid'=>$data['id'],
                        'gallery'=>$data['thumb'][$i]
                        ]);
                }
            }

            return $id;
        });
    }
	public function del($id){
		return Db::transaction(function () use ($id){
			$cid = db('car')->delete($id);
			if ($cid === false) {
                throw new PDOException($this->getError());
            }
			db('car_gallery')->where('cid',$id)->delete();
			return $cid;
        });
	}
    public function addCar($data){
        return Db::transaction(function () use ($data) {
            $id = $this->save([
                'bid'=>$data['bid'],
                'type'=>$data['type'],
                'color'=>$data['color'],
                'number'=>$data['number'],
                'name'=>$data['name'],
                'phone'=>$data['phone'],
                'from'=>$data['from'],
                'to'=>$data['to'],
                'mid'=>session('userMember.id'),
                'go_time'=>$data['go_time'],
                'thumb'=>str_replace('\\','/',DS . 'static'.DS.'car'.DS.date('Ymd').DS.BaseUpload($data['thumb'][0],'car')),
            ]);

            if ($id === false) {
                throw new PDOException($this->getError());
            }
            if (isset($data['thumb']) && is_array($data['thumb']) && !empty($data['thumb'])) {
                for ($i=0; $i < count($data['thumb']); $i++) {
                    db('car_gallery')->insert([
                        'cid'=>$id,
                        'gallery'=>str_replace('\\','/',DS . 'static'.DS.'car'.DS.date('Ymd').DS.BaseUpload($data['thumb'][$i],'car'))
                        ]);
                }
            }
            return $id;
        });
    }
    public function getList($data){
        $pageSize = 5;
        $list = db('car')
            ->alias('c')
            ->field(['c.id','c.type','c.color','c.number','c.name','c.go_time','c.pass','c.phone','f.name'=>'from','t.name'=>'to','b.name'=>'bname'])
            ->join('__AREA__ f','c.from = f.id')
            ->join('__AREA__ t','c.to = t.id')
            ->join('__CAR_BRAND__ b','c.bid = b.id')
            ->where(['mid'=>session('userMember')->id])
            ->limit($data['page']*$pageSize,$pageSize)
            ->order('id desc')
            ->select();
        return $list;
    }
}
